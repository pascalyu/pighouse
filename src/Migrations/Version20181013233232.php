<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181013233232 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE house DROP FOREIGN KEY FK_67D5399DD3A1CDE8');
        $this->addSql('DROP INDEX UNIQ_67D5399DD3A1CDE8 ON house');
        $this->addSql('ALTER TABLE house CHANGE pig_id_id pig_id INT NOT NULL');
        $this->addSql('ALTER TABLE house ADD CONSTRAINT FK_67D5399D11336AC6 FOREIGN KEY (pig_id) REFERENCES pig (id)');
        $this->addSql('CREATE INDEX IDX_67D5399D11336AC6 ON house (pig_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE house DROP FOREIGN KEY FK_67D5399D11336AC6');
        $this->addSql('DROP INDEX IDX_67D5399D11336AC6 ON house');
        $this->addSql('ALTER TABLE house CHANGE pig_id pig_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE house ADD CONSTRAINT FK_67D5399DD3A1CDE8 FOREIGN KEY (pig_id_id) REFERENCES pig (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_67D5399DD3A1CDE8 ON house (pig_id_id)');
    }
}
