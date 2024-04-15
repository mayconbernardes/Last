<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415140023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25DED8DD22');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DED8DD22');
        $this->addSql('CREATE TABLE user_answer (user_id INT NOT NULL, answer_id INT NOT NULL, INDEX IDX_BF8F5118A76ED395 (user_id), INDEX IDX_BF8F5118AA334807 (answer_id), PRIMARY KEY(user_id, answer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F5118A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F5118AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_answers');
        $this->addSql('DROP INDEX IDX_DADD4A25DED8DD22 ON answer');
        $this->addSql('ALTER TABLE answer DROP user_answers_id');
        $this->addSql('DROP INDEX IDX_8D93D649DED8DD22 ON user');
        $this->addSql('ALTER TABLE user DROP user_answers_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_answers (id INT AUTO_INCREMENT NOT NULL, is_correct TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_answer DROP FOREIGN KEY FK_BF8F5118A76ED395');
        $this->addSql('ALTER TABLE user_answer DROP FOREIGN KEY FK_BF8F5118AA334807');
        $this->addSql('DROP TABLE user_answer');
        $this->addSql('ALTER TABLE answer ADD user_answers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25DED8DD22 FOREIGN KEY (user_answers_id) REFERENCES user_answers (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A25DED8DD22 ON answer (user_answers_id)');
        $this->addSql('ALTER TABLE user ADD user_answers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DED8DD22 FOREIGN KEY (user_answers_id) REFERENCES user_answers (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649DED8DD22 ON user (user_answers_id)');
    }
}
