# My Project

This project involves several database tables, including `user_cart`, `user`, `products`, `items_dilivered`, and `buyer_purchases`, to be run on XAMPP.

## Requirements

- XAMPP
- Web browser

## Step-by-Step Guide

### Step 1: Install XAMPP

2. Start the Apache and MySQL services from the XAMPP Control Panel.

### Step 2: Create Database and Tables
1. Open your browser and navigate to `http://localhost/phpmyadmin`.
2. Create a new database:
   - Click on `New` in the left sidebar.
   - Enter a database name (e.g., `mydatabase`).
   - Click `Create`.

3. Create the required tables by running the following SQL commands in the SQL tab:

```sql
CREATE TABLE `user_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(259) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `contact` bigint(20) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `pcs` varchar(259) NOT NULL,
  `image_path` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `items_dilivered` (
  `username` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_name` varchar(259) NOT NULL,
  `delivery_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `buyer_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_date` date NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_name` varchar(259) NOT NULL,
  `username` varchar(240) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
