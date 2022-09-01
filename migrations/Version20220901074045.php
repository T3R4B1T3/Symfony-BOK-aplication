<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901074045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, shop_id INT NOT NULL, report_log_id INT NOT NULL, description LONGTEXT NOT NULL, email VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(9) DEFAULT NULL, report_date DATE NOT NULL, user_agent VARCHAR(255) NOT NULL, INDEX IDX_C42F778412469DE2 (category_id), INDEX IDX_C42F77844D16C4DD (shop_id), UNIQUE INDEX UNIQ_C42F7784C3948819 (report_log_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report_log (id INT AUTO_INCREMENT NOT NULL, `read` TINYINT(1) NOT NULL, first_who_read VARCHAR(255) DEFAULT NULL, read_date DATE DEFAULT NULL, state VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F778412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77844D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784C3948819 FOREIGN KEY (report_log_id) REFERENCES report_log (id)');
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD14412469DE2');
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD1444D16C4DD');
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD144C092B366');
        $this->addSql('DROP TABLE raport_log');
        $this->addSql('DROP TABLE raport');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE raport_log (id INT AUTO_INCREMENT NOT NULL, `read` TINYINT(1) NOT NULL, first_who_read VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, read_date DATE DEFAULT NULL, state VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE raport (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, shop_id INT NOT NULL, raport_log_id INT NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, phone_number VARCHAR(9) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, raport_date DATE NOT NULL, user_agent VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_31AFD144C092B366 (raport_log_id), INDEX IDX_31AFD14412469DE2 (category_id), INDEX IDX_31AFD1444D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD14412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD1444D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD144C092B366 FOREIGN KEY (raport_log_id) REFERENCES raport_log (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F778412469DE2');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F77844D16C4DD');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784C3948819');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE report_log');
    }
}
