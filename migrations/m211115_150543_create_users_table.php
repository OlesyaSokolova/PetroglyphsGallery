<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m211115_150543_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
   /* public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
        ]);
    }*/

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //$this->dropTable('users');
    }

    public function up()
    {
        $tableOptions = null;

        /*if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }*/

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'patronymic' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }
}
