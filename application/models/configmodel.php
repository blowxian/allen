<?php

class ConfigModel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    // Get custom key
    function get_custom( $key ) {
        $this->db->select('custom_value');
        $this->db->from('config_table');
        $this->db->where('custom_key', $key);

        $query = $this->db->get();

        $result = $query->result_array();

        return count($result) == 1 ? $result[0]['custom_value'] : null;
    }

    // Set custom key
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

    // Del custom value
    function del_custom( $key ) {
        $this->db->select('custom_value');
        $this->db->from('config_table');
        $this->db->where('custom_key', $key);

        $query = $this->db->get();

        $result = $query->result_array();

        if(count($result) == 1) {
            $this->db->delete('config_table', array(
                'custom_key' => $key
            ));
        }

        return array(
            'ret' => count($result) == 1 ? 0 : -1
        );
    }

    // Get group value
    function get_custom_group($key) {
        $this->db->select('custom_key, custom_value');
        $this->db->from('config_table');
        $this->db->like('custom_key', $key);

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }

    // Set group value
    function set_custom_group($keyValues) {
        $success = 0;
        $fail = 0;
        foreach($keyValues as $key=>$value) {
            $ret = $this->set_custom($key, $value);
            $ret['ret'] == '0' ? $success++ : $fail++;
        }

        return array(
            'ret' => '0',
            'success' => $success,
            'fail' => $fail
        );
    }
}