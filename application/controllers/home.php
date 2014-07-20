<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lison Allen
 * Date: 11-10-3
 * Time: 上午11:36
 * To change this template use File | Settings | File Templates.
 */
 
class Home extends CI_Controller {
    public function index( $lang = 'en' ) {
        // load libs
        $this->loadLib();

        // set current for nav menu
        $data['current'] = 'home';

        // set method for compose current method
        $data['method'] = 'index';

        // set language
        $data['lang'] = $lang;

        // set up nav menu
        $this->setWrap( $data, $data['current'], $data['lang'] );

        // get data from database
        $this->load->model( 'page' );
        $news_list = $this->page->getLastNews( 5, $lang );
        $data['news_list'] = $news_list;

        // set page unique data
        if( $data['lang'] == 'en' ) {
            $data['recently_news'] = 'Recently News';
        } else if( $data['lang'] == 'cn' ) {
            $data['recently_news'] = '最新新聞';
        }

        // load view
        $this->load->view( 'home', $data );
    }

    // used for loading prerequired libraries
    private function loadLib() {
        $this->load->library( 'javascript' );

        $this->load->helper( 'url' );
        $this->load->helper( 'html' );
    }

    // set up page menu
    private function setWrap( &$data, $current, $lang ) {
        // set menu name
        if( $data['lang'] == 'en' ) {
            $data['home_name'] = 'Home';
            $data['profile_name'] = 'Profile';
            $data['product_name'] = 'Product';
            $data['news_name'] = 'News';
            $data['contact_name'] = 'Contact';
            $data['copyright'] = 'Copyright &copy Taihe 2011';
        } else if( $data['lang'] == 'cn' ) {
            $data['home_name'] = '首頁';
            $data['profile_name'] = '簡介';
            $data['product_name'] = '產品';
            $data['news_name'] = '新聞';
            $data['contact_name'] = '聯系';
            $data['copyright'] = '版權所屬 &copy 泰和 2011';
        }

        // set up page button
        $pages = array('home', 'profile', 'product', 'news', 'contact');

        for( $index = 0, $len = count( $pages ); $index < $len; $index++ ) {
            // disable current page link
            if( $current == $pages[$index] ) {
                // add select class
                $data[$pages[$index].'_class'] = "selected";
                $data[$pages[$index].'_link'] = 'javascript:;';
                continue;
            }

            // add select class
            $data[$pages[$index].'_class'] = "";
            $data[$pages[$index].'_link'] = base_url().$pages[$index].'/index/'.$lang;
        }
    }
}