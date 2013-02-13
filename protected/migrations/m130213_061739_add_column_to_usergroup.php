<?php

class m130213_061739_add_column_to_usergroup extends CDbMigration
{
	public function up()
	{
		$this->addColumn("user_group", "order", "INT NOT NULL");
		$this->addColumn("user_group", "type", "INT NOT NULL DEFAULT '1'");
		$this->addColumn("user_group", "parent_id", "INT NOT NULL DEFAULT '-1'");
	}

	public function down()
	{
		$this->dropColumn("user_group", "order");
		$this->dropColumn("user_group", "type");
		$this->dropColumn("user_group", "parent_id");
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