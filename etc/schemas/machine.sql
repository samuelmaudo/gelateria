CREATE TABLE `machine_drinks_drink` (
    `id` VARCHAR(15) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `price` DECIMAL(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `machine_drinks_drink`
    ADD PRIMARY KEY (`id`);

INSERT INTO `machine_drinks_drink`
VALUES ('tea', 0.4), ('coffee', 0.5), ('chocolate', 0.6);

CREATE TABLE `machine_orders_order` (
    `id` CHAR(36) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `drink_id` VARCHAR(15) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `sugars` TINYINT UNSIGNED NOT NULL,
    `extra_hot` TINYINT(1) NOT NULL,
    `total` DECIMAL(6,2) NOT NULL,
    `given_money` DECIMAL(6,2) NOT NULL,
    `returned_money` DECIMAL(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `machine_orders_order`
    ADD PRIMARY KEY (`id`),
    ADD KEY `machine_orders_order__drink_id__idx` (`drink_id`);

ALTER TABLE `machine_orders_order`
    ADD CONSTRAINT `machine_orders_order__drink_id__fk`
        FOREIGN KEY (`drink_id`)
            REFERENCES `machine_drinks_drink` (`id`);
