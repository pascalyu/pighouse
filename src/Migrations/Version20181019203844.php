<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181019203844 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, pig_source_id INT DEFAULT NULL, pig_dest_id INT DEFAULT NULL, house_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, state ENUM(\'WAITING\', \'CONFIRMED\', \'DECLINED\'), INDEX IDX_F11D61A242BE3A2E (pig_source_id), INDEX IDX_F11D61A2E8BC864B (pig_dest_id), INDEX IDX_F11D61A26BB74515 (house_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A242BE3A2E FOREIGN KEY (pig_source_id) REFERENCES pig (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2E8BC864B FOREIGN KEY (pig_dest_id) REFERENCES pig (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A26BB74515 FOREIGN KEY (house_id) REFERENCES house (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE invitation');
    }
}
