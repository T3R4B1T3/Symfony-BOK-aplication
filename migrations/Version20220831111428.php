<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831111428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD1449777D11E');
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD144B852C405');
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD144FBF27D71');
        $this->addSql('DROP INDEX UNIQ_31AFD144FBF27D71 ON raport');
        $this->addSql('DROP INDEX IDX_31AFD1449777D11E ON raport');
        $this->addSql('DROP INDEX IDX_31AFD144B852C405 ON raport');
        $this->addSql('ALTER TABLE raport ADD category_id INT NOT NULL, ADD shop_id INT NOT NULL, ADD raport_log_id INT NOT NULL, DROP category_id_id, DROP shop_id_id, DROP raport_log_id_id');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD14412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD1444D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD144C092B366 FOREIGN KEY (raport_log_id) REFERENCES raport_log (id)');
        $this->addSql('CREATE INDEX IDX_31AFD14412469DE2 ON raport (category_id)');
        $this->addSql('CREATE INDEX IDX_31AFD1444D16C4DD ON raport (shop_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_31AFD144C092B366 ON raport (raport_log_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD14412469DE2');
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD1444D16C4DD');
        $this->addSql('ALTER TABLE raport DROP FOREIGN KEY FK_31AFD144C092B366');
        $this->addSql('DROP INDEX IDX_31AFD14412469DE2 ON raport');
        $this->addSql('DROP INDEX IDX_31AFD1444D16C4DD ON raport');
        $this->addSql('DROP INDEX UNIQ_31AFD144C092B366 ON raport');
        $this->addSql('ALTER TABLE raport ADD category_id_id INT NOT NULL, ADD shop_id_id INT NOT NULL, ADD raport_log_id_id INT NOT NULL, DROP category_id, DROP shop_id, DROP raport_log_id');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD1449777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD144B852C405 FOREIGN KEY (shop_id_id) REFERENCES shop (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE raport ADD CONSTRAINT FK_31AFD144FBF27D71 FOREIGN KEY (raport_log_id_id) REFERENCES raport_log (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_31AFD144FBF27D71 ON raport (raport_log_id_id)');
        $this->addSql('CREATE INDEX IDX_31AFD1449777D11E ON raport (category_id_id)');
        $this->addSql('CREATE INDEX IDX_31AFD144B852C405 ON raport (shop_id_id)');
    }
}
