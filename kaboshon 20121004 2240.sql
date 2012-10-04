-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 5.0.97.1
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 04.10.2012 22:41:38
-- Версия сервера: 5.1.53-community
-- Версия клиента: 4.1

-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

-- 
-- Установка базы данных по умолчанию
--
USE kaboshon;

--
-- Описание для таблицы shop_categories
--
DROP TABLE IF EXISTS shop_categories;
CREATE TABLE shop_categories (
  category_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  descr VARCHAR(255) DEFAULT NULL,
  meta_descr VARCHAR(255) DEFAULT NULL,
  meta_keywords VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (category_id),
  UNIQUE INDEX name (name)
)
ENGINE = INNODB
AUTO_INCREMENT = 32
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы shop_discounts
--
DROP TABLE IF EXISTS shop_discounts;
CREATE TABLE shop_discounts (
  discount_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (discount_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы shop_groups
--
DROP TABLE IF EXISTS shop_groups;
CREATE TABLE shop_groups (
  group_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  discount INT(2) UNSIGNED DEFAULT 0,
  PRIMARY KEY (group_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы shop_orders_history
--
DROP TABLE IF EXISTS shop_orders_history;
CREATE TABLE shop_orders_history (
  order_id INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (order_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы shop_product_photos
--
DROP TABLE IF EXISTS shop_product_photos;
CREATE TABLE shop_product_photos (
  photo_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) DEFAULT NULL,
  file VARCHAR(255) NOT NULL,
  product_id INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (photo_id),
  UNIQUE INDEX file (file)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы shop_user_info
--
DROP TABLE IF EXISTS shop_user_info;
CREATE TABLE shop_user_info (
  user_info_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT(11) UNSIGNED NOT NULL,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) DEFAULT NULL,
  middle_name VARCHAR(100) DEFAULT NULL,
  address VARCHAR(255) NOT NULL,
  city VARCHAR(60) NOT NULL,
  territory VARCHAR(100) DEFAULT NULL,
  country VARCHAR(60) NOT NULL,
  phone VARCHAR(12) DEFAULT NULL,
  PRIMARY KEY (user_info_id),
  INDEX users_info (user_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 8
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы shop_categories_xref
--
DROP TABLE IF EXISTS shop_categories_xref;
CREATE TABLE shop_categories_xref (
  parent_category_id INT(10) UNSIGNED NOT NULL DEFAULT 0,
  child_category_id INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (parent_category_id, child_category_id),
  CONSTRAINT childs FOREIGN KEY (child_category_id)
    REFERENCES shop_categories(category_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT parent FOREIGN KEY (parent_category_id)
    REFERENCES shop_categories(category_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 16384
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы shop_orders
--
DROP TABLE IF EXISTS shop_orders;
CREATE TABLE shop_orders (
  order_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_info_id INT(11) UNSIGNED DEFAULT NULL,
  status TINYINT(10) DEFAULT 0,
  PRIMARY KEY (order_id),
  CONSTRAINT user_info FOREIGN KEY (user_info_id)
    REFERENCES shop_user_info(user_info_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 11
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы shop_products
--
DROP TABLE IF EXISTS shop_products;
CREATE TABLE shop_products (
  product_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(10, 2) UNSIGNED NOT NULL,
  category_id INT(11) UNSIGNED DEFAULT NULL,
  descr TEXT DEFAULT NULL,
  PRIMARY KEY (product_id),
  CONSTRAINT category FOREIGN KEY (category_id)
    REFERENCES shop_categories(category_id) ON DELETE SET NULL ON UPDATE SET NULL
)
ENGINE = INNODB
AUTO_INCREMENT = 5
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы shop_users
--
DROP TABLE IF EXISTS shop_users;
CREATE TABLE shop_users (
  user_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  login VARCHAR(16) NOT NULL,
  `password` VARCHAR(32) NOT NULL,
  email VARCHAR(129) NOT NULL,
  group_id INT(11) UNSIGNED DEFAULT NULL,
  permission VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (user_id),
  UNIQUE INDEX email (email),
  INDEX FK_shop_users_shop_groups_group_id (group_id),
  UNIQUE INDEX login (login),
  CONSTRAINT FK_users_groups FOREIGN KEY (group_id)
    REFERENCES shop_groups(group_id) ON DELETE SET NULL ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 9
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы shop_order_items
--
DROP TABLE IF EXISTS shop_order_items;
CREATE TABLE shop_order_items (
  order_item_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  order_id INT(11) UNSIGNED NOT NULL,
  product_id INT(11) UNSIGNED NOT NULL,
  quantity INT(11) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (order_item_id),
  CONSTRAINT items_order FOREIGN KEY (order_id)
    REFERENCES shop_orders(order_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT items_product FOREIGN KEY (product_id)
    REFERENCES shop_products(product_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 11
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8
COLLATE utf8_general_ci;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;