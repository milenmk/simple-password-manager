
-- --------------------------------------------------------

--
-- `pm_domains`
--

CREATE TABLE `pm_domains` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE table_collation NOT NULL,
  `website` tinyint(1) DEFAULT 0,
  `ftp` tinyint(1) DEFAULT 0,
  `data_base` tinyint(1) DEFAULT 0,
  `fk_user` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`rowid`),
  KEY `domains_fk_user` (`fk_user`)
) ENGINE=InnoDB DEFAULT CHARSET=table_character_set COLLATE=table_collation;