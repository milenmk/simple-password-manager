
-- --------------------------------------------------------

--
-- Table pm_records
--

CREATE TABLE pm_records (
  rowid INT NOT NULL AUTO_INCREMENT,
  fk_domain int(11) NOT NULL,
  is_db tinyint(1) DEFAULT 0,
  is_site tinyint(1) DEFAULT 0,
  is_ftp tinyint(1) DEFAULT 0,
  dbase_name varchar(255) COLLATE table_collation DEFAULT NULL,
  ftp_server varchar(255) COLLATE table_collation DEFAULT NULL,
  url varchar(255) COLLATE table_collation DEFAULT NULL,
  username varchar(255) COLLATE table_collation DEFAULT NULL,
  pass_crypted varchar(128) COLLATE table_collation DEFAULT NULL,
  fk_user int(11) NOT NULL,
  PRIMARY KEY (rowid),
  KEY record_fk_domain (fk_domain),
  KEY record_fk_user (fk_user)
) ENGINE=InnoDB DEFAULT CHARSET=table_character_set COLLATE=table_collation;