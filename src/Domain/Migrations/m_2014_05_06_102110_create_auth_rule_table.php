<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2014_05_06_102110_create_auth_rule_table extends BaseCreateTableMigration
{

    protected $tableName = 'auth_rule';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->string('name', 64)->comment('');
            $table->binary('data')->nullable()->comment('');
            $table->integer('created_at')->nullable()->comment('');
            $table->integer('updated_at')->nullable()->comment('');

            $table->primary('name');
        };
    }

}