<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190224191824 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92A4A739AF');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92D3A1CDE8');
        $this->addSql('DROP INDEX IDX_47CC8C92D3A1CDE8 ON action');
        $this->addSql('DROP INDEX IDX_47CC8C92A4A739AF ON action');
        $this->addSql('ALTER TABLE action ADD pig_id INT DEFAULT NULL, ADD house_id INT DEFAULT NULL, DROP pig_id_id, DROP house_id_id');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C9211336AC6 FOREIGN KEY (pig_id) REFERENCES pig (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C926BB74515 FOREIGN KEY (house_id) REFERENCES house (id)');
        $this->addSql('CREATE INDEX IDX_47CC8C9211336AC6 ON action (pig_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C926BB74515 ON action (house_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C9211336AC6');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C926BB74515');
        $this->addSql('DROP INDEX IDX_47CC8C9211336AC6 ON action');
        $this->addSql('DROP INDEX IDX_47CC8C926BB74515 ON action');
        $this->addSql('ALTER TABLE action ADD pig_id_id INT DEFAULT NULL, ADD house_id_id INT DEFAULT NULL, DROP pig_id, DROP house_id');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92A4A739AF FOREIGN KEY (house_id_id) REFERENCES house (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92D3A1CDE8 FOREIGN KEY (pig_id_id) REFERENCES pig (id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92D3A1CDE8 ON action (pig_id_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92A4A739AF ON action (house_id_id)');
    }
}
