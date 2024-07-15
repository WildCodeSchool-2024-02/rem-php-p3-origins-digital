<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240714132753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ppg_video (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, game_id INT DEFAULT NULL, video_id VARCHAR(100) NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, thumbnail VARCHAR(255) NOT NULL, live_chat_id VARCHAR(255) NOT NULL, channel_id VARCHAR(255) NOT NULL, publish_time DATE DEFAULT NULL, status VARCHAR(100) NOT NULL, INDEX IDX_B3D6A39312469DE2 (category_id), INDEX IDX_B3D6A393E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ppg_video ADD CONSTRAINT FK_B3D6A39312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE ppg_video ADD CONSTRAINT FK_B3D6A393E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ppg_video DROP FOREIGN KEY FK_B3D6A39312469DE2');
        $this->addSql('ALTER TABLE ppg_video DROP FOREIGN KEY FK_B3D6A393E48FD905');
        $this->addSql('DROP TABLE ppg_video');
    }
}
