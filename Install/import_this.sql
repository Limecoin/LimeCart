---
--- Installation SQL script
--- Thanks to Scottie (Vual)
---

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(60) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_desc` tinytext NOT NULL,
  `product_img_name` varchar(60) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code` (`product_code`)
) AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `orders` (
  `name` text NOT NULL,
  `formatted_address` text NOT NULL,
  `postal_code` text NOT NULL,
  `sublocality` text NOT NULL,
  `country_short` text NOT NULL,
  `street_number` int(11) NOT NULL,
  `locality` text NOT NULL,
  `country` text NOT NULL,
  `state` text NOT NULL,
  `coin_address` text NOT NULL,
  `email` text NOT NULL,
  `order_number` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `product_name`, `product_desc`, `product_img_name`, `price`) VALUES
(1, 'PD1001', 'Some Phone', '', 'Ia menggunakan kamus yang mengandungi lebih 200 ayat Latin, bersama model dan struktur ayat Latin, untuk menghasilkan Lorem Ipsum yang munasabah','scratchcard.jpg', 200.50),
(2, 'PD1002', 'Some TV', 'Ia menggunakan kamus yang mengandungi lebih 200 ayat Latin, bersama model dan struktur ayat Latin, untuk menghasilkan Lorem Ipsum yang munasabah.', 'usbcard.jpg', 500.85),


INSERT INTO `orders` (`name`, `formatted_address`, `postal_code`, `sublocality`, `country_short`, `street_number`, `locality`, `country`, `state`, `coin_address`, `order_number`) VALUES
('Scottie', 'some street somewhere the moon', '1337', 'suburb', 'AU' ,1 , 'Sydney','Australia', 'Tasmania', 'Lfxu6TjMXJsfSyce1ufWj2uVcoAALrRhmS','dev@coinfreaks.com', 0 ),

---