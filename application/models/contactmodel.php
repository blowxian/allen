<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lison Allen
 * Date: 11-10-4
 * Time: 下午10:04
 * To change this template use File | Settings | File Templates.
 */

define( 'en', 1 );
define( 'cn', 2 );

class Contactmodel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function getAllContact( $lang ) {
        $this->db->select( 'contact_id, contact_city, contact_addr, contact_post, contact_tel, contact_mobile, contact_fax, contact_email, contact_site' );
        $this->db->from( 'contact_table' );
        $this->db->where( 'contact_lang', $this->convertLangToFlag( $lang ) );
        $this->db->order_by( 'contact_id',' inc' );
        $query = $this->db->get();

        return $query->result_array();
    }

    function convertLangToFlag( $lang ) {
        switch( $lang ) {
            case 'en':
                return en;
            case 'cn':
                return cn;
            default:
                return null;
        }
    }
}