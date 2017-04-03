<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_model extends CI_Model 
{
	public function __construct()
	{
		if (!$this->db->table_exists('properties'))
		{
			$this->load->dbforge($this->db);

			$fields = array(
				'property_id' => array(
					'type' => 'INT', 
					'null' => FALSE, 
					'auto_increment' => TRUE, 
					'primary' => TRUE
				),
				'property_key' => array(
					'type' => 'VARCHAR', 
					'constraint' => 50, 
					'null' => FALSE
				),
				'property_value' => array(
					'type' => 'TEXT', 
					'null' => FALSE
				),
			);

			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('property_id', TRUE);

			$this->dbforge->create_table('properties', TRUE);
		}
	}

	public function get_property($property_key)
	{
		$this->db->where('property_key', $property_key);

		$query = $this->db->get('properties');
		$result = $query->result_array();

		if (count($result) == 1) 
		{
            return $result[0]['property_value'];
        }

        return FALSE;
	}
	public function set_property($property_key, $property_value)
	{
		$this->db->set('property_value', $property_value);

		if ($this->get_property($property_key) == '')
		{
			$this->db->set('property_key', $property_key);
			$this->db->insert('properties');
		}
		else 
		{
			$this->db->where('property_key', $property_key);
			$this->db->update('properties');
		}
	}
}
?>