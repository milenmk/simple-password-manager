
-- --------------------------------------------------------

--
-- `pm_users`
--

CREATE TABLE `pm_users` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(128) COLLATE table_collation DEFAULT NULL,
  `last_name` varchar(128) COLLATE table_collation DEFAULT NULL,
  `username` varchar(50) COLLATE table_collation NOT NULL,
  `password` varchar(255) COLLATE table_collation NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `theme` varchar(50) COLLATE table_collation DEFAULT NULL,
  `language` varchar(8) COLLATE table_collation DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (rowid),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=table_character_set COLLATE=table_collation;