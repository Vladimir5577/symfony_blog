<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210601111337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926223CBF64E2');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622B27AD292');
        $this->addSql('DROP INDEX IDX_D88926223CBF64E2 ON rating');
        $this->addSql('DROP INDEX IDX_D8892622B27AD292 ON rating');
        $this->addSql('ALTER TABLE rating ADD giver_id INT NOT NULL, ADD recipient_id INT NOT NULL, DROP user_giver_id_id, DROP user_recepient_id_id');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D889262275BD1D29 FOREIGN KEY (giver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622E92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D889262275BD1D29 ON rating (giver_id)');
        $this->addSql('CREATE INDEX IDX_D8892622E92F8F78 ON rating (recipient_id)');
        $this->addSql('ALTER TABLE user CHANGE name name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D889262275BD1D29');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622E92F8F78');
        $this->addSql('DROP INDEX IDX_D889262275BD1D29 ON rating');
        $this->addSql('DROP INDEX IDX_D8892622E92F8F78 ON rating');
        $this->addSql('ALTER TABLE rating ADD user_giver_id_id INT NOT NULL, ADD user_recepient_id_id INT NOT NULL, DROP giver_id, DROP recipient_id');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926223CBF64E2 FOREIGN KEY (user_recepient_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622B27AD292 FOREIGN KEY (user_giver_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D88926223CBF64E2 ON rating (user_recepient_id_id)');
        $this->addSql('CREATE INDEX IDX_D8892622B27AD292 ON rating (user_giver_id_id)');
        $this->addSql('ALTER TABLE user CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
