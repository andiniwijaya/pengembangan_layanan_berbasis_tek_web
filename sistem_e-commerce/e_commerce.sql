-- DATABASE: ecommerce_mvc
CREATE DATABASE IF NOT EXISTS `e_commerce`
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE `e_commerce`;

-- TABLE: users
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin','kasir') NOT NULL DEFAULT 'kasir',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB;

-- TABLE: categories
CREATE TABLE `categories` (
    `id` INT AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- TABLE: suppliers
CREATE TABLE `suppliers` (
    `id` INT AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20),
    `address` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- TABLE: products
CREATE TABLE `products` (
    `id` INT AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `stock` INT DEFAULT 0,

    `category_id` INT,
    `supplier_id` INT,

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),

    CONSTRAINT `fk_products_category`
        FOREIGN KEY (`category_id`)
        REFERENCES `categories` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE,

    CONSTRAINT `fk_products_supplier`
        FOREIGN KEY (`supplier_id`)
        REFERENCES `suppliers` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- TABLE: customers (OPSIONAL)
CREATE TABLE `customers` (
    `id` INT AUTO_INCREMENT,
    `name` VARCHAR(150),
    `phone` VARCHAR(20),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- TABLE: transactions
CREATE TABLE `transactions` (
    `id` INT AUTO_INCREMENT,

    `transaction_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `total` DECIMAL(12,2) DEFAULT 0,

    `user_id` INT,
    `customer_id` INT,

    PRIMARY KEY (`id`),

    CONSTRAINT `fk_transactions_user`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE,

    CONSTRAINT `fk_transactions_customer`
        FOREIGN KEY (`customer_id`)
        REFERENCES `customers` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- TABLE: transaction_details
CREATE TABLE `transaction_details` (
    `id` INT AUTO_INCREMENT,

    `transaction_id` INT,
    `product_id` INT,

    `quantity` INT NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `subtotal` DECIMAL(12,2) NOT NULL,

    PRIMARY KEY (`id`),

    CONSTRAINT `fk_detail_transaction`
        FOREIGN KEY (`transaction_id`)
        REFERENCES `transactions` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT `fk_detail_product`
        FOREIGN KEY (`product_id`)
        REFERENCES `products` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


-- DATA AWAL

-- PASSWORD: 123456
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('admin', '$2y$10$9F0rm6dNt9w3ahDLWuOwsuMD2BPv4AcmctG52vD73b12wtYEJ/PiC', 'admin'),
('kasir', '$2y$10$9F0rm6dNt9w3ahDLWuOwsuMD2BPv4AcmctG52vD73b12wtYEJ/PiC', 'kasir');

INSERT INTO `categories` (`name`) VALUES
('Elektronik'),
('Fashion'),
('Makanan');

INSERT INTO `suppliers` (`name`, `phone`, `address`) VALUES
('PT Sumber Jaya', '08123456789', 'Jakarta'),
('CV Makmur', '08234567890', 'Bandung');

INSERT INTO `products` (`name`, `price`, `stock`, `category_id`, `supplier_id`) VALUES
('Laptop', 8000000, 10, 1, 1),
('Kaos', 100000, 50, 2, 2),
('Snack', 20000, 100, 3, 2);

INSERT INTO `customers` (`name`, `phone`) VALUES
('Umum', '-'),
('Budi', '0812345678');