CREATE TABLE `shop_gelati_gelato` (
    `id` VARCHAR(15) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `price` DECIMAL(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `shop_gelati_gelato`
    ADD PRIMARY KEY (`id`);

INSERT INTO `shop_gelati_gelato`
VALUES ('vanilla', 0.4), ('pistachio', 0.5), ('stracciatella', 0.6);

CREATE TABLE `shop_orders_order` (
    `id` CHAR(36) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `gelato_id` VARCHAR(15) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `scoops` TINYINT UNSIGNED NOT NULL,
    `syrup` TINYINT(1) NOT NULL,
    `total` DECIMAL(6,2) NOT NULL,
    `given_money` DECIMAL(6,2) NOT NULL,
    `returned_money` DECIMAL(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `shop_orders_order`
    ADD PRIMARY KEY (`id`),
    ADD KEY `shop_orders_order__gelato_id__idx` (`gelato_id`);

ALTER TABLE `shop_orders_order`
    ADD CONSTRAINT `shop_orders_order__gelato_id__fk`
        FOREIGN KEY (`gelato_id`)
            REFERENCES `shop_gelati_gelato` (`id`);
