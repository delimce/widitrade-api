<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923050705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_content_interaction (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, is_favorite BOOLEAN DEFAULT NULL, ranked INTEGER DEFAULT NULL, content_id INTEGER NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_4E64385384A0A3ED84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4E643853A76ED395A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4E64385384A0A3ED ON user_content_interaction (content_id)');
        $this->addSql('CREATE INDEX IDX_4E643853A76ED395 ON user_content_interaction (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_content_interaction');
    }
}
