<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lison Allen
 * Date: 11-10-16
 * Time: 下午12:10
 * To change this template use File | Settings | File Templates.
 */
 
class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'date'));
	}

	function index()
	{
		//$this->load->view('upload_form', array('error' => ' ' ));
	}

	function uploadImage()
	{
		$config['upload_path'] = './img/product/'.( $_POST['size'] == 'large' ? 'large/' : ($_POST['size'] == 'huge' ? 'huge' : 'small/') );
		$config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = time();
		$config['max_size']	= '10000';
		$config['max_width']  = '10240';
		$config['max_height']  = '7680';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload( 'product-image' ))
		{
			$error = array('error' => $this->upload->display_errors());

            print_r( $error );
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

            print_r( $data['upload_data']['file_name'] );
		}
	}

	function uploadCover()
	{
		$config['upload_path'] = './img/product/cover/';
		$config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = time();
		$config['max_size']	= '10000';
		$config['max_width']  = '10240';
		$config['max_height']  = '7680';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload( 'cover-image' ))
		{
			$error = array('error' => $this->upload->display_errors());

            print_r( $error );
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

            print_r( $data['upload_data']['file_name'] );
		}
	}
}