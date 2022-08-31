<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831103731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE raport ADD category_id_id INT NOT NULL, ADD shop_id_id INT NOT NULL, ADD raport_log_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD1449777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD144B852C405 FOREIGN KEY (shop_id_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD144FBF27D71 FOREIGN KEY (raport_log_id_id) REFERENCES raport_log (id)');
        $this->addSql('CREATE INDEX IDX_31AFD1449777D11E ON raport (category_id_id)');
        $this->addSql('CREATE INDEX IDX_31AFD144B852C405 ON raport (shop_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_31AFD144FBF27D71 ON raport (raport_log_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD1449777D11E');
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD144B852C405');
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD144FBF27D71');
        $this->addSql('DROP INDEX IDX_31AFD1449777D11E ON raport');
        $this->addSql('DROP INDEX IDX_31AFD144B852C405 ON raport');
        $this->addSql('DROP INDEX UNIQ_31AFD144FBF27D71 ON raport');
        $this->addSql('ALTER TABLE raport DROP category_id_id, DROP shop_id_id, DROP raport_log_id_id');
    }
}
