<?php

class m130301_053447_add_table_user_in_group extends CDbMigration
{
	public function up()
	{
		$this->createTable('user_in_group', array(
			'uid' => 'integer',
			'gid' => 'integer',
		));
	}

	public function down()
	{
		$this->dropTable('user_in_group');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
