<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2014_05_06_102110_create_auth_rule_table extends BaseCreateTableMigration
{

    protected $tableName = 'auth_rule';
    protected $tableComment = 'Программируемые правила для полномочий';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->string('name', 64)->comment('Имя');
            $table->binary('data')->nullable()->comment('Данные');
            $table->integer('created_at')->nullable()->comment('Время создания');
            $table->integer('updated_at')->nullable()->comment('Время обновления');

            $table->primary('name');
        };
    }

}