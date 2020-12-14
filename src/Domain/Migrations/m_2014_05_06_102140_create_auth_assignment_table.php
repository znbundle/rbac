<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2014_05_06_102140_create_auth_assignment_table extends BaseCreateTableMigration
{

    protected $tableName = 'auth_assignment';
    protected $tableComment = 'Назначение ролей ползователю';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->string('item_name', 64)->comment('Имя роли');
            $table->string('user_id', 64)->comment('ID пользователя');
            $table->integer('created_at')->nullable()->comment('Время создания');

            $table->primary(['item_name', 'user_id']);
            $table->index('user_id');

            $table
                ->foreign('item_name')
                ->references('name')
                ->on($this->encodeTableName('auth_item'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }

}