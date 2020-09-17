<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnCore\Db\Migration\Base\BaseCreateTableMigration;
use ZnCore\Db\Migration\Enums\ForeignActionEnum;

class m140506_102120_create_auth_item_table extends BaseCreateTableMigration
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