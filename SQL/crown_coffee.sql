-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 07:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crown_coffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `published_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`post_id`, `title`, `content`, `image`, `published_date`) VALUES
(1, 'What Is Third Wave Coffee?', 'As the taste subtleties of a vineyard’s terroir made us appreciate wine, third-wave coffee invited us to notice how origin impacts the flavors of beans. Origins like Ethiopia’s Yirgacheffe region or Guatemala’s Huehuetenango estates, which we would never have heard of otherwise.\r\n\r\nThis coffee revolution – which took shape in the early 2000s – literally changed how we thought about coffee. It promoted coffee as more than a mere commodity. It also prioritized lighter roast profiles to bring out a bean’s flavor characteristics. As a result, precise brewing methods became the norm. And so did direct relationships with producers.\r\n\r\nBut what was even more fascinating wasn’t just the concern for quality. The third coffee wave also made coffee connoisseurship democratic. Everyone, and I mean everyone, learned more about the bean and how to brew it. If you’re a veteran barista (like me) you’ll remember how this movement opened doors to coffee flavor in a way previously unknown.', 'blog_684e30646a25e1.26946545.jpg', '2025-06-14 00:00:00'),
(2, 'What Makes Instant Coffee Instant?', 'What’s the deal with instant coffee anyway? How does that powdery stuff in a jar transform into coffee in seconds flat?\r\n\r\nInstant coffee is already brewed, dehydrated coffee. It reconstitutes when you add water. To make instant coffee, industry bigwigs start with actual roasted coffee beans. Most often they use Robusta, which is cheaper and has more caffeine.\r\n\r\nHowever, premium brands guarantee 100% Arabica or blends of the two species. They then roast, grind and brew these beans into a super-concentrated coffee extract.\r\n\r\nThen comes the magic: Dehydration. That’s what makes “instant coffee” instant. Manufacturers use one of two dehydration methods:', 'blog_684e3b3b9cf5f8.38872551.jpg', '2025-06-14 00:00:00'),
(3, 'Latte Recipes to Make at Home Fast', 'Check out these 6 easy latte recipes to make at home. Quick and delicious lattes can be made in a snap at home.\r\n\r\nWe get it. You’re in a hurry and you crave a latte but you’re not nearby a The Coffee Bean & Tea Leaf® cafe. Sometimes you just want a sweet and creamy latte at home. Check out these six easy latte recipes. Follow the simple instructions below to make a vanilla latte, a “PSL” Pumpkin Spice Latte, a Chai Latte, a Matcha Green Tea latte, an Iced Latte or a Mocha Latte.\r\n\r\nEASY LATTE RECIPE STEPS\r\n\r\n1. Brew Your Favorite Coffee or Tea\r\n\r\nPro Tip: Try our wonderful Espresso Roast Blends. It’s the same espresso coffee we use in our cafes and is the foundation to our legendary silky lattes. We sell the same espresso beans and grinds which are available to purchase for home use.\r\n\r\n2. Add Delicious Flavors\r\n\r\nAdd 1/3 cup* of our signature flavoring powders from The Coffee Bean & Tea Leaf to your cup of coffee, tea, or espresso. (*or more or less to suit your flavor preference). Signature flavors powders from The Coffee Bean & Tea Leaf provide a wonderfully sweet and creamy taste, creating an instant latte. They taste amazing hot, iced or blended. Try French Deluxe™ Vanilla, Special Dutch™ Chocolate, Cookie Butter Powder, Hazelnut, White Chocolate, and two no-sugar-added options.', 'blog_68523f2d119be8.70499575.jpg', '2025-06-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `province` varchar(5) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `gst` decimal(10,2) NOT NULL,
  `pst` decimal(10,2) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_status`, `order_date`, `fullname`, `email`, `address`, `province`, `subtotal`, `gst`, `pst`, `total`) VALUES
(14, NULL, 'Completed', '2025-06-15 02:44:19', 'Jatin Thummar', 'jbthummar87@gmail.com', '43 INDIGO ST', 'ON', 0.00, 0.00, 0.00, 0.00),
(21, NULL, 'Completed', '2025-06-17 00:03:53', 'Jatin Thummar', 'jbthummar52@gmail.com', '1108-225 Harvard Pl', 'ON', 0.00, 0.00, 0.00, 0.00),
(22, NULL, 'Completed', '2025-06-17 00:06:50', 'Jatin Thummar', 'jbthummar52@gmail.com', '87,SHIVAM-RAW-HOUSE,MAHADEV CHAWK\r\nMota Varachha', 'BC', 0.00, 0.00, 0.00, 0.00),
(23, 9, 'Completed', '2025-06-17 00:15:39', 'Jatin Thummar', 'jbthummar52@gmail.com', '87,SHIVAM-RAW-HOUSE,MAHADEV CHAWK\r\nMota Varachha', 'BC', 35.00, 1.75, 2.45, 39.20),
(24, 9, 'Completed', '2025-06-17 00:16:27', 'Jatin Thummar', 'jbthummar52@gmail.com', '30 Duggan Drive', 'ON', 70.00, 3.50, 4.90, 78.40),
(25, 9, 'Completed', '2025-06-17 00:51:25', 'Jatin Thummar', 'jbthummar87@gmail.com', '43 INDIGO ST', 'ON', 35.00, 1.75, 2.45, 39.20);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `item_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `product_name`, `quantity`, `item_price`) VALUES
(9, 14, 7, 'Light Roast', 5, NULL),
(16, 21, 8, 'Dark Roasted', 1, NULL),
(17, 22, 7, 'Light Roast', 1, NULL),
(18, 23, 8, 'Dark Roasted', 1, 35.00),
(19, 24, 7, 'Light Roast', 2, 25.00),
(20, 24, 6, 'Medium Coffee', 1, 20.00),
(21, 25, 8, 'Dark Roasted', 1, 35.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `roast_level` varchar(50) DEFAULT NULL,
  `flavor_notes` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `roast_level`, `flavor_notes`, `category`, `stock_quantity`, `image_url`) VALUES
(6, 'Medium Coffee', 'Coffee', 20.00, 'Light', 'Light', 'Medium', 4, 'medium1.jpg'),
(7, 'Light Roast', 'Light roasted hot coffee beans which fills every good', 25.00, 'Light', 'Light roast ', 'Light', 8, 'light3.jpg'),
(8, 'Dark Roasted', 'dark coffee beans', 35.00, 'Dark', 'dark', 'Dark', 4, 'dark1.jpg'),
(9, 'Dark Coffee Beans', 'dark Coffee', 35.00, 'Dark', 'dark', 'Dark', 9, 'coffee1.png'),
(10, 'Medium Coffee', 'Every Happy Meal Coffee', 27.00, 'Medium', 'Medium Blend', 'Medium', 10, 'medium2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone_number`, `address`, `role`) VALUES
(8, 'Jatin Thummar', 'jbthummar52@gmail.com', '$2y$10$A88VB5lOEmaMqYaDoXvjMerOqyhFzuSDrffIKqxemdN5x5C7O9UWS', '3828850054', '1108-225 Harvard Pl', 'user'),
(9, 'Jeel', 'jeel@gmail.com', '$2y$10$SCu4lexMlWaWrJU9Phk3PeNTaAcceeDnmnBYggadVWtMUrmJa/oUu', '1234567890', '1108-225 Harvard Pl', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
