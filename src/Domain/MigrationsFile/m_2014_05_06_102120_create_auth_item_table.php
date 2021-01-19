<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2014_05_06_102120_create_auth_item_table extends BaseCreateTableMigration
{

    protected $tableName = 'auth_item';
    protected $tableComment = 'Роли и полномочия';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('name', 64)->comment('Имя');
            $table->smallInteger('type')->comment('Тип (полномочие, роль)');
            $table->text('description')->nullable()->comment('Описание');
            $table->string('rule_name', 64)->nullable()->comment('Имя правила');
            $table->binary('data')->nullable()->comment('Данные');
            $table->integer('created_at')->nullable()->comment('Время создания');
            $table->integer('updated_at')->nullable()->comment('Время обновления');

            $table->unique(['name']);
            $table->index('type');

            $table
                ->foreign('rule_name')
                ->references('name')
                ->on($this->encodeTableName('auth_rule'))
                ->onDelete(ForeignActionEnum::SET_NULL)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }

}