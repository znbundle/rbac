<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2014_05_06_102120_create_auth_item_table extends BaseCreateTableMigration
{

    protected $tableName = 'auth_item';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->string('name', 64)->comment('');
            $table->smallInteger('type')->comment('');
            $table->text('description')->nullable()->comment('');
            $table->string('rule_name', 64)->nullable()->comment('');
            $table->binary('data')->nullable()->comment('');
            $table->integer('created_at')->nullable()->comment('');
            $table->integer('updated_at')->nullable()->comment('');

            $table->primary('name');
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