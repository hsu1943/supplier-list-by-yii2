<?php

use yii\db\Migration;

/**
 * Class m220613_074523_supplier
 */
class m220613_074523_supplier extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%supplier}}',
            [
                'id' => $this->primaryKey()->unsigned()->comment('ID'),
                'name' => $this->string(50)->notNull()->comment('Name'),
                'code' => "char(3) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL",
                't_status' => "ENUM('ok', 'hold') CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'ok'",
            ],
            $tableOptions
        );
        $this->createIndex(
            'uk_code',
            '{{%supplier}}',
            'code',
            true
        );
    }

    public function down()
    {
        $this->dropTable('{{%supplier}}');
    }

}
