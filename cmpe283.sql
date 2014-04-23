DROP DATABASE IF EXISTS cmpe283;
CREATE DATABASE cmpe283 ;
USE cmpe283;

GRANT ALL PRIVILEGES ON cmpe283.* 
TO 'group3'@'localhost'
IDENTIFIED BY 'sjsugroup3';

DROP TABLE IF EXISTS average_weekly_prices;
CREATE TABLE average_weekly_prices (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `week` int(2) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=83 ;

--
-- Dumping data for table `average_weekly_prices`
--

INSERT INTO average_weekly_prices (`id`, `year`, `week`, `price`) VALUES
(1, 2013, 1, 62.32),
(2, 2013, 2, 52.45),
(3, 2013, 3, 52.20),
(4, 2013, 4, 51.28),
(5, 2013, 5, 52.20),
(6, 2013, 6, 53.20),
(7, 2013, 7, 51.70),
(8, 2013, 8, 52.61),
(9, 2013, 9, 56.48),
(10, 2013, 10, 56.48),
(11, 2013, 11, 58.08),
(12, 2013, 12, 58.52),
(13, 2013, 13, 57.75),
(14, 2013, 14, 58.32),
(15, 2013, 15, 59.95),
(16, 2013, 16, 59.45),
(17, 2013, 17, 59.45),
(18, 2013, 18, 60.04),
(19, 2013, 19, 55.37),
(20, 2013, 20, 55.13),
(21, 2013, 21, 55.99),
(22, 2013, 22, 55.99),
(23, 2013, 23, 57.08),
(24, 2013, 24, 57.55),
(25, 2013, 25, 57.55),
(26, 2013, 26, 54.05),
(27, 2013, 27, 56.45),
(28, 2013, 28, 56.85),
(29, 2013, 29, 57.45),
(30, 2013, 30, 57.45),
(31, 2013, 31, 53.45),
(32, 2012, 1, 56.78),
(33, 2012, 2, 55.83),
(34, 2012, 3, 56.95),
(35, 2012, 4, 56.77),
(36, 2012, 5, 58.88),
(37, 2012, 6, 63.00),
(38, 2012, 7, 60.08),
(39, 2012, 8, 59.96),
(40, 2012, 9, 62.00),
(41, 2012, 10, 60.90),
(42, 2012, 11, 60.70),
(43, 2012, 12, 62.20),
(44, 2012, 13, 64.13),
(45, 2012, 14, 64.63),
(46, 2012, 15, 59.95),
(47, 2012, 16, 59.75),
(48, 2012, 17, 59.20),
(49, 2012, 18, 58.70),
(50, 2012, 19, 57.95),
(51, 2012, 20, 56.25),
(52, 2012, 21, 55.63),
(53, 2012, 22, 56.20),
(54, 2012, 23, 55.70),
(55, 2012, 24, 53.20),
(56, 2012, 25, 53.00),
(57, 2012, 26, 53.00),
(58, 2012, 27, 51.63),
(59, 2012, 28, 53.31),
(60, 2012, 29, 54.83),
(61, 2012, 30, 55.33),
(62, 2012, 31, 55.33),
(63, 2012, 32, 60.00),
(64, 2012, 33, 60.20),
(65, 2012, 34, 58.12),
(66, 2012, 35, 58.92),
(67, 2012, 36, 59.33),
(68, 2012, 37, 63.29),
(69, 2012, 38, 60.06),
(70, 2012, 39, 60.06),
(71, 2012, 40, 60.29),
(72, 2012, 41, 59.95),
(73, 2012, 42, 59.95),
(74, 2012, 43, 58.26),
(75, 2012, 44, 58.45),
(76, 2012, 45, 58.25),
(77, 2012, 46, 58.25),
(78, 2012, 47, 59.45),
(79, 2012, 48, 61.09),
(80, 2012, 49, 63.45),
(81, 2012, 50, 63.36),
(82, 2012, 51, 63.36);

DROP TABLE IF EXISTS avg_stats;
CREATE TABLE avg_stats (
  id int NOT NULL AUTO_INCREMENT,
  vm_name varchar(100) NOT NULL,
  time timestamp NOT NULL,
  avg_cpu decimal(5,2) NOT NULL, -- % of CPU 
  avg_memory int NOT NULL, -- Mb of memory used 
  PRIMARY KEY (id)
);

insert into avg_stats (vm_name, time, avg_cpu, avg_memory) values
	('T03-VM02-Lin-Ling', '2014-04-19 00:00:01', 20.15, 25),
	('T03-VM02-Lin-Ling', '2014-04-19 00:01:01', 17.85, 15),
	('T03-VM02-Lin-Ling', '2014-04-19 00:02:01', 21.15, 28),
	('T03-VM02-Lin-Ling', '2014-04-19 00:03:01', 26.45, 35),
	('T03-VM02-Lin-Ling', '2014-04-19 00:05:01', 5.00, 10),
	('T03-VM02-Lin-Ling', '2014-04-19 00:06:01', 20.15, 25),
	('T03-VM02-Lin-Ling', '2014-04-19 00:07:01', 21.15, 26),
	('T03-VM02-Lin-Ling', '2014-04-19 00:08:01', 22.15, 27);

DROP TABLE IF EXISTS cpu;
CREATE TABLE cpu (
  id int NOT NULL AUTO_INCREMENT,
  ip varchar(20) NOT NULL,
  time varchar(50) NOT NULL,
  us decimal(5,2) NOT NULL, -- % of user CPU 
  sy decimal(5,2) NOT NULL, -- % of system CPU 
  PRIMARY KEY (id)
);
