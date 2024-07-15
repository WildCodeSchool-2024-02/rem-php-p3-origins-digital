<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710130745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reponse_category (reponse_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_59C096B6CF18BB82 (reponse_id), INDEX IDX_59C096B612469DE2 (category_id), PRIMARY KEY(reponse_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reponse_category ADD CONSTRAINT FK_59C096B6CF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_category ADD CONSTRAINT FK_59C096B612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse DROP is_checked');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_category DROP FOREIGN KEY FK_59C096B6CF18BB82');
        $this->addSql('ALTER TABLE reponse_category DROP FOREIGN KEY FK_59C096B612469DE2');
        $this->addSql('DROP TABLE reponse_category');
        $this->addSql('ALTER TABLE reponse ADD is_checked TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
