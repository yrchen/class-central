<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Adds a scheduler log table
 */
class Version20131130100243 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE  TABLE IF NOT EXISTS `mt_scheduler_logs` (
              `id` INT NOT NULL AUTO_INCREMENT ,
              `created` TIMESTAMP NOT NULL ,
              `type` INT NOT NULL COMMENT 'Search, Course\n' ,
              `email_sent` TINYINT(1) NULL ,
              `user_id` INT NULL ,
              `status` INT NOT NULL COMMENT 'Created, Finished, New' ,
              `job_id` VARCHAR(255) NULL ,
              PRIMARY KEY (`id`) ,
              INDEX `mt_scheduler_log_type_idx` (`type` ASC) ,
              INDEX `fk_mt_scheduler_log_user_idx` (`user_id` ASC) ,
              CONSTRAINT `fk_mt_scheduler_history_user`
                FOREIGN KEY (`user_id` )
                REFERENCES `users` (`id` )
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
          ENGINE = InnoDB;
        ");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
