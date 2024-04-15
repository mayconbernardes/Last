<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415135241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_answers (id INT AUTO_INCREMENT NOT NULL, is_correct TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD user_answers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25DED8DD22 FOREIGN KEY (user_answers_id) REFERENCES user_answers (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A25DED8DD22 ON answer (user_answers_id)');
        $this->addSql('ALTER TABLE user ADD user_answers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DED8DD22 FOREIGN KEY (user_answers_id) REFERENCES user_answers (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649DED8DD22 ON user (user_answers_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25DED8DD22');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DED8DD22');
        $this->addSql('DROP TABLE user_answers');
        $this->addSql('DROP INDEX IDX_DADD4A25DED8DD22 ON answer');
        $this->addSql('ALTER TABLE answer DROP user_answers_id');
        $this->addSql('DROP INDEX IDX_8D93D649DED8DD22 ON user');
        $this->addSql('ALTER TABLE user DROP user_answers_id');
    }
}
