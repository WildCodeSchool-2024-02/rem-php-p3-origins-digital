<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628095539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE twitch_user_watch ADD title VARCHAR(255) DEFAULT NULL, ADD thumbnail VARCHAR(255) DEFAULT NULL, ADD is_live TINYINT(1) DEFAULT NULL, ADD game_id INT DEFAULT NULL, ADD game_name VARCHAR(255) DEFAULT NULL, ADD video_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE twitch_user_watch DROP title, DROP thumbnail, DROP is_live, DROP game_id, DROP game_name, DROP video_id');
    }
}
