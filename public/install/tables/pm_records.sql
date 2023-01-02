
-- --------------------------------------------------------

--
-- `pm_records`
--

CREATE TABLE `pm_records` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fk_domain` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `url` varchar(255) COLLATE table_collation NOT NULL,
  `username` varchar(255) COLLATE table_collation NOT NULL,
  `pass_crypted` varchar(255) COLLATE table_collation NOT NULL,
  `fk_user` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (rowid),
  KEY `record_fk_domain` (`fk_domain`),
  KEY `record_fk_user` (`fk_user`)
) ENGINE=InnoDB DEFAULT CHARSET=table_character_set COLLATE=table_collation;