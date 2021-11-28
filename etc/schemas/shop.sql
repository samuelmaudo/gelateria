CREATE TABLE `shop_gelati_flavor` (
    `id` VARCHAR(15) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `price` DECIMAL(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `shop_gelati_flavor`
    ADD PRIMARY KEY (`id`);

INSERT INTO `shop_gelati_flavor`
VALUES ('vanilla', 0.8), ('pistachio', 1.2), ('stracciatella', 1.0);

CREATE TABLE `shop_orders_order` (
    `id` CHAR(36) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `flavor_id` VARCHAR(15) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `scoops` TINYINT UNSIGNED NOT NULL,
    `syrup` TINYINT(1) NOT NULL,
    `total` DECIMAL(6,2) NOT NULL,
    `given_money` DECIMAL(6,2) NOT NULL,
    `returned_money` DECIMAL(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `shop_orders_order`
    ADD PRIMARY KEY (`id`),
    ADD KEY `shop_orders_order__flavor_id__idx` (`flavor_id`);

ALTER TABLE `shop_orders_order`
    ADD CONSTRAINT `shop_orders_order__flavor_id__fk`
        FOREIGN KEY (`flavor_id`)
            REFERENCES `shop_gelati_flavor` (`id`);
