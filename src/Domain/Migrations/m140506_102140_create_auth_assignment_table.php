<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnCore\Db\Migration\Base\BaseCreateTableMigration;
use ZnCore\Db\Migration\Enums\ForeignActionEnum;

class m140506_102140_create_auth_assignment_table extends BaseCreateTableMigration
{

    protected $tableName = 'auth_assignment';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->string('item_name', 64)->comment('');
            $table->string('user_id', 64)->comment('');
            $table->integer('updated_at')->nullable()->comment('');

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