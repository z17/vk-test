CREATE TABLE IF NOT EXISTS `product` (
  id          INT(11) UNSIGNED      NOT NULL AUTO_INCREMENT,
  name        VARCHAR(255)          NOT NULL,
  description TEXT                  NOT NULL,
  price       MEDIUMINT(7) UNSIGNED NOT NULL,
  img         VARCHAR(255)          NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


ALTER TABLE `product`
  ADD KEY `index_product_price` (`price`);