#SET FOREIGN_KEY_CHECKS=0;

Drop Database IF EXISTS tagPeople;
Create Database tagPeople;
USE tagPeople;


CREATE TABLE tags
(
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`id`)
) ENGINE=INNODB;


CREATE TABLE users
(
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`id`)
) ENGINE=INNODB;

#CREATE TABLE tweets
#(
#  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
#  `text` INT UNSIGNED NOT NULL,
#  PRIMARY KEY (`id`),
#  INDEX (`id`)
#) ENGINE=INNODB;

CREATE TABLE user_tag
(
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` INT UNSIGNED NOT NULL,
  `id_tag` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`id`)
) ENGINE=INNODB;


DROP VIEW IF EXISTS vTags;
CREATE VIEW vTags
AS
  SELECT t.tag, u.username
  FROM user_tag AS ut
    INNER JOIN tags AS t
    ON ut.id_tag = t.id
    INNER JOIN users AS u
    ON ut.id_user = u.id
  GROUP BY t.tag;