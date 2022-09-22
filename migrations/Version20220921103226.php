<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921103226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD atributs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BF9019D4 FOREIGN KEY (atributs_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649BF9019D4 ON user (atributs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BF9019D4');
        $this->addSql('DROP INDEX IDX_8D93D649BF9019D4 ON user');
        $this->addSql('ALTER TABLE user DROP atributs_id');
    }
}
