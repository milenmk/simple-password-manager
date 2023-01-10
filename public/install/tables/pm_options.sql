
-- --------------------------------------------------------

--
-- `pm_options`
--

CREATE TABLE `pm_options` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE table_collation NOT NULL,
  `value` text COLLATE table_collation NOT NULL,
  `description` varchar(255) COLLATE table_collation DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (rowid)
) ENGINE=InnoDB DEFAULT CHARSET=table_character_set COLLATE=table_collation;

INSERT INTO `pm_options` (`rowid`, `name`, `value`, `description`) VALUES
(1, 'DISABLE_SYSLOG', '0', ''),
(2, 'NUM_LIMIT_ADMIN_DASHBOARD', '10', NULL);