-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema inmobiliario
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `inmobiliario` ;

-- -----------------------------------------------------
-- Schema inmobiliario
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `inmobiliario` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
SHOW WARNINGS;
USE `inmobiliario` ;

-- -----------------------------------------------------
-- Table `inmobiliario`.`user_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`user_type` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`user_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL,
  `description` VARCHAR(100) NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`user_state`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`user_state` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`user_state` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL,
  `description` VARCHAR(100) NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`identificator_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`identificator_type` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`identificator_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL,
  `description` VARCHAR(100) NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`user` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_type_id` INT NOT NULL,
  `user_state_id` INT NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `lastname` VARCHAR(50) NOT NULL,
  `identificator` VARCHAR(50) NOT NULL,
  `identificator_type_id` INT NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `fax` VARCHAR(20) NULL,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `sex` CHAR(1) NULL,
  `auth_key` VARCHAR(50) NULL,
  `access_token` VARCHAR(50) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `image` VARCHAR(100) NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_user_type1`
    FOREIGN KEY (`user_type_id`)
    REFERENCES `inmobiliario`.`user_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_user_state1`
    FOREIGN KEY (`user_state_id`)
    REFERENCES `inmobiliario`.`user_state` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_identificator_type1`
    FOREIGN KEY (`identificator_type_id`)
    REFERENCES `inmobiliario`.`identificator_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_user_user_type1_idx` ON `inmobiliario`.`user` (`user_type_id` ASC);

SHOW WARNINGS;
CREATE INDEX `fk_user_user_state1_idx` ON `inmobiliario`.`user` (`user_state_id` ASC);

SHOW WARNINGS;
CREATE UNIQUE INDEX `email_UNIQUE` ON `inmobiliario`.`user` (`email` ASC);

SHOW WARNINGS;
CREATE UNIQUE INDEX `username_UNIQUE` ON `inmobiliario`.`user` (`username` ASC);

SHOW WARNINGS;
CREATE INDEX `fk_user_identificator_type1_idx` ON `inmobiliario`.`user` (`identificator_type_id` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`property_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`property_type` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`property_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL,
  `description` VARCHAR(100) NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`property_state`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`property_state` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`property_state` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL,
  `description` VARCHAR(100) NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`property`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`property` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`property` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `property_type_id` INT NOT NULL,
  `property_state_id` INT NOT NULL,
  `price` DOUBLE NOT NULL,
  `money` CHAR(1) NOT NULL,
  `comission` DOUBLE NOT NULL,
  `area` DOUBLE NULL,
  `bathroom` DOUBLE NULL,
  `bedroom` DOUBLE NULL,
  `longitude` VARCHAR(45) NULL,
  `latitude` VARCHAR(45) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `date_start` TIMESTAMP NULL,
  `date_end` TIMESTAMP NULL,
  `owner` VARCHAR(50) NOT NULL,
  `owner_email` VARCHAR(100) NOT NULL,
  `owner_phone` VARCHAR(20) NOT NULL,
  `adress` VARCHAR(100) NULL,
  `video_url` VARCHAR(150) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_property_property_type1`
    FOREIGN KEY (`property_type_id`)
    REFERENCES `inmobiliario`.`property_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_property_property_state1`
    FOREIGN KEY (`property_state_id`)
    REFERENCES `inmobiliario`.`property_state` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_property_property_type1_idx` ON `inmobiliario`.`property` (`property_type_id` ASC);

SHOW WARNINGS;
CREATE INDEX `fk_property_property_state1_idx` ON `inmobiliario`.`property` (`property_state_id` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`logs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`logs` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`logs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `description` VARCHAR(400) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`, `user_id`),
  CONSTRAINT `fk_logs_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `inmobiliario`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_logs_user1_idx` ON `inmobiliario`.`logs` (`user_id` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`property_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`property_details` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`property_details` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL,
  `description` VARCHAR(100) NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`access_property_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`access_property_details` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`access_property_details` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `property_id` INT NOT NULL,
  `property_details_id` INT NOT NULL,
  `quantity` DOUBLE NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`, `property_id`, `property_details_id`),
  CONSTRAINT `fk_access_property_details_property1`
    FOREIGN KEY (`property_id`)
    REFERENCES `inmobiliario`.`property` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_access_property_details_property_details1`
    FOREIGN KEY (`property_details_id`)
    REFERENCES `inmobiliario`.`property_details` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_access_property_details_property1_idx` ON `inmobiliario`.`access_property_details` (`property_id` ASC);

SHOW WARNINGS;
CREATE INDEX `fk_access_property_details_property_details1_idx` ON `inmobiliario`.`access_property_details` (`property_details_id` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`property_images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`property_images` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`property_images` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `property_id` INT NOT NULL,
  `name` VARCHAR(100) NULL,
  `order` INT NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`, `property_id`),
  CONSTRAINT `fk_property_images_property1`
    FOREIGN KEY (`property_id`)
    REFERENCES `inmobiliario`.`property` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_property_images_property1_idx` ON `inmobiliario`.`property_images` (`property_id` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`controller`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`controller` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`controller` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `controller` VARCHAR(50) NOT NULL,
  `name` VARCHAR(50) NULL,
  `description` VARCHAR(100) NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`access_user_control`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`access_user_control` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`access_user_control` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `controller_id` INT NOT NULL,
  `active` TINYINT(1) NULL,
  PRIMARY KEY (`id`, `user_id`, `controller_id`),
  CONSTRAINT `fk_access_user_control_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `inmobiliario`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_access_user_control_controller1`
    FOREIGN KEY (`controller_id`)
    REFERENCES `inmobiliario`.`controller` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_access_user_control_user1_idx` ON `inmobiliario`.`access_user_control` (`user_id` ASC);

SHOW WARNINGS;
CREATE INDEX `fk_access_user_control_controller1_idx` ON `inmobiliario`.`access_user_control` (`controller_id` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `inmobiliario`.`user_like_property`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inmobiliario`.`user_like_property` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `inmobiliario`.`user_like_property` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `property_id` INT NOT NULL,
  PRIMARY KEY (`id`, `user_id`, `property_id`),
  CONSTRAINT `fk_user_like_property_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `inmobiliario`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_like_property_property1`
    FOREIGN KEY (`property_id`)
    REFERENCES `inmobiliario`.`property` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_user_like_property_user1_idx` ON `inmobiliario`.`user_like_property` (`user_id` ASC);

SHOW WARNINGS;
CREATE INDEX `fk_user_like_property_property1_idx` ON `inmobiliario`.`user_like_property` (`property_id` ASC);

SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
