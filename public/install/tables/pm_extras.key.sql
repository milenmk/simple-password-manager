
-- --------------------------------------------------------

--
-- Table extras
--
ALTER TABLE pm_domains ADD CONSTRAINT pm_domains_fk_user FOREIGN KEY (fk_user) REFERENCES pm_users (rowid);
ALTER TABLE pm_records ADD CONSTRAINT pm_records_fk_domain FOREIGN KEY (fk_domain) REFERENCES pm_domains (rowid), ADD CONSTRAINT pm_records_fk_user FOREIGN KEY (fk_user) REFERENCES pm_users (rowid);
