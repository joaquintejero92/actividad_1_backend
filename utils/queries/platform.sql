-- create tabla platforms
CREATE TABLE `actividad1_backend`.`platforms` (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(256) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- inserts into platforms
INSERT INTO `platforms`(`name`) VALUES ('Netflix');
INSERT INTO `platforms`(`name`) VALUES ('HBO');
INSERT INTO `platforms`(`name`) VALUES ('MAX');
INSERT INTO `platforms`(`name`) VALUES ('Pluto TV');
INSERT INTO `platforms`(`name`) VALUES ('Amazon Prime');
INSERT INTO `platforms`(`name`) VALUES ('Disney+');
INSERT INTO `platforms`(`name`) VALUES ('Apple TV');