<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lison Allen
 * Date: 11-10-3
 * Time: 下午2:08
 * To change this template use File | Settings | File Templates.
 */

class Product extends CI_Controller {
	public function index($lang = 'en', $page_num = 1) {
		// load libs
		$this->loadLib();
		$this->load->helper('url');

		// set product flag
		$data['is_product'] = false;

		// set method
		$data['method'] = 'index';

		// set current language
		$data['lang'] = $lang;

		// set current page
		$data['current'] = 'product';

		// set up nav menu
		$this->setWrap($data, $data['current'], $data['lang']);

		// get data from db
		$this->load->model('category');
		$category_list = $this->category->getCategory(0, 0, $lang, $page_num);
		if (!$category_list && $page_num != 1) {
			// if no page exist
			redirect('product/');
		}
		$data['category'] = $category_list;
		$data['page_sum'] = $this->category->getPageSum(0, $lang);
		$data['page_num'] = $page_num;

		// set page unique data
		if ($data['lang'] == 'en') {
			$data['trace'] = array(
				'Product',
			);
		} else if ($data['lang'] == 'cn') {
			$data['trace'] = array(
				'產品',
			);
		}

		// set trace link
		$data['trace_link'] = array(
			'javascript:;',
		);

		// load view
		$this->load->view('product', $data);
	}

	public function category($category_id, $lang = 'en', $page_num = 1) {
		// load libs
		$this->loadLib();
		$this->load->helper('url');

		// set method
		$data['method'] = 'category/' . $category_id;

		// set current language
		$data['lang'] = $lang;

		// set current page
		$data['current'] = 'product';

		// set up nav menu
		$this->setWrap($data, $data['current'], $data['lang']);

		// get data from db
		$this->load->model('category');

		// set product flag
		$data['is_product'] = $this->category->isLeafCategory($category_id);

		// set parent category id
		$data['category_id'] = $category_id;

		if ($data['is_product']) {

			$this->load->model('productmodel');
			$product_list = $this->productmodel->getProductList($category_id, 0, $lang, $page_num);
			if (!$product_list && $page_num != 1) {
				// if no page exist
				redirect('product/category/' . $category_id . '/' . $lang);
			}
			$data['product_list'] = $product_list;
			$data['page_sum'] = $this->productmodel->getPageSum($category_id, $lang);

		} else {

			$category_list = $this->category->getCategory($category_id, 0, $lang, $page_num);
			if (!$category_list && $page_num != 1) {
				// if no page exist
				redirect('product/category/' . $category_id . '/' . $lang);
			}
			$data['category'] = $category_list;
			$data['page_sum'] = $this->category->getPageSum($category_id, $lang);

		}
		$data['page_num'] = $page_num;

		// set page unique data
		if ($data['lang'] == 'en') {
			$data['trace'] = array(
				'Product',
			);
		} else if ($data['lang'] == 'cn') {
			$data['trace'] = array(
				'產品',
			);
		}

		// set trace link
		$data['trace_link'] = array(
			base_url() . 'product/index/' . $lang,
		);

		$category_name = $this->category->getCategoryName($category_id, $lang);

		array_splice($data['trace'], 1, 0, $category_name);
		array_splice($data['trace_link'], 1, 0, 'javascript:;');

		while (count($this->category->getParentCategory($category_id)) == 1) {

			$parent = $this->category->getParentCategory($category_id);
			$category_id = $parent[0]['category_id'];

			$category_name = $this->category->getCategoryName($category_id, $lang);

			array_splice($data['trace'], 1, 0, $category_name);
			array_splice($data['trace_link'], 1, 0, base_url() . 'product/category/' . $category_id . '/' . $lang);

		}

		// load view
		$this->load->view('product', $data);
	}

	public function single($category_id, $product_id, $lang = 'en') {
		// load libs
		$this->loadLib();

		// set current page
		$data['current'] = 'product';

		// set product flag
		$data['is_product'] = true;

		// set path
		$data['method'] = 'single/' . $category_id . '/' . $product_id;

		// set current language
		$data['lang'] = $lang;

		// set up nav menu
		$this->setWrap($data, $data['current'], $data['lang']);

		// get data from database
		$this->load->model('category');
		$this->load->model('productmodel');
		$category_name = $this->category->getCategoryName($category_id, $lang);
		$product = $this->productmodel->getProduct($product_id, $lang);
		$data['product_title'] = $product['product_name'];
		$data['product_img_huge'] = $product['product_img_huge'];
		$data['product_img_large'] = $product['product_img_large'];
		$data['product_spec'] = explode(',', $product['product_spec']);
		$data['product_desc'] = explode(',', $product['product_desc']);

		// set page unique data
		if ($data['lang'] == 'en') {
			$data['description'] = 'Description';
			$data['specification'] = 'Specification';
			$data['trace'] = array(
				'Product',
			);
		} else if ($data['lang'] == 'cn') {
			$data['description'] = '產品說明';
			$data['specification'] = '規格';
			$data['trace'] = array(
				'產品',
			);
		}

		// set trace link
		$data['trace_link'] = array(
			base_url() . 'product/index/' . $lang,
		);

		array_splice($data['trace'], 1, 0, $product['product_name']);
		array_splice($data['trace_link'], 1, 0, 'javascript:;');

		$category_name = $this->category->getCategoryName($category_id, $lang);

		array_splice($data['trace'], 1, 0, $category_name);
		array_splice($data['trace_link'], 1, 0, base_url() . 'product/category/' . $category_id . '/' . $lang);

		while (count($this->category->getParentCategory($category_id)) == 1) {

			$parent = $this->category->getParentCategory($category_id);
			$category_id = $parent[0]['category_id'];

			$category_name = $this->category->getCategoryName($category_id, $lang);

			array_splice($data['trace'], 1, 0, $category_name);
			array_splice($data['trace_link'], 1, 0, base_url() . 'product/category/' . $category_id . '/' . $lang);

		}

		// load view
		$this->load->view('singleproduct', $data);
	}

	// used for loading prerequired libraries
	private function loadLib() {
		$this->load->library('javascript');

		$this->load->helper('url');
		$this->load->helper('html');
	}

	// set up page menu
	private function setWrap(&$data, $current, $lang) {
		// set menu name
		if ($data['lang'] == 'en') {
			$data['home_name'] = 'Home';
			$data['profile_name'] = 'Profile';
			$data['product_name'] = 'Product';
			$data['news_name'] = 'News';
			$data['contact_name'] = 'Contact';
			$data['copyright'] = 'Copyright &copy Taihe 2011';
		} else if ($data['lang'] == 'cn') {
			$data['home_name'] = '首頁';
			$data['profile_name'] = '簡介';
			$data['product_name'] = '產品';
			$data['news_name'] = '新聞';
			$data['contact_name'] = '聯系';
			$data['copyright'] = '版權所屬 &copy 泰和 2011';
		}

		// set up page button
		$pages = array('home', 'profile', 'product', 'news', 'contact');

		for ($index = 0, $len = count($pages); $index < $len; $index++) {
			// disable current page link
			if ($current == $pages[$index]) {
				// add select class
				$data[$pages[$index] . '_class'] = "selected";
				$data[$pages[$index] . '_link'] = 'javascript:;';
				continue;
			}

			// add select class
			$data[$pages[$index] . '_class'] = "";
			$data[$pages[$index] . '_link'] = base_url() . $pages[$index] . '/index/' . $lang;
		}
	}
}