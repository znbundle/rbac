<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnCore\Db\Migration\Base\BaseCreateTableMigration;
use ZnCore\Db\Migration\Enums\ForeignActionEnum;

class m140506_102130_create_auth_item_child_table extends BaseCreateTableMigration
{

    protected $tableName = 'auth_item_child';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->string('parent', 64)->comment('');
            $table->string('child', 64)->comment('');

            $table->primary(['parent', 'child']);

            $table
                ->foreign('parent')
                ->references('name')
                ->on($this->encodeTableName('auth_item'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table
                ->foreign('child')
                ->references('name')
                ->on($this->encodeTableName('auth_item'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }

}