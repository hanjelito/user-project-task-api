<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200706160551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates `task` table and its relationships';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(
            'CREATE TABLE task (
                    id CHAR(36) NOT NULL PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    description VARCHAR(200) NOT NULL,
                    user_id CHAR(36) DEFAULT NULL,
                    project_id CHAR(36) DEFAULT NULL,
                    created_at DATETIME NOT NULL,
                    updated_at DATETIME NOT NULL,
                    INDEX IDX_task_user_id (user_id),
                    INDEX IDX_task_project_id (project_id),
                    CONSTRAINT FK_task_user_id FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE,
                    CONSTRAINT FK_task_project_id FOREIGN KEY (project_id) REFERENCES user_project (id) ON UPDATE CASCADE ON DELETE CASCADE
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB'
        );

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE task');

    }
}
