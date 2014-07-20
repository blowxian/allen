<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lison Allen
 * Date: 11-10-15
 * Time: 下午3:42
 * To change this template use File | Settings | File Templates.
 */

class AdminDev extends CI_Controller
{
    public function test()
    {
        $this->load->helper(array('url'));

        $this->load->view('v2/admin/manage-news');
    }

    public function index()
    {
        $this->load->helper(array('form', 'url', 'html'));

        if ($this->isLogin()) {
            redirect('admin/home/');
        }

        $this->load->view('login');
    }

    public function manage_news() {
        $this->load->helper(array('url'));

        $this->load->view('v2/admin/manage-news');
    }

    public function manage_category() {
        $this->load->helper(array('url'));

        $this->load->view('v2/admin/manage-category');
    }

    public function manage_product() {
        $this->load->helper(array('url'));

        $this->load->view('v2/admin/manage-product');
    }

    public function home()
    {
        // redirect to Login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->view('admin-home');
    }

    public function addNews()
    {
        // redirect to Login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->view('add-news');
    }

    public function addProduct()
    {
        // redirect to Login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('category');

        $data['category_cn'] = $this->category->getLeafCategory('cn');
        $data['category_en'] = $this->category->getLeafCategory('en');

        $this->load->view('add-product', $data);
    }

    public function addCategory()
    {
        // redirect to login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('category');

        $data['category_cn'] = $this->reorderCategory($this->category->getCategory(-1, 0, 'cn'));
        $data['category_en'] = $this->reorderCategory($this->category->getCategory(-1, 0, 'en'));

        $this->load->view('add-category', $data);
    }

    public function manageNews()
    {
        // redirect to login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('page');

        $data['news'] = $this->page->getAllNews();

        $this->load->view('manage-news', $data);
    }

    public function updateNews($news_id)
    {
        // redirect to login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('page');

        $news_list = $this->page->getNews($news_id);

        $news_list[0]['page_content'] = $this->removeTag($news_list[0]['page_content']);

        $data['news'] = $news_list[0];

        $this->load->view('update-news', $data);
    }

    public function deleteNews($news_id)
    {
        // redirect to login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('page');

        $this->page->deleteNews($news_id);

        redirect('admin/manageNews');
    }

    public function manageCategory()
    {
        // redirect to login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('category');

        $data['category'] = $this->category->getAllCategory();

        $this->load->view('manage-category', $data);
    }

    public function updateCategory($category_id)
    {
        // redirect to login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('category');

        $category = $this->category->getSingleCategory($category_id);

        $data['category'] = $category[0];

        $data['parent_category'] = $this->reorderCategory($this->category->getCategory(-1, 0, ($data['category']['category_lang'] == 1 ? 'en' : 'cn')));

        $this->load->view('update-category', $data);
    }

    public function deleteCategory($category_id)
    {
        // redirect to login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('category');
        $this->load->model('productmodel');

        $this->category->deleteCategory($category_id);
        $this->deleteCategoryChild($category_id);

        redirect('admin/manageCategory');
    }

    private function deleteCategoryChild($parent_id)
    {
        if ($this->category->isLeafCategory($parent_id)) {
            $this->productmodel->deleteCategoryProduct($parent_id);
        } else {
            $children = $this->category->getChildCategory($parent_id);
            foreach ($children as $child) {
                $this->category->deleteCategory($child['category_id']);
                $this->deleteCategoryChild($child['category_id']);
            }
        }
    }

    public function manageProduct($page_num = 1, $search = "")
    {
        // redirect to login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('productmodel');

        $data['product'] = $this->productmodel->queryProduct($search, $page_num);
        $data['page_sum'] = $this->productmodel->getQueryPageSum($search);
        $data['page_num'] = $page_num;
        $data['search'] = $search;

        $this->load->view('manage-product', $data);
    }

    public function updateProduct($product_id)
    {
        // redirect to login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('productmodel');
        $this->load->model('category');

        $data['product'] = $this->productmodel->getSingleProduct($product_id);

        $data['product']['product_desc'] = explode(',', $data['product']['product_desc']);
        $data['product']['product_spec'] = explode(',', $data['product']['product_spec']);

        $data['category'] = $this->category->getLeafCategory($data['product']['product_lang'] == 1 ? 'en' : 'cn');

        $this->load->view('update-product', $data);
    }

    public function deleteProduct($product_id)
    {
        // redirect to login if not login
        $this->redirectToLogin();

        $this->load->helper(array('form', 'url', 'html'));

        $this->load->model('productmodel');

        $this->productmodel->deleteProduct($product_id);

        redirect('admin/manageProduct');
    }

