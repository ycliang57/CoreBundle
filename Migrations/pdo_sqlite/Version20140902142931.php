<?php

namespace Claroline\CoreBundle\Migrations\pdo_sqlite;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/09/02 02:29:32
 */
class Version20140902142931 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            DROP INDEX IDX_74F39F0F82D40A1F
        ");
        $this->addSql("
            CREATE TEMPORARY TABLE __temp__claro_badge AS 
            SELECT id, 
            workspace_id, 
            version, 
            image, 
            automatic_award, 
            is_expiring, 
            expire_duration, 
            expire_period, 
            deletedAt 
            FROM claro_badge
        ");
        $this->addSql("
            DROP TABLE claro_badge
        ");
        $this->addSql("
            CREATE TABLE claro_badge (
                id INTEGER NOT NULL, 
                workspace_id INTEGER DEFAULT NULL, 
                version INTEGER NOT NULL, 
                image VARCHAR(255) NOT NULL, 
                automatic_award BOOLEAN DEFAULT NULL, 
                is_expiring BOOLEAN DEFAULT '0' NOT NULL, 
                expire_duration INTEGER DEFAULT NULL, 
                expire_period INTEGER DEFAULT NULL, 
                deletedAt DATETIME DEFAULT NULL, 
                PRIMARY KEY(id), 
                CONSTRAINT FK_74F39F0F82D40A1F FOREIGN KEY (workspace_id) 
                REFERENCES claro_workspace (id) 
                ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        ");
        $this->addSql("
            INSERT INTO claro_badge (
                id, workspace_id, version, image, automatic_award, 
                is_expiring, expire_duration, expire_period, 
                deletedAt
            ) 
            SELECT id, 
            workspace_id, 
            version, 
            image, 
            automatic_award, 
            is_expiring, 
            expire_duration, 
            expire_period, 
            deletedAt 
            FROM __temp__claro_badge
        ");
        $this->addSql("
            DROP TABLE __temp__claro_badge
        ");
        $this->addSql("
            CREATE INDEX IDX_74F39F0F82D40A1F ON claro_badge (workspace_id)
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP INDEX IDX_74F39F0F82D40A1F
        ");
        $this->addSql("
            CREATE TEMPORARY TABLE __temp__claro_badge AS 
            SELECT id, 
            workspace_id, 
            version, 
            automatic_award, 
            image, 
            is_expiring, 
            expire_duration, 
            expire_period, 
            deletedAt 
            FROM claro_badge
        ");
        $this->addSql("
            DROP TABLE claro_badge
        ");
        $this->addSql("
            CREATE TABLE claro_badge (
                id INTEGER NOT NULL, 
                workspace_id INTEGER DEFAULT NULL, 
                version INTEGER NOT NULL, 
                automatic_award BOOLEAN DEFAULT NULL, 
                image VARCHAR(255) NOT NULL, 
                is_expiring BOOLEAN DEFAULT '0' NOT NULL, 
                expire_duration INTEGER DEFAULT NULL, 
                expire_period INTEGER DEFAULT NULL, 
                deletedAt DATETIME DEFAULT NULL, 
                PRIMARY KEY(id), 
                CONSTRAINT FK_74F39F0F82D40A1F FOREIGN KEY (workspace_id) 
                REFERENCES claro_workspace (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        ");
        $this->addSql("
            INSERT INTO claro_badge (
                id, workspace_id, version, automatic_award, 
                image, is_expiring, expire_duration, 
                expire_period, deletedAt
            ) 
            SELECT id, 
            workspace_id, 
            version, 
            automatic_award, 
            image, 
            is_expiring, 
            expire_duration, 
            expire_period, 
            deletedAt 
            FROM __temp__claro_badge
        ");
        $this->addSql("
            DROP TABLE __temp__claro_badge
        ");
        $this->addSql("
            CREATE INDEX IDX_74F39F0F82D40A1F ON claro_badge (workspace_id)
        ");
    }
}