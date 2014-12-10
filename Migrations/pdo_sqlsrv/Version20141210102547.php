<?php

namespace Claroline\CoreBundle\Migrations\pdo_sqlsrv;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/12/10 10:25:48
 */
class Version20141210102547 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE claro_workspace 
            ADD maxStorageSize INT
        ");
        $this->addSql("
            ALTER TABLE claro_workspace 
            ADD maxUploadResources INT
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE claro_workspace 
            DROP COLUMN maxStorageSize
        ");
        $this->addSql("
            ALTER TABLE claro_workspace 
            DROP COLUMN maxUploadResources
        ");
    }
}