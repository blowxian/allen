<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lison Allen
 * Date: 11-10-5
 * Time: 上午11:16
 * To change this template use File | Settings | File Templates.
 */

if (!defined('en')) {
	define('en', 1);
	define('cn', 2);
	define('news', 2);
}

class Category extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function getCategory($parent_id, $count, $lang, $page_num = -1) {
		$this->db->select('category_id, parent_id, category_name, category_cover, category_desc');
		$this->db->from('category_table');
		if ($parent_id != -1) {
			$this->db->where('parent_id', $parent_id);
		}
		$this->db->where('category_lang', $this->convertLangToFlag($lang));
		$this->db->order_by('category_id', 'desc');
		if ($count != 0) {
			$this->db->limit($count);
		}
		if ($page_num != -1) {
			$this->db->limit(9, 9 * ($page_num - 1));
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	function updateCategory($category_id, $category) {
		$this->db->where('category_id', $category_id);
		$this->db->update('category_table', $category);

		return array(
			'ret' => $this->db->affected_rows() == 1 ? 0 : -1,
		);
	}

	function getPageSum($parent_id, $lang) {
		$this->db->from('category_table');
		if ($parent_id != -1) {
			$this->db->where('parent_id', $parent_id);
		}
		$this->db->where('category_lang', $this->convertLangToFlag($lang));
		$this->db->order_by('category_id', 'desc');
		$query = $this->db->get();

		$page_sum = floor($query->num_rows() / 9)+($query->num_rows() % 9 == 0 ? 0 : 1);

		return $page_sum;
	}

	function getChildCategory($parent_id) {
		$this->db->select('category_id, category_name, category_cover, category_desc');
		$this->db->from('category_table');
		$this->db->where('parent_id', $parent_id);
		$query = $this->db->get();

		return $query->result_array();
	}

	function getAllCategory() {
		$this->db->select('category_id, parent_id, category_name, category_cover, category_desc, category_lang');
		$this->db->from('category_table');
		$this->db->order_by('category_id', 'desc');
		$query = $this->db->get();

		return $query->result_array();
	}

	function getSingleCategory($category_id) {
		$this->db->select('category_id, parent_id, category_name, category_cover, category_desc, category_lang');
		$this->db->from('category_table');
		$this->db->where('category_id', $category_id);
		$query = $this->db->get();

		return $query->result_array();
	}

	function getLeafCategory($lang) {
		$query = $this->db->query('SELECT category_id, category_name FROM category_table WHERE category_id NOT IN ( SELECT parent_id FROM category_table ) AND category_lang=' . $this->convertLangToFlag($lang));

		return $query->result_array();
	}

	function isLeafCategory($category_id) {
		$query = $this->db->query('SELECT * FROM category_table WHERE category_id NOT IN ( SELECT parent_id FROM category_table ) AND category_id=' . $category_id);

		if (count($query->result_array()) == 1) {
			return true;
		} else {
			return false;
		}
	}

	function getParentCategory($category_id) {
		$query = $this->db->query('SELECT category_id, category_name FROM category_table WHERE category_id IN ( SELECT parent_id FROM category_table WHERE category_id=' . $category_id . ' )');

		return $query->result_array();
	}

	function getCategoryName($category_id, $lang) {
		$this->db->select('category_name');
		$this->db->from('category_table');
		$this->db->where('category_id', $category_id);
		$this->db->where('category_lang', $this->convertLangToFlag($lang));
		$query = $this->db->get()->result_array();

		return $query[0]['category_name'];
	}

	function addCategory($category) {
		$this->db->insert('category_table', $category);

		return array(
			'ret' => 0,
			'categoryId' => $this->db->insert_id(),
		);
	}

	function deleteCategory($category_id) {
		$this->db->delete('category_table', array('category_id' => $category_id));

		return array(
			'ret' => $this->db->affected_rows() == 1 ? 0 : -1,
		);
	}

	function deleteCategoryChild($parent_id) {
		$this->db->delete('category_table', array('parent_id' => $parent_id));
	}

	function convertLangToFlag($lang) {
		switch ($lang) {
			case 'en':
				return en;
			case 'cn':
				return cn;
			default:
				return null;
		}
	}
}