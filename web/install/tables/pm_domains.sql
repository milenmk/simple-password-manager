
-- --------------------------------------------------------

--
-- Table pm_domains
--

CREATE TABLE pm_domains (
  rowid INT NOT NULL AUTO_INCREMENT,
  label varchar(255) COLLATE table_collation NOT NULL,
  website int(11) DEFAULT NULL,
  ftp int(11) DEFAULT NULL,
  data_base int(11) DEFAULT NULL,
  fk_user int(11) NOT NULL,
  PRIMARY KEY (rowid),
  KEY domains_fk_user (fk_user)
) ENGINE=InnoDB DEFAULT CHARSET=table_character_set COLLATE=table_collation;