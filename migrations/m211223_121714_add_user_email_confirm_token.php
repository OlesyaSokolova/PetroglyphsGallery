<?php

use yii\db\Migration;

/**
 * Class m211223_121714_add_user_email_confirm_token
 */
class m211223_121714_add_user_email_confirm_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211223_121714_add_user_email_confirm_token cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $this->addColumn('users', 'email_confirm_token', $this->string()->unique()->after('email'));
    }

    public function down()
    {
        $this->dropColumn('users', 'email_confirm_token');
    }
}
