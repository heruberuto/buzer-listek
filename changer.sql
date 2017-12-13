-- Adminer 4.3.1 PostgreSQL dump


DROP TABLE IF EXISTS `color`;
CREATE SEQUENCE color_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 2 CACHE 1;

CREATE TABLE `color` (
`id` integer DEFAULT NOT NULL AUTO_INCREMENT,
`name` VARCHAR(32) NOT NULL,
) WITH (oids = false);

INSERT INTO `color` (`id`, `name`) VALUES
(0,	'Červená'),
(1,	'Zelená'),
(2,	'Modrá');

CREATE TABLE `user` (
`id` integer DEFAULT nextval('user_id_seq') NOT NULL,
`email` VARCHAR(64) NOT NULL,
`password` VARCHAR(64) NOT NULL,
`auth_key` VARCHAR(32) NOT NULL,
CONSTRAINT `pk_user` PRIMARY KEY (`id`),
CONSTRAINT `user_email` UNIQUE (`email`)
) WITH (oids = false);

COMMENT ON COLUMN `user`.`id` IS 'ID uživatele';

COMMENT ON COLUMN `user`.`email` IS 'E-mail';

COMMENT ON COLUMN `user`.`password` IS 'Heslo';

COMMENT ON COLUMN `user`.`auth_key` IS 'Autorizační klíč';

INSERT INTO `user` (`id`, `email`, `password`, `auth_key`) VALUES
(9,	'ullrich@stemmark.cz',	'$2y$13$X2pZWFoPWkMlubluIqrpdOTOK0e7iYML7iMw4qAejzH5zTEBG85uq',	'22ud6QYc78Xw-N_-fCl0KAbLd_t4pR_l'),
(10,	'fnfn@kjh.com',	'$2y$13$jHEGZQb4TAsXIcZY96k5ZeJKZ97kfmW3bBpBOGiv5VdfFlzkx8qrO',	'dVPtrsmRelX6Pwar0JlgFLOUOYJ_mZQH'),
(11,	'herbert.ullrich@yeti-studio.cz',	'$2y$13$oh2m7AdWldcC6PHgcXv2Ou/N4zueDDRaQYOOXsJ.OAl7w0ob4Zze.',	'0-fi3PwfX_tsD_mEZnOf0HZem0pIM2QR');

DROP TABLE IF EXISTS `habit`;
CREATE SEQUENCE resolution_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE `habit` (
`id` integer DEFAULT nextval('resolution_id_seq') NOT NULL,
`user_id` integer NOT NULL,
`since` date NOT NULL,
`until` date NOT NULL,
`name` VARCHAR(32) NOT NULL,
`condition` jsonb NOT NULL,
`note` text,
CONSTRAINT `pk_resolution` PRIMARY KEY (`id`),
CONSTRAINT `fk_resolution__user` FOREIGN KEY (user_id) REFERENCES `user`(id) NOT DEFERRABLE
) WITH (oids = false);

CREATE INDEX `habit_since` ON `habit` USING btree (`since`);

CREATE INDEX `habit_until` ON `habit` USING btree (`until`);

CREATE INDEX `idx_resolution__user` ON `habit` USING btree (`user_id`);

COMMENT ON COLUMN `habit`.`id` IS 'ID návyku';

COMMENT ON COLUMN `habit`.`user_id` IS 'Uživatel';

COMMENT ON COLUMN `habit`.`since` IS 'Začátek návyku';

COMMENT ON COLUMN `habit`.`until` IS 'Konec návyku';

COMMENT ON COLUMN `habit`.`name` IS 'Název';

COMMENT ON COLUMN `habit`.`condition` IS 'Podmínka splnění';

COMMENT ON COLUMN `habit`.`note` IS 'Poznámka';


DROP TABLE IF EXISTS `fulfillment`;
CREATE SEQUENCE fulfillment_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE `fulfillment` (
`id` integer DEFAULT nextval('fulfillment_id_seq') NOT NULL,
`day` date NOT NULL,
`habit_id` integer NOT NULL,
`value` VARCHAR(32) NOT NULL,
`note` VARCHAR(128) NOT NULL,
`color` integer NOT NULL,
CONSTRAINT `fulfillment_habit_day` UNIQUE (`habit_id`, `day`),
CONSTRAINT `pk_fulfillment` PRIMARY KEY (`id`),
CONSTRAINT `fk_fulfillment__color` FOREIGN KEY (color) REFERENCES color(id) NOT DEFERRABLE,
CONSTRAINT `fk_fulfillment__resolution` FOREIGN KEY (habit_id) REFERENCES habit(id) NOT DEFERRABLE
) WITH (oids = false);

CREATE INDEX `fulfillment_day` ON `fulfillment` USING btree (`day`);

CREATE INDEX `idx_fulfillment__color` ON `fulfillment` USING btree (`color`);

CREATE INDEX `idx_fulfillment__resolution` ON `fulfillment` USING btree (`habit_id`);

COMMENT ON COLUMN `fulfillment`.`id` IS 'ID plnění';

COMMENT ON COLUMN `fulfillment`.`day` IS 'Den';

COMMENT ON COLUMN `fulfillment`.`habit_id` IS 'Návyk';

COMMENT ON COLUMN `fulfillment`.`value` IS 'Hodnota';

COMMENT ON COLUMN `fulfillment`.`note` IS 'Poznámka';

COMMENT ON COLUMN `fulfillment`.`color` IS 'Barva vyhodnocení';


-- 2017-11-01 22:15:24.020137+01