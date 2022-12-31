
-- --------------------------------------------------------

--
-- Table pm_domains
--

CREATE TABLE pm_domains (
  rowid INT NOT NULL AUTO_INCREMENT,
  label varchar(255) COLLATE table_collation NOT NULL,
  website tinyint(1) DEFAULT 0,
  ftp tinyint(1) DEFAULT 0,
  data_base tinyint(1) DEFAULT 0,
  fk_user int(11) NOT NULL,
  PRIMARY KEY (rowid),
  KEY domains_fk_user (fk_user)
) ENGINE=InnoDB DEFAULT CHARSET=table_character_set COLLATE=table_collation;