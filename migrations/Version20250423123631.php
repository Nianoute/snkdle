<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423123631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE pool (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, shortname VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE song_pool (song_id INT NOT NULL, pool_id INT NOT NULL, PRIMARY KEY(song_id, pool_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DC027F73A0BDB2F3 ON song_pool (song_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DC027F737B3406DF ON song_pool (pool_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE song_pool ADD CONSTRAINT FK_DC027F73A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE song_pool ADD CONSTRAINT FK_DC027F737B3406DF FOREIGN KEY (pool_id) REFERENCES pool (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE song_pool DROP CONSTRAINT FK_DC027F73A0BDB2F3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE song_pool DROP CONSTRAINT FK_DC027F737B3406DF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pool
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE song_pool
        SQL);
    }
}
