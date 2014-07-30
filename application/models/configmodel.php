<?php

class ConfigModel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function get_custom( $key ) {
        $this->db->select('custom_value');
        $this->db->from('config_table');
        $this->db->where('custom_key', $key);

        $query = $this->db->get();

        $result = $query->result_array();

        return count($result) == 1 ? $result[0]['custom_value'] : null;
    }

    function set_custom( $key, $value ) {
        $this->db->select('custom_value');
        $this->db->from('config_table');
        $this->db->where('custom_key', $key);

        $query = $this->db->get();

        $result = $query->result_array();

        if(count($result) == 1) {
            $this->db->where('custom_key', $key);
            $this->db->update('config_table', array(
                'custom_key' => $key,
                'custom_value' => $value
            ));
        } else {
            $this->db->insert('config_table', array(
                'custom_key' => $key,
                'custom_value' => $value
            ));
        }

        return array(
            'ret' => $this->db->affected_rows() == 1 ? 0 : -1
        );
    }
}