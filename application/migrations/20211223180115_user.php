<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_user extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "user";

	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}

	public function up()
	{
		$this->dbforge->add_field('id');
		$fields = [
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => '60'
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'first_name' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => TRUE
			],
			'last_name' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => TRUE
			],
		];
		$this->dbforge->add_field($fields);
		$this->dbforge->add_field("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		$this->dbforge->add_field("`updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		$this->dbforge->create_table($this->_table_name, TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->_table_name, TRUE);
	}

}

