<?php
/**
 * Created by PhpStorm.
 * User: lisonallen
 * Date: 14-2-10
 * Time: 下午10:44
 */

class AdminApi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('page');
        $this->load->model('category');
        $this->load->model('productmodel', 'product');
    }

    public function check_login() {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $ret = $this->check_account(array(
            'username' => $username,
            'password' => $password
        ));

        if($ret == 0) {
            $this->store_account(array(
                'username' => $username,
                'password' => $password
            ));
        }

        echo json_encode(array(
            'ret' => $ret
        ));
    }

    private function check_account($account) {
        $this->load->model( 'user' );

        return $this->user->isUser( $account['username'], $account['password'] ) ? 0 : 1;
    }

    private function store_account($account) {
        $this->load->library( array( 'session', 'encrypt' ) );

        $this->session->set_userdata( array(
            'user' => $account['username'],
            'pwd' => $this->encrypt->encode( $account['password'] )
        ) );
    }

    public function add_news() {
        $newsDetail = array(
            'page_title' => $this->input->get('newsTitle'),
            'page_content' => $this->input->get('newsContent'),
            'page_type' => 2,
            'page_author' => 1,
            'page_tag' => '',
            'page_lang' => ($this->input->get('enableNewsCn') == 'on') ? 2 : 1
        );

        $ret = $this->page->addNews($newsDetail);

        echo json_encode($ret);
    }

    public function update_news() {
        $news = array(
            'page_title' => $this->input->get('newsTitle'),
            'page_content' => $this->input->get('newsContent'),
        );

        $this->db->where('page_id', $this->input->get('newsId'));
        $ret = $this->db->update('page_table', $news);

        echo json_encode(array(
            'ret' => $ret ? 0 : -1
        ));
    }

    public function del_news() {
        $ret = $this->page->deleteNews($this->input->get('newsId') * 1);

        echo json_encode($ret);
    }

    public function get_news() {
        $ret = $this->page->getSingleNews($this->input->get('newsId') * 1);

        echo json_encode(array(
            'ret' => 0,
            'data' => $ret[0]
        ));
    }

    public function get_news_list() {
        $ret = $this->page->getAllNews();

        echo json_encode(array(
            'ret' => 0,
            'newsList' => $ret
        ));
    }

    public function get_all_category() {
        $ret = $this->category->getAllCategory();

        echo json_encode(array(
            'ret' => 0,
            'categoryList' => $ret
        ));
    }

    // http://www.taihepacking.com.hk/adminApi/add_category?categoryName=test&parentId=0&categoryDesc=&categoryCover=&categoryLang=1
    public function add_category() {
        $ret = $this->category->addCategory(array(
            'category_name' => $this->input->get('categoryName'),
            'parent_id' => $this->input->get('parentId'),
            'category_desc' => $this->input->get('categoryDesc'),
            'category_cover' => $this->input->get('categoryCover'),
            'category_lang' => $this->input->get('categoryLang')
        ));

        echo json_encode($ret);
    }

    // http://www.taihepacking.com.hk/adminApi/del_category?categoryId=138
    public function del_category() {
        $cid = $this->input->get('categoryId');
        $ret = $this->category->deleteCategory($cid);
        $this->del_category_children($cid);

        echo json_encode($ret);
    }

    private function del_category_children( $parentId ) {
        if( $this->category->isLeafCategory( $parentId ) ) {
            $this->product->deleteCategoryProduct( $parentId );
        } else {
            $children = $this->category->getChildCategory( $parentId );
            foreach( $children as $child ) {
                $this->category->deleteCategory( $child['category_id'] );
                $this->del_category_children( $child['category_id'] );
            }
        }
    }

    public function get_category_detail() {
        $ret = $this->category->getSingleCategory($this->input->get('categoryId'));

        echo json_encode(array(
            'ret' => 0,
            'categoryDetail' => $ret
        ));
    }

    public function update_category_detail() {
        $ret = $this->category->updateCategory($this->input->get('categoryId'), array(
            'category_name' => $this->input->get('categoryName'),
            'category_desc' => $this->input->get('categoryDesc'),
            'category_cover' => $this->input->get('categoryCover'),
            'category_lang' => $this->convert_lang_to_flag($this->input->get('categoryLang'))
        ));

        echo json_encode($ret);
    }

    public function upload_cate_cover() {
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

            // print_r( $data['upload_data']['file_name'] );
            echo '<img data-src="holder.js/200x200" src="../img/product/cover/'.$data['upload_data']['file_name'].'" class="img-rounded img-preview" alt="200x200" style="width: 200px; height: 200px;" id="cate-cover">
            <div class="loading-cover" id="cate-cover-loading" style="display: none"></div>
            <input type="hidden" id="cate-cover-url" value="'.$data['upload_data']['file_name'].'" />
            <script>$("#cate-cover").load(function(){$("#cate-detail-wrap").unmask()});</script>';
        }
    }

    public function upload_product_image() {
        $config['upload_path'] = './img/product/large/';
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

            $smallImageSrc = './img/product/small/'.$data['upload_data']['file_name'];
            $largeImageSrc = './img/product/large/'.$data['upload_data']['file_name'];

            $this->zoom_image($smallImageSrc, $largeImageSrc, 200, 3);

            echo '<img data-src="holder.js/500x500" src="../img/product/large/'.$data['upload_data']['file_name'].'" class="img-rounded img-preview" alt="500x500" style="width: 500px; height: 500px;" id="product-image">
            <img data-src="holder.js/200x200" src="../img/product/small/'.$data['upload_data']['file_name'].'" class="img-rounded img-preview" alt="140x140" style="width: 200px; height: 200px;" id="product-small-image">
            <input type="hidden" id="product-image-url" value="'.$data['upload_data']['file_name'].'" />
            <input type="hidden" id="product-small-image-url" value="'.$data['upload_data']['file_name'].'" />
            <div class="loading-cover" id="cate-cover-loading" style="display: none"></div>
            <script>$("#product-image").load(function(){$("#product-small-image").load(function(){$("#upload-product-image-wrap").unmask()})});</script>';

            // print_r( $data['upload_data']['file_name'] );
            /*echo '<img data-src="holder.js/200x200" src="../img/product/large/'.$data['upload_data']['file_name'].'" class="img-rounded img-preview" alt="200x200" style="width: 200px; height: 200px;" id="cate-cover">
            <div class="loading-cover" id="cate-cover-loading" style="display: none"></div>
            <input type="hidden" id="cate-cover-url" value="'.$data['upload_data']['file_name'].'" />
            <script>$("#cate-cover").load(function(){$("#cate-detail-wrap").unmask()});</script>';*/
        }
    }

    function get_slide_image_list() {
        $this->load->model('configmodel');

        $slidePhotoListStr = $this->configmodel->get_custom('slidePhotoList');
        $slidePhotoList = $slidePhotoListStr != null ? preg_split('/,/', $slidePhotoListStr) : array(
            'hk.2.jpg',
            'ywth.jpg',
            'db.jpg',
            'hkth.jpg'
        );

        echo json_encode(array(
            'ret' => 0,
            'slidePhotoList' => $slidePhotoList
        ));
    }

    function update_slide_image_list() {
        $this->load->model('configmodel');

        $slidePhotoListStr = $this->input->get('slidePhotoList', true);

        $ret = $this->configmodel->set_custom('slidePhotoList', $slidePhotoListStr);

        echo json_encode($ret);
    }

    function upload_slide_image() {
        $config['upload_path'] = './img/slide/origin/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = time();
        $config['max_size']	= '10000';
        $config['max_width']  = '10240';
        $config['max_height']  = '7680';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload( 'slide-image' ))
        {
            $error = array('error' => $this->upload->display_errors());

            print_r( $error );
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());

            $smallImageSrc = './img/slide/100x100/'.$data['upload_data']['file_name'];
            $largeImageSrc = './img/slide/origin/'.$data['upload_data']['file_name'];

            $this->zoom_image($smallImageSrc, $largeImageSrc, 100, 3);

            echo '<img src="../img/slide/100x100/'.$data['upload_data']['file_name'].'" data-src="holder.js/100x100" style="padding:0; margin:0;" id="slide-image-tag">
            <div class="loading-cover" id="slide-image-loading" style="display: none"></div>
            <input type="hidden" id="slide-image-url" value="'.$data['upload_data']['file_name'].'" />
            <script>$("#slide-image-tag").load(function(){$("#upload-slide-image-wrap").unmask()});</script>';
        }
    }

    function get_contact_list() {
        $this->load->model('configmodel');

        $contactAddressListStr = '';
        $contactAddressList = $this->configmodel->get_custom_group('contact');

        if(count($contactAddressList) > 0) {
            foreach($contactAddressList as $contactAddress) {
                $contactAddressListStr = $contactAddressListStr.($contactAddressListStr == '' ? '' : '?').$contactAddress['custom_key'].':'.$contactAddress['custom_value'];
            }
        }

        echo json_encode(array(
            'ret' => '0',
            'contactList' => $contactAddressListStr
        ));
    }

    function update_contact_list() {
        $this->load->model('configmodel');

        $contactAddressListStr = $this->input->get('contactList');
        //echo $contactAddressListStr;
        $contactAddressList = $contactAddressListStr != null ? preg_split('/\?/', $contactAddressListStr) : array();

        $contactAddressArray = array();
        foreach($contactAddressList as $contactAddress) {
            $contactAddressDetail = preg_split('/\:/', $contactAddress);

            $contactAddressArray[$contactAddressDetail[0]] = $contactAddressDetail[1];
        }

        echo json_encode($this->configmodel->set_custom_group($contactAddressArray));
    }

    function delete_contact() {
        $this->load->model('configmodel');

        $contactID = $this->input->get('contactID');

        echo json_encode($this->configmodel->del_custom($contactID));
    }

    function convert_lang_to_flag( $lang ) {
        switch( $lang ) {
            case 'en':
                return en;
            case 'cn':
                return cn;
            default:
                return null;
        }
    }

    public function add_product() {
        $productDesc = $this->input->get('productNO').','.$this->input->get('productPrice').','.$this->input->get('productMOQ').','.$this->input->get('productMaterial');
        $productSpec = $this->input->get('productSpec');

        $ret = $this->product->addProduct(array(
            'product_name' => $this->input->get('productName'),
            'product_category' => $this->input->get('productCategory'),
            'product_img_huge' => $this->input->get('productHugeImage'),
            'product_img_large' => $this->input->get('productImage'),
            'product_img_small' => $this->input->get('productSmallImage'),
            'product_desc' => $productDesc,
            'product_spec' => $productSpec,
            'product_lang' => $this->input->get('productLang')
        ));

        echo json_encode($ret);
    }

    public function update_product() {
        $productDesc = $this->input->get('productNO').','.$this->input->get('productPrice').','.$this->input->get('productMOQ').','.$this->input->get('productMaterial');
        $productSpec = $this->input->get('productSpec');

        $ret = $this->product->updateProduct($this->input->get('productId'), array(
            'product_name' => $this->input->get('productName'),
            'product_category' => $this->input->get('productCategory'),
            'product_img_huge' => $this->input->get('productHugeImage'),
            'product_img_large' => $this->input->get('productImage'),
            'product_img_small' => $this->input->get('productSmallImage'),
            'product_desc' => $productDesc,
            'product_spec' => $productSpec,
            'product_lang' => $this->input->get('productLang')
        ));

        echo json_encode($ret);
    }

    public function del_product() {
        $ret = $this->product->deleteProduct($this->input->get('productId'));

        echo json_encode($ret);
    }

    public function query_product_by_keyword() {
        $keyword = $this->input->get('keyword');
        $pageNum = $this->input->get('pageNum') != '' ? $this->input->get('pageNum') : 1;
        $pageSize = $this->input->get('pageSize') != '' ? $this->input->get('pageSize') : 20;

        $ret = $this->product->queryProduct(
            $keyword,
            $pageNum,
            $pageSize
        );

        echo json_encode($ret);
    }

    public function get_product_by_id() {
        $productId = $this->input->get('productId');

        $ret = $this->product->get_product($productId);

        echo json_encode($ret);
    }

    /*
     * @type: 通过type来指定何种模式进行缩放
     * type 0: 指定缩放目标宽度
     * type 1: 指定缩放目标高度
     * type 2: 指定缩放比例
     * type 3: 指定最长宽、高
     */
    function zoom_image( $dstSrc, $imgSrc, $targetSize, $type = 0 ) {

        // 缩放图片
        // 获取原图信息，获取原图尺寸getimagesize()
        list($imgWidth, $imgHeight) = getimagesize($imgSrc);

        // 计算获得缩放后图片相关参数
        switch($type) {
            case 0:
                $dstWidth = $targetSize;
                $dstHeight = $imgHeight * $targetSize / $targetSize;
                break;
            case 1:
                $dstHeight = $targetSize;
                $dstWidth = $imgWidth * $targetSize / $targetSize;
                break;
            case 2:
                $dstWidth = $targetSize * $imgWidth;
                $dstHeight = $targetSize * $imgHeight;
                break;
            case 3:
                $dstWidth = $imgWidth > $imgHeight ? $targetSize : $targetSize * $imgWidth / $imgHeight;
                $dstHeight = $imgWidth <= $imgHeight ? $targetSize : $targetSize * $imgHeight / $imgWidth;
                break;
            default:
                $dstWidth = $imgWidth;
                $dstHeight = $imgHeight;
                break;
        }

        // 调用imagecopyresampled()方法缩放图片
        $imgType = exif_imagetype($imgSrc);
        switch($imgType) {
            case IMAGETYPE_JPEG:
                $imgData = imagecreatefromjpeg($imgSrc);
                break;
            case IMAGETYPE_PNG:
                $imgData = imagecreatefrompng($imgSrc);
                break;
            case IMAGETYPE_GIF:
                $imgData = imagecreatefromgif($imgSrc);
                break;
            default:
                echo "载入图像错误";
                exit();
        }
        $midImg = imagecreatetruecolor($imgWidth, $imgHeight);
        imagecopy($midImg, $imgData, 0, 0, 0, 0, $imgWidth, $imgHeight);
        $dstImg = imagecreatetruecolor($dstWidth, $dstHeight);
        $ret = imagecopyresampled($dstImg, $midImg, 0, 0, 0, 0, $dstWidth, $dstHeight, $imgWidth, $imgHeight);
        switch($imgType) {
            case IMAGETYPE_JPEG:
                imagejpeg($dstImg, $dstSrc, 100);
                break;
            case IMAGETYPE_PNG:
                imagepng($dstImg, $dstSrc, 9);
                break;
            case IMAGETYPE_GIF:
                imagegif($dstImg, $dstSrc, 100);
                break;
            default:
                echo "图像类型错误";
                exit();
        }
        imagepng($dstImg, $dstSrc, 9);

        // 返回缩放后图标路径
        return $ret;
    }
}