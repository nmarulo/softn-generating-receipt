-- -----------------------------------------------------
-- Table `clients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clients` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_name` VARCHAR(37) NOT NULL,
  `client_address` VARCHAR(37) NULL,
  `client_identification_document` VARCHAR(10) NOT NULL,
  `client_city` VARCHAR(37) NULL,
  `client_number_receipts` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `product_name` VARCHAR(37) NOT NULL,
  `product_price_unit` DECIMAL(10,2) NOT NULL,
  `product_reference` VARCHAR(6) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `receipts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `receipts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `receipt_type` VARCHAR(20) NOT NULL,
  `receipt_number` INT NULL,
  `receipt_date` DATE NOT NULL,
  `receipt_license_plate` VARCHAR(20) NULL,
  `client_id` INT NOT NULL,
  PRIMARY KEY (`id`, `client_id`),
  CONSTRAINT `fk_Receipts_Clients`
    FOREIGN KEY (`client_id`)
    REFERENCES `clients` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_Receipts_Clients_id` ON `receipts` (`client_id` ASC);


-- -----------------------------------------------------
-- Table `options`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `options` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `option_key` VARCHAR(45) NULL,
  `option_value` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `option_key_UNIQUE` ON `options` (`option_key` ASC);


-- -----------------------------------------------------
-- Table `receipts_has_products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `receipts_has_products` (
  `receipt_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `receipt_product_unit` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`receipt_id`, `product_id`),
  CONSTRAINT `fk_Receipts_has_Products_Receipt`
    FOREIGN KEY (`receipt_id`)
    REFERENCES `receipts` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Receipts_has_Products_Product`
    FOREIGN KEY (`product_id`)
    REFERENCES `products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_Receipts_has_Products_Product_id` ON `receipts_has_products` (`product_id` ASC);

CREATE INDEX `fk_Receipts_has_Products_Receipt_id` ON `receipts_has_products` (`receipt_id` ASC);

-- -----------------------------------------------------
-- Data for table `options`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `options` (`id`, `option_key`, `option_value`) VALUES (1, 'option_name', 'Nicolas');
INSERT INTO `options` (`id`, `option_key`, `option_value`) VALUES (2, 'option_identification_document', '55588414J');
INSERT INTO `options` (`id`, `option_key`, `option_value`) VALUES (3, 'option_address', '1261 Aliquam Avenue');
INSERT INTO `options` (`id`, `option_key`, `option_value`) VALUES (4, 'option_phone_number', '1234567890');
INSERT INTO `options` (`id`, `option_key`, `option_value`) VALUES (5, 'option_web_site', 'http://www.softn.red/');
INSERT INTO `options` (`id`, `option_key`, `option_value`) VALUES (6, 'option_iva', '21');

COMMIT;