    public function checkLogin()
    {
        $this->load->helper('url');

        // if account valid redirect to admin home page, else redirect to login page
        if ($this->checkAccount($_POST['user'], $_POST['pwd'])) {
            // keep account in session
            $this->storeAccount($_POST['user'], $_POST['pwd']);

            // redirect to admin home page
            redirect('admin/home/');
        } else {
            // redirect to login page
            redirect('admin/');
        }
    }

    ////////////////////////////////functions communicate with models///////////////////////////////

    // add news to database
    public function addNewsToDb()
    {
        // redirect to Login if not login
        $this->redirectToLogin();

        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('page');

        if (isset($_POST['enable-news-cn']) && $_POST['enable-news-cn'] == 'on') {
            $news_cn = array(
                'page_title' => $this->input->post('news-title-cn'),
                'page_content' => $this->addParaTag($this->input->post('news-content-cn')),
                'page_type' => 2,
                'page_author' => 1,
                'page_tag' => '',
                'page_lang' => 2
            );

            // add news detail into database
            $this->page->addNews($news_cn);
        }

        if (isset($_POST['enable-news-en']) && $_POST['enable-news-en'] == 'on') {
            $news_en = array(
                'page_title' => $this->input->post('news-title-en'),
                'page_content' => $this->addParaTag($this->input->post('news-content-en')),
                'page_type' => 2,
                'page_author' => 1,
                'page_tag' => '',
                'page_lang' => 1
            );

            // add news detail into database
            $this->page->addNews($news_en);
        }

        redirect('admin/addnews');
    }

    // modify news to database
    public function updateNewsToDb()
    {
        // redirect to Login if not login
        $this->redirectToLogin();

        $this->load->helper('url');
        $this->load->model('page');

        $news = array(
            'page_title' => $this->input->post('news-title'),
            'page_content' => $this->addParaTag($this->input->post('news-content')),
        );

        $this->db->where('page_id', $this->input->post('news-id'));
        $this->db->update('page_table', $news);

        redirect('admin/managenews');
    }

    // add product detail to database
    public function addProductToDb()
    {
        // redirect to Login if not login
        $this->redirectToLogin();

        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('productmodel');

        if (isset($_POST['enable-product-cn']) && $_POST['enable-product-cn'] == 'on') {

            $product_desc = $_POST['product-no-cn'] . ',' . $_POST['product-price-cn'] . ',' . $_POST['min-book-cn'] . ',' . $_POST['product-on-sale-cn'];

            $index = 0;
            $product_spec = '';

            while (isset($_POST['spec-no-cn-' . strval($index)])) {
                if ($index != 0) {
                    $product_spec .= ',';
                }
                $product_spec .= $_POST['spec-no-cn-' . strval($index)] . ',' . $_POST['spec-size-cn-' . strval($index)] . ',' . $_POST['spec-min-cn-' . strval($index)];

                $index++;
            }

            $product = array(
                'product_name' => $_POST['product-name-cn'],
                'product_category' => $_POST['product-category-cn'],
                'product_img_huge' => $_POST['product-huge-image'],
                'product_img_large' => $_POST['product-large-image'],
                'product_img_small' => $_POST['product-small-image'],
                'product_desc' => $product_desc,
                'product_spec' => $product_spec,
                'product_lang' => 2
            );

            $this->productmodel->addProduct($product);

        }

        if (isset($_POST['enable-product-en']) && $_POST['enable-product-en'] == 'on') {

            $product_desc = $_POST['product-no-en'] . ',' . $_POST['product-price-en'] . ',' . $_POST['min-book-en'] . ',' . $_POST['product-on-sale-en'];

            $index = 0;
            $product_spec = '';

            while (isset($_POST['spec-no-en-' . $index])) {
                if ($index != 0) {
                    $product_spec .= ',';
                }
                $product_spec .= $_POST['spec-no-en-' . $index] . ',' . $_POST['spec-size-en-' . $index] . ',' . $_POST['spec-min-en-' . $index];

                $index++;
            }

            $product = array(
                'product_name' => $_POST['product-name-en'],
                'product_category' => $_POST['product-category-en'],
                'product_img_large' => $_POST['product-large-image'],
                'product_img_small' => $_POST['product-small-image'],
                'product_desc' => $product_desc,
                'product_spec' => $product_spec,
                'product_lang' => 1
            );

            $this->productmodel->addProduct($product);

        }

        redirect('admin/addproduct');

    }

