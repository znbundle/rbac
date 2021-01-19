<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2014_05_06_102130_create_auth_item_child_table extends BaseCreateTableMigration
{

    protected $tableName = 'auth_item_child';
    protected $tableComment = 'Распределение и наследование полномочий';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->string('parent', 64)->comment('Родитель');
            $table->string('child', 64)->comment('Ребенок');

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