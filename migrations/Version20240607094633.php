<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607094633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, response VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_question (reponse_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_E97BC639CF18BB82 (reponse_id), INDEX IDX_E97BC6391E27F6BF (question_id), PRIMARY KEY(reponse_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC639CF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_question ADD CONSTRAINT FK_E97BC6391E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_quizz ADD CONSTRAINT FK_4C9C86391E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_quizz ADD CONSTRAINT FK_4C9C8639BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_question DROP FOREIGN KEY FK_E97BC639CF18BB82');
        $this->addSql('ALTER TABLE reponse_question DROP FOREIGN KEY FK_E97BC6391E27F6BF');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE reponse_question');
        $this->addSql('ALTER TABLE question_quizz DROP FOREIGN KEY FK_4C9C86391E27F6BF');
        $this->addSql('ALTER TABLE question_quizz DROP FOREIGN KEY FK_4C9C8639BA934BCD');
    }
}
