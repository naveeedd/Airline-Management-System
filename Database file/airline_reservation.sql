-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2017 at 04:09 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetFlightStatistics` (IN `j_date` DATE)  
BEGIN
    SELECT 
        f.flight_no,
        f.departure_date,
        IFNULL(SUM(t.no_of_passengers), 0) AS no_of_passengers,
        j.total_capacity
    FROM flight_details f
    LEFT JOIN ticket_details t 
        ON t.booking_status = 'CONFIRMED' 
        AND t.flight_no = f.flight_no 
        AND f.departure_date = t.journey_date
    INNER JOIN jet_details j 
        ON j.Aircraft_id = f.Aircraft_id
    WHERE f.departure_date = j_date
    GROUP BY f.flight_no, f.departure_date;
END$$

DELIMITER ;

--
-- Table structure for table `admin`
--
CREATE TABLE `admin` (
  `admin_id` varchar(20) NOT NULL,
  `password` varchar(30) DEFAULT NULL,
  `staff_id` varchar(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `email` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `customer` (
  `customer_id` varchar(20) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `email` varchar(35) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `address` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `jet_details` (
  `Aircraft_id` varchar(10) NOT NULL,
  `Aircraft_type` varchar(20) DEFAULT NULL,
  `total_capacity` int(5) DEFAULT NULL,
  `active` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`Aircraft_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `flight_details` (
  `flight_no` varchar(10) NOT NULL,
  `from_city` varchar(20) DEFAULT NULL,
  `to_city` varchar(20) DEFAULT NULL,
  `departure_date` date NOT NULL,
  `arrival_date` date DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `seats_economy` int(5) DEFAULT NULL,
  `seats_business` int(5) DEFAULT NULL,
  `price_economy` int(10) DEFAULT NULL,
  `price_business` int(10) DEFAULT NULL,
  `Aircraft_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`flight_no`, `departure_date`),
  KEY `Aircraft_id` (`Aircraft_id`),
  CONSTRAINT `flight_details_ibfk_1` FOREIGN KEY (`Aircraft_id`) REFERENCES `jet_details` (`Aircraft_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `frequent_flier_details` (
  `frequent_flier_no` varchar(20) NOT NULL,
  `customer_id` varchar(20) DEFAULT NULL,
  `mileage` int(10) DEFAULT NULL,
  PRIMARY KEY (`frequent_flier_no`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `frequent_flier_details_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `payment_details` (
  `payment_id` varchar(20) NOT NULL,
  `pnr` varchar(15) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_amount` int(6) DEFAULT NULL,
  `payment_mode` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `pnr` (`pnr`),
  CONSTRAINT `payment_details_ibfk_1` FOREIGN KEY (`pnr`) REFERENCES `ticket_details` (`pnr`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `ticket_details` (
  `pnr` varchar(15) NOT NULL,
  `date_of_reservation` date DEFAULT NULL,
  `flight_no` varchar(10) DEFAULT NULL,
  `journey_date` date DEFAULT NULL,
  `class` varchar(10) DEFAULT NULL,
  `booking_status` varchar(20) DEFAULT NULL,
  `no_of_passengers` int(5) DEFAULT NULL,
  `lounge_access` varchar(5) DEFAULT NULL,
  `priority_checkin` varchar(5) DEFAULT NULL,
  `insurance` varchar(5) DEFAULT NULL,
  `payment_id` varchar(20) DEFAULT NULL,
  `customer_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`pnr`),
  KEY `customer_id` (`customer_id`),
  KEY `journey_date` (`journey_date`),
  KEY `flight_no` (`flight_no`),
  KEY `flight_no_2` (`flight_no`, `journey_date`),
  CONSTRAINT `ticket_details_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ticket_details_ibfk_3` FOREIGN KEY (`flight_no`, `journey_date`) REFERENCES `flight_details` (`flight_no`, `departure_date`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `passengers` (
  `passenger_id` int(10) NOT NULL,
  `pnr` varchar(15) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `gender` varchar(8) DEFAULT NULL,
  `meal_choice` varchar(5) DEFAULT NULL,
  `frequent_flier_no` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`passenger_id`, `pnr`),
  KEY `pnr` (`pnr`),
  KEY `frequent_flier_no` (`frequent_flier_no`),
  CONSTRAINT `passengers_ibfk_1` FOREIGN KEY (`pnr`) REFERENCES `ticket_details` (`pnr`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `passengers_ibfk_2` FOREIGN KEY (`frequent_flier_no`) REFERENCES `frequent_flier_details` (`frequent_flier_no`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- Insert Queries

INSERT INTO `admin` (`admin_id`, `password`, `staff_id`, `name`, `email`) VALUES
('naveed', '12345', '101', 'Naveed Raza', 'naveedraza2003@gmail.com');

INSERT INTO `customer` (`customer_id`, `password`, `name`, `email`, `phone_no`, `address`) VALUES
('usama', 'usama123', 'Usama Khan', 'usama.khan@example.com', '03001234567', 'Lahore, Punjab'),
('shaheer', 'shaheer456', 'Shaheer Ahmad', 'shaheer.ahmad@example.com', '03331234567', 'Islamabad, Capital Territory'),
('ahmedali', 'ahmed789', 'Ahmed Ali', 'ahmed.ali@example.com', '03211234567', 'Karachi, Sindh'),
('hamza', 'hamza987', 'Hamza Saeed', 'hamza.saeed@example.com', '03121234567', 'Peshawar, Khyber Pakhtunkhwa'),
('saad123', 'saadpass', 'Saad Malik', 'saad.malik@example.com', '03451234567', 'Quetta, Balochistan');


INSERT INTO `jet_details` (`Aircraft_id`, `Aircraft_type`, `total_capacity`, `active`) VALUES
('PK1001', 'Boeing 777', 300, 'Yes'),
('PK1002', 'Airbus A320', 275, 'Yes'),
('PK1003', 'ATR 72', 50, 'Yes'),
('PK1004', 'Boeing 737', 225, 'Yes'),
('PK1005', 'Fokker F27', 75, 'Yes');


INSERT INTO `flight_details` (`flight_no`, `from_city`, `to_city`, `departure_date`, `arrival_date`, `departure_time`, `arrival_time`, `seats_economy`, `seats_business`, `price_economy`, `price_business`, `Aircraft_id`) VALUES
('PK101', 'lahore', 'karachi', '2024-12-01', '2024-12-01', '08:00:00', '10:00:00', 180, 60, 6000, 9000, 'PK1001'),
('PK102', 'islamabad', 'karachi', '2024-12-02', '2024-12-02', '15:00:00', '17:30:00', 200, 80, 7000, 10000, 'PK1002'),
('PK103', 'karachi', 'quetta', '2024-12-03', '2024-12-03', '12:00:00', '13:30:00', 120, 50, 4000, 6000, 'PK1003'),
('PK104', 'lahore', 'peshawar', '2024-12-04', '2024-12-04', '09:00:00', '10:30:00', 100, 40, 5000, 7500, 'PK1004'),
('PK105', 'karachi', 'islamabad', '2024-12-05', '2024-12-05', '20:00:00', '22:30:00', 170, 70, 8000, 11000, 'PK1005');


INSERT INTO `frequent_flier_details` (`frequent_flier_no`, `customer_id`, `mileage`) VALUES
('PK1001', 'usama', 500),
('PK2002', 'shaheer', 300),
('PK3003', 'ahmedali', 250),
('PK4004', 'hamza', 400),
('PK5005', 'saad123', 350);


INSERT INTO `ticket_details` (`pnr`, `date_of_reservation`, `flight_no`, `journey_date`, `class`, `booking_status`, `no_of_passengers`, `lounge_access`, `priority_checkin`, `insurance`, `payment_id`, `customer_id`) VALUES
('100001', '2024-11-22', 'PK101', '2024-12-01', 'business', 'CONFIRMED', 3, 'yes', 'yes', 'yes', '120000248', 'usama'),
('100002', '2024-11-23', 'PK102', '2024-12-02', 'business', 'CONFIRMED', 4, 'yes', 'yes', 'yes', '467972527', 'shaheer'),
('100003', '2024-11-22', 'PK101', '2024-12-01', 'economy', 'CONFIRMED', 2, 'no', 'no', 'yes', '862686553', 'ahmedali'),
('100004', '2024-11-22', 'PK104', '2024-12-04', 'economy', 'CONFIRMED', 3, 'yes', 'yes', 'yes', '142539461', 'ahmedali'),
('100005', '2024-11-22', 'PK104', '2024-12-04', 'business', 'CONFIRMED', 3, 'yes', 'no', 'yes', '120000248', 'usama'),
('100006', '2024-11-25', 'PK101', '2024-12-01', 'economy', 'CONFIRMED', 3, 'no', 'no', 'no', '665360715', 'usama'),
('100007', '2024-11-23', 'PK101', '2024-12-01', 'economy', 'CANCELED', 2, 'yes', 'yes', 'yes', '557778944', 'ahmedali'),
('100008', '2024-11-22', 'PK102', '2024-12-02', 'business', 'CONFIRMED', 2, 'yes', 'yes', 'no', '165125569', 'ahmedali');



INSERT INTO `payment_details` (`payment_id`, `pnr`, `payment_date`, `payment_amount`, `payment_mode`) VALUES
('120000248', '100001', '2024-11-22', 4200, 'credit card'),
('142539461', '100002', '2024-11-22', 4050, 'credit card'),
('165125569', '100003', '2024-11-22', 7500, 'net banking'),
('467972527', '100004', '2024-11-23', 33400, 'debit card'),
('557778944', '100005', '2024-11-23', 11700, 'credit card'),
('620041544', '100006', '2024-11-22', 4800, 'debit card'),
('665360715', '100007', '2024-11-23', 15750, 'net banking'),
('862686553', '100008', '2024-11-22', 10700, 'debit card');

---------------------------------------------------------------




INSERT INTO `passengers` 
(`passenger_id`, `pnr`, `name`, `age`, `gender`, `meal_choice`, `frequent_flier_no`) 
VALUES
(1, '100001', 'Usama Ahmed', 25, 'male', 'yes', 'PK1001'),
(2, '100002', 'Shaheer Ali', 30, 'male', 'yes', 'PK2002'),
(3, '100003', 'Hamza Saad', 40, 'male', 'yes', 'PK3003'),
(4, '100004', 'Naveed Khan', 35, 'male', 'yes', 'PK4004'),
(5, '100005', 'Ayesha Ahmed', 28, 'female', 'yes', 'PK1001'),
(6, '100006', 'Fatima Iqbal', 22, 'female', 'yes', 'PK5005'),
(7, '100007', 'Bilal Usman', 18, 'male', 'yes', 'PK2002'),
(8, '100008', 'Zain Ali', 20, 'male', 'yes', 'PK3003');


-- Triggers `payment_details`
--

DELIMITER $$
CREATE TRIGGER `update_ticket_after_payment` AFTER INSERT ON `payment_details` FOR EACH ROW UPDATE ticket_details
     SET booking_status='CONFIRMED', payment_id= NEW.payment_id
   WHERE pnr = NEW.pnr
$$
DELIMITER ;

