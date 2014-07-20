<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lison Allen
 * Date: 11-10-15
 * Time: 下午9:07
 * To change this template use File | Settings | File Templates.
 */
 
class User extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function isUser( $user, $pwd ) {
        if( !$user || !$pwd ) {
            return false;
        }

        $this->db->from( 'admin_table' );
        $this->db->where( 'admin_name', $user );
        $this->db->where( 'admin_pwd', $pwd );

        $query = $this->db->get()->result_array();

        if( count( $query ) == 1 ) {
            return true;
        } else {
            return false;
        }
    }
}