    // update product to database
    public function updateProductToDb()
    {
        // redirect to Login if not login
        $this->redirectToLogin();

        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('productmodel');

        $product_desc = $_POST['product-no'] . ',' . $_POST['product-price'] . ',' . $_POST['min-book'] . ',' . $_POST['product-on-sale'];

        $index = 0;
        $product_spec = '';

        while (isset($_POST['spec-no-' . strval($index)])) {
            if ($index != 0) {
                $product_spec .= ',';
            }
            $product_spec .= $_POST['spec-no-' . strval($index)] . ',' . $_POST['spec-size-' . strval($index)] . ',' . $_POST['spec-min-' . strval($index)];

            $index++;
        }

        $product = array(
            'product_name' => $_POST['product-name'],
            'product_category' => $_POST['product-category'],
            'product_img_huge' => $_POST['product-huge-image'],
            'product_img_large' => $_POST['product-large-image'],
            'product_img_small' => $_POST['product-small-image'],
            'product_desc' => $product_desc,
            'product_spec' => $product_spec,
            'product_lang' => $_POST['product-lang']
        );

        $this->productmodel->updateProduct($_POST['product-id'], $product);

        redirect('admin/manageproduct');

    }

    // add category to database
    public function addCategoryToDb()
    {
        // redirect to Login if not login
        $this->redirectToLogin();

        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('category');

        if (isset($_POST['enable-category-cn']) && $_POST['enable-category-cn'] == 'on') {
            $category_cn = array(
                'category_name' => $this->input->post('category-name-cn'),
                'parent_id' => $this->input->post('parent-id-cn'),
                'category_desc' => $this->input->post('category-desc-cn'),
                'category_cover' => $this->input->post('category-cover-image'),
                'category_lang' => 2
            );

            // add category detail into database
            $this->category->addCategory($category_cn);
        }

        if (isset($_POST['enable-category-en']) && $_POST['enable-category-en'] == 'on') {
            $category_en = array(
                'category_name' => $this->input->post('category-name-en'),
                'parent_id' => $this->input->post('parent-id-en'),
                'category_desc' => $this->input->post('category-desc-en'),
                'category_cover' => $this->input->post('category-cover-image'),
                'category_lang' => 1
            );

            // add category detail into database
            $this->category->addCategory($category_en);
        }

        redirect('admin/addcategory');
    }

    // update category to database
    public function updateCategoryToDb()
    {
        // redirect to Login if not login
        $this->redirectToLogin();

        $this->load->helper('url');
        $this->load->model('category');

        $category = array(
            'category_name' => $this->input->post('category-name'),
            'parent_id' => $this->input->post('parent-id'),
            'category_desc' => $this->input->post('category-desc'),
            'category_cover' => $this->input->post('category-cover-image')
        );

        // update category
        $this->db->where('category_id', $this->input->post('category_id'));
        $this->db->update('category_table', $category);

        redirect('admin/managecategory');
    }

    // check account valid
    private function checkAccount($user, $pwd)
    {

        $this->load->model('user');

        // check is user&password valid
        return $this->user->isUser($user, $pwd);
    }

    ////////////////////////////////below are component functions///////////////////////////////

    // if not login, redirect login page
    private function redirectToLogin()
    {
        echo base_url().'admin/';
//        if (!$this->isLogin()) {
//            redirect('admin/');
//        }
    }

    // check is login
    private function isLogin()
    {
        $this->load->library(array('session', 'encrypt'));

        $this->load->helper('url');

        if ($this->checkAccount($this->session->userdata('user'), $this->encrypt->decode($this->session->userdata('pwd')))) {
            return true;
        } else {
            return false;
        }
    }

    // keep account in session
    private function storeAccount($user, $pwd)
    {
        $this->load->library(array('session', 'encrypt'));

        $this->session->set_userdata(array(
            'user' => $user,
            'pwd' => $this->encrypt->encode($pwd)
        ));
    }

    // add paragraph tag
    private function addParaTag($content)
    {
        $content = '<p>' . $content . '</p>';

        return str_replace(chr(13), "</p><p>", $content);
    }

    // remove tag
    private function removeTag($content)
    {
        print_r("Test" . chr(10) . "Test");
        return strip_tags(preg_replace("/\<\/p\>\s+\<p\>/", "\n", $content));
    }

    // reorder categories
    private function reorderCategory($category, $category_id = 0)
    {
        $resorted_category = array();

        foreach ($category as $category_item) {
            if ($category_item['parent_id'] == $category_id) {
                $category_item['child_category'] = $this->reorderCategory($category, $category_item['category_id']);
                array_push($resorted_category, $category_item);
            }
        }

        return $resorted_category;
    }
}