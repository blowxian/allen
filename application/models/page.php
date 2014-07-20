<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lison Allen
 * Date: 11-10-4
 * Time: 下午3:03
 * To change this template use File | Settings | File Templates.
 */

if(!defined('en')) {
    define( 'en', 1 );
    define( 'cn', 2 );
    define( 'news', 2 );
}
 
class Page extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function getLastNews( $count, $lang ) {
        $this->db->select( 'page_id, page_title, page_content, update_time' );
        $this->db->from( 'page_table' );
        $this->db->where( 'page_type', news );
        $this->db->where( 'page_lang', $this->convertLangToFlag( $lang ) );
        $this->db->order_by( 'update_time',' desc' );
        $this->db->limit( $count );
        $query = $this->db->get();

        return $query->result_array();
    }

    function getNews( $news_id ) {
        $this->db->select( 'page_id, page_title, page_content' );
        $this->db->from( 'page_table' );
        $this->db->where( 'page_id', $news_id );
        $query = $this->db->get();

        return $query->result_array();
    }

    function getAllNews() {
        $this->db->select( 'page_id, page_title, page_content, update_time' );
        $this->db->from( 'page_table' );
        $this->db->where( 'page_type', news );
        $this->db->order_by( 'update_time',' desc' );
        $query = $this->db->get();

        return $query->result_array();
    }

    function addNews( $news ) {
        $this->db->insert( 'page_table', $news );

        return array(
            'ret' => 0,
            'pageId' => $this->db->insert_id()
        );
    }

    function deleteNews( $news_id ) {
        $this->db->delete( 'page_table', array( 'page_id' => $news_id ) );

        return array(
            'ret' => $this->db->affected_rows() == 1 ? 0 : -1
        );
    }

    function updateNews( $news_id, $news ) {
        $this->db->where( 'page_id', $news_id );
        $this->db->update( 'page_table', $news );
    }

    function getSingleNews( $news_id ) {
        $this->db->select( 'page_id, page_title, page_content, update_time' );
        $this->db->from( 'page_table' );
        $this->db->where( 'page_id', $news_id );
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