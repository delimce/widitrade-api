<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240922201229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, uid VARCHAR(40) NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE media (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, uid VARCHAR(40) NOT NULL, title VARCHAR(255) NOT NULL, filepath VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, content_id INTEGER NOT NULL, CONSTRAINT FK_6A2CA10C84A0A3ED84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C84A0A3ED ON media (content_id)');
        $this->addSql('CREATE TABLE user_content_owner (user_id INTEGER NOT NULL, content_id INTEGER NOT NULL, PRIMARY KEY(user_id, content_id), CONSTRAINT FK_CA2D1FFEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CA2D1FFE84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CA2D1FFEA76ED395 ON user_content_owner (user_id)');
        $this->addSql('CREATE INDEX IDX_CA2D1FFE84A0A3ED ON user_content_owner (content_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE user_content_owner');
    }
}
