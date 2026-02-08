USE `sistemainv` ;

-- -----------------------------------------------------
-- Table `mydb`.`colores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemainv`.`colores` (
  `id_colores` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_colores`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`marcas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemainv`.`marcas` (
  `id_marcas` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_marcas`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`mantenimientos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemainv`.`mantenimientos` (
  `id_mantenimientos` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NOT NULL,
  `fecha` VARCHAR(45) NOT NULL,
  `Observaciones` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_mantenimientos`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `prueba_inv`.`ccompu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemainv`.`ccompu` (
  `id_ccompus` INT(11) NOT NULL AUTO_INCREMENT,
  `procesador` VARCHAR(45) NOT NULL,
  `tarjeta` VARCHAR(45) NOT NULL,
  `ram` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_ccompus`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `prueba_inv`.`tipos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemainv`.`tipos` (
  `id_tipos` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_tipos`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `prueba_inv`.`estados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemainv`.`estados` (
  `id_estados` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_estados`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `prueba_inv`.`equipos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemainv`.`equipos` (
  `id_equipos` INT(11) NOT NULL AUTO_INCREMENT,
  `marca` VARCHAR(45) NOT NULL,
  `modelo` VARCHAR(45) NOT NULL,
  `nserie` VARCHAR(45) NOT NULL,
  `color` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NULL DEFAULT NULL,
  `id_ccompus` INT(11) NOT NULL,
  `id_tipos` INT(11) NOT NULL,
  `id_estados` INT(11) NOT NULL,
  `id_colores` INT(11) NOT NULL,
  `id_marcas` INT(11) NOT NULL,
  `id_mantenimientos` INT(11) NOT NULL,
  PRIMARY KEY (`id_equipos`),
  CONSTRAINT `fk_equipos_ccompu`
    FOREIGN KEY (`id_ccompus`)
    REFERENCES `sistemainv`.`ccompu` (`id_ccompus`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_tipos1`
    FOREIGN KEY (`id_tipos`)
    REFERENCES `sistemainv`.`tipos` (`id_tipos`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_estados1`
    FOREIGN KEY (`id_estados`)
    REFERENCES `sistemainv`.`estados` (`id_estados`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_equipos_colores1`
    FOREIGN KEY (`id_colores`)
    REFERENCES `sistemainv`.`colores` (`id_colores`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipos_marcas1`
    FOREIGN KEY (`id_marcas`)
    REFERENCES `sistemainv`.`marcas` (`id_marcas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipos_mantenimientos1`
    FOREIGN KEY (`id_mantenimientos`)
    REFERENCES `sistemainv`.`mantenimientos` (`id_mantenimientos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;