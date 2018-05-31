<?php

use yii\db\Migration;

/**
 * Handles the creation of table `log`.
 */
class m171003_173213_create_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('log', [
            'id' => $this->primaryKey(),
			'level' => $this->integer(),
			'category' => $this->string(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
			'ip' => $this->string(),
			'user_agent' => $this->text(),
			'message' => 'longtext',
			'var' => $this->text(),
			'referrer_url' => $this->text(),
			'request_url' => $this->text(),
			'user_id' => $this->integer(),
			'status' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('log');
    }
}
