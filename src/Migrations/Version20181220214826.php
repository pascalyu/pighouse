<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181220214826 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, pig_id_id INT DEFAULT NULL, house_id_id INT DEFAULT NULL, action_type LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', amount DOUBLE PRECISION DEFAULT NULL, date DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, last_updated_at DATETIME NOT NULL, deleted_at DATETIME NOT NULL, INDEX IDX_47CC8C92D3A1CDE8 (pig_id_id), INDEX IDX_47CC8C92A4A739AF (house_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92D3A1CDE8 FOREIGN KEY (pig_id_id) REFERENCES pig (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92A4A739AF FOREIGN KEY (house_id_id) REFERENCES house (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE action');
    }
}
