-- Adminer 4.3.1 PostgreSQL dump
CREATE TABLE `color` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL
);

CREATE TABLE `user` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `email` VARCHAR(64) UNIQUE NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `auth_key` VARCHAR(32) NOT NULL
);

CREATE TABLE `habitlist` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `user_id` INTEGER NOT NULL,
  `since` DATE NOT NULL,
  `until` DATE NOT NULL,
  `note` VARCHAR(255)
);

CREATE INDEX `idx_habitlist__user_id` ON `habitlist` (`user_id`);

ALTER TABLE `habitlist` ADD CONSTRAINT `fk_habitlist__user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

CREATE TABLE `habit` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  `condition` JSON NOT NULL,
  `note` VARCHAR(255),
  `habit_list_id` INTEGER NOT NULL
);

CREATE INDEX `idx_habit__habit_list_id` ON `habit` (`habit_list_id`);

ALTER TABLE `habit` ADD CONSTRAINT `fk_habit__habit_list_id` FOREIGN KEY (`habit_list_id`) REFERENCES `habitlist` (`id`);

CREATE TABLE `fulfillment` (
  `id` INTEGER NOT NULL,
  `day` DATE NOT NULL,
  `value` VARCHAR(256) NOT NULL,
  `habit_id` INTEGER NOT NULL,
  `note` VARCHAR(256) NOT NULL,
  `color` INTEGER NOT NULL,
  CONSTRAINT `pk_fulfillment` PRIMARY KEY (`id`, `note`)
);

CREATE INDEX `idx_fulfillment__color` ON `fulfillment` (`color`);

CREATE INDEX `idx_fulfillment__habit_id` ON `fulfillment` (`habit_id`);

ALTER TABLE `fulfillment` ADD CONSTRAINT `fk_fulfillment__color` FOREIGN KEY (`color`) REFERENCES `color` (`id`);

ALTER TABLE `fulfillment` ADD CONSTRAINT `fk_fulfillment__habit_id` FOREIGN KEY (`habit_id`) REFERENCES `habit` (`id`)

INSERT INTO `color` (`id`, `name`) VALUES
(0,	'Červená'),
(1,	'Zelená'),
(2,	'Modrá');

COMMENT ON COLUMN `user`.`id` IS 'ID uživatele';

COMMENT ON COLUMN `user`.`email` IS 'E-mail';

COMMENT ON COLUMN `user`.`password` IS 'Heslo';

COMMENT ON COLUMN `user`.`auth_key` IS 'Autorizační klíč';

COMMENT ON COLUMN `habit`.`id` IS 'ID návyku';

COMMENT ON COLUMN `habit`.`user_id` IS 'Uživatel';

COMMENT ON COLUMN `habit_list`.`since` IS 'Začátek';

COMMENT ON COLUMN `habit_list`.`until` IS 'Konec';

COMMENT ON COLUMN `habit`.`name` IS 'Název';

COMMENT ON COLUMN `habit`.`condition` IS 'Podmínka splnění';

COMMENT ON COLUMN `habit`.`note` IS 'Poznámka';

COMMENT ON COLUMN `fulfillment`.`id` IS 'ID plnění';

COMMENT ON COLUMN `fulfillment`.`day` IS 'Den';

COMMENT ON COLUMN `fulfillment`.`habit_id` IS 'Návyk';

COMMENT ON COLUMN `fulfillment`.`value` IS 'Hodnota';

COMMENT ON COLUMN `fulfillment`.`note` IS 'Poznámka';

COMMENT ON COLUMN `fulfillment`.`color` IS 'Barva vyhodnocení';


-- 2017-11-01 22:15:24.020137+01