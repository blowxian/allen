<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lison Allen
 * Date: 11-10-5
 * Time: 上午11:15
 * To change this template use File | Settings | File Templates.
 */

class Productmodel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function getProductList( $category_id, $count, $lang, $page_num = -1 ) {
        $this->db->select( 'product_id, product_name, product_img_small' );
        $this->db->from( 'product_table' );
        $this->db->where( 'product_category', $category_id );
        $this->db->where( 'product_lang', $this->convertLangToFlag( $lang ) );
        $this->db->order_by( 'product_id',' desc' );
        if( $count != 0 ) {
            $this->db->limit( $count );
        }
        if( $page_num != -1 ) {
            $this->db->limit( 9, 9 * ( $page_num - 1 ) );
        }
        $query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getPageSum( $category_id, $lang ) {
        $this->db->from( 'product_table' );
        $this->db->where( 'product_category', $category_id );
        $this->db->where( 'product_lang', $this->convertLangToFlag( $lang ) );
        $this->db->order_by( 'product_id',' desc' );
        $query = $this->db->get();

        $page_sum = floor( $query->num_rows() / 9 ) + ( $query->num_rows() % 9 == 0 ? 0 : 1 );

        return $page_sum;
    }

    function getAllProduct() {
        $this->db->select( 'product_id, product_name, product_desc' );
        $this->db->from( 'product_table' );
        $query = $this->db->get();

        return $query->result_array();
    }

    function queryProduct( $search = "", $page_num = 1, $page_size = 20 ) {
        $this->db->select( 'product_id, product_name, product_desc' );
        $this->db->from( 'product_table' );
        if( $search != "" ) {
            $this->db->like( 'product_desc', $search );
            $this->db->or_like('product_name', $search);
            $this->db->or_like('product_spec', $search);
        }
        $this->db->limit( $page_size, $page_size * ( $page_num - 1 ) );
        $query = $this->db->get();

        return array(
            'ret' => 0,
            'pageNum' => $page_num,
            'totalPageNum' => $this->getQueryPageSum($search),
            'pageSize' => $page_size,
            'queryResult' => $query->result_array()
        );
    }

    function getQueryPageSum( $search = "", $page_size = 20 ) {
        $this->db->select( 'product_id, product_name, product_desc' );
        $this->db->from( 'product_table' );
        if( $search != "" ) {
            $this->db->like( 'product_desc', $search );
            $this->db->or_like('product_name', $search);
            $this->db->or_like('product_spec', $search);
        }
        $query = $this->db->get();

        $page_sum = floor( $query->num_rows() / $page_size ) + ( $query->num_rows() % $page_size == 0 ? 0 : 1 );

        return $page_sum;
    }

    function getProduct( $product_id, $lang ) {
        $this->db->select( 'product_id, product_name, product_img_large, product_img_huge, product_desc, product_spec, product_lang' );
        $this->db->from( 'product_table' );
        $this->db->where( 'product_id', $product_id );
        $query = $this->db->get()->result_array();

        return $query[0];
    }

    function get_product( $product_id ) {
        $this->db->select( 'product_id, product_name, product_category, product_img_small, product_img_large, product_img_huge, product_desc, product_spec, product_lang' );
        $this->db->from( 'product_table' );
        $this->db->where( 'product_id', $product_id );

        $query = $this->db->get()->result_array();

        $ret = count($query) == 0 ? 3 : 0;

        return array(
            'ret' => $ret,
            'product' => $ret == 0 ? $query[0] : null
        );
    }

    function getSingleProduct( $product_id ) {
        $this->db->select( 'product_id, product_name, product_category, product_img_huge, product_img_large, product_img_small, product_desc, product_spec, product_lang' );
        $this->db->from( 'product_table' );
        $this->db->where( 'product_id', $product_id );
        $query = $this->db->get()->result_array();

        return $query[0];
    }

    function addProduct( $product ) {
        $this->db->insert( 'product_table', $product );

        return array(
            'ret' => 0,
            'productId' => $this->db->insert_id()
        );
    }

    function updateProduct( $product_id, $product ) {
        $this->db->where( 'product_id', $product_id );
        $this->db->update( 'product_table', $product );

        return array(
            'ret' => ($this->db->affected_rows() == 1 ? 0 : 1)
        );
    }

    function deleteProduct( $product_id ) {
        $this->db->delete( 'product_table', array( 'product_id' => $product_id ) );

        return array(
            'ret' => ($this->db->affected_rows() == 1 ? 0 : 1)
        );
    }

    function deleteCategoryProduct( $parent_id ) {
        $this->db->delete( 'product_table', array( 'parent_id' => $parent_id ) );
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