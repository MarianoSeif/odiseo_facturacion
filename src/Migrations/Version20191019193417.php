<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191019193417 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE movement (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, price_ars INT DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movement_invoice (movement_id INT NOT NULL, invoice_id INT NOT NULL, INDEX IDX_BF674B9D229E70A7 (movement_id), INDEX IDX_BF674B9D2989F1FD (invoice_id), PRIMARY KEY(movement_id, invoice_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, invoiced_at DATE NOT NULL, number VARCHAR(255) NOT NULL, details VARCHAR(255) NOT NULL, received_by VARCHAR(255) NOT NULL, payed_at DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movement_invoice ADD CONSTRAINT FK_BF674B9D229E70A7 FOREIGN KEY (movement_id) REFERENCES movement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movement_invoice ADD CONSTRAINT FK_BF674B9D2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movement_invoice DROP FOREIGN KEY FK_BF674B9D229E70A7');
        $this->addSql('ALTER TABLE movement_invoice DROP FOREIGN KEY FK_BF674B9D2989F1FD');
        $this->addSql('DROP TABLE movement');
        $this->addSql('DROP TABLE movement_invoice');
        $this->addSql('DROP TABLE invoice');
    }
}
