<?php
class Admin extends CI_Controller {
  function __construct() {
    // Call the Controller constructor
	  parent::__construct();
    session_start();
    $this->load->database();
    // Configure settings for uploading images
    $config['upload_path'] = realpath(APPPATH . '../images/product');
    $config['allowed_types'] = 'gif|jpg|png';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);	    	
  }

  function check_admin() {
    if(isset($_SESSION["login"]) && strcmp("admin",$_SESSION["login"]) == 0) {
      //redirect('admin/index','refresh');
      return true;
    }
    else {
      redirect('store/login','refresh');
      return false;
    }
  }

  function logout() {
    if(!$this->check_admin()) {
      return;
    }
    $_SESSION = array();
    // sends as Set-Cookie to invalidate the session cookie
    if (isset($_COOKIE[session_name()])) { 
      $params = session_get_cookie_params();
      setcookie(session_name(), '', 1, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
    }
    session_destroy();
    redirect('store/login','refresh');
  }

  function index() {
    if(!$this->check_admin()) {  
      return;
    }
    $data['title'] = 'Administrator Page';
    $data['main'] = 'admin/index.php';
    $this->load->view('admin/template.php',$data);
  }

  function deleteCustomerOrder() {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('customer_model');
    $this->load->model('order_model');
    $this->order_model->deleteAll();
    $this->customer_model->deleteAll();
    redirect('admin/index','refresh');
  }

  function deleteAll() {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('customer_model');
    $this->load->model('product_model');
    $this->load->model('order_model');
    $this->order_model->deleteAll();
    $this->customer_model->deleteAll();
    $this->product_model->deleteAll();
    redirect('admin/index','refresh');
  }

  function product() {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('product_model');
    $products = $this->product_model->getAll();
    $data['products']=$products;
    $data['title'] = 'Product List Page';
    $data['main'] = 'admin/list.php';
    $this->load->view('admin/template.php',$data);
  }
    
  function newForm() {
    if(!$this->check_admin()) {
      return;
    }
    $data['title'] = 'Add New Product';
    $data['main'] = 'admin/newForm.php';
    $this->load->view('admin/template.php',$data);
  }
    
  function create() {
    if(!$this->check_admin()) {
      return;
    }
	  $this->load->library('form_validation');
	  $this->form_validation->set_rules('name','Name','required|is_unique[products.name]|min_length[1]|max_length[45]');
	  $this->form_validation->set_rules('description','Description','required');
	  $this->form_validation->set_rules('price','Price','required|greater_than[0]');
	  $fileUploadSuccess = $this->upload->do_upload();
	  if ($this->form_validation->run() == true && $fileUploadSuccess) {
	    $this->load->model('product_model');
	    $product = new Product();
	    $product->name = $this->input->get_post('name');
	    $product->description = $this->input->get_post('description');
	    $product->price = $this->input->get_post('price');
	    $data = $this->upload->data();
	    $product->photo_url = $data['file_name'];
	    $this->product_model->insert($product);
	    //Then we redirect to the index page again
	    redirect('admin/product', 'refresh');
    }
	  else {
      $data['title'] = 'Add New Product';
      $data['main'] = 'admin/newForm.php';
	    if (!$fileUploadSuccess) {
		    $data['fileerror'] = $this->upload->display_errors();
        $this->load->view('admin/template.php',$data);
	    }
      else {
        $this->load->view('admin/template.php',$data);
      }
	  }	
  }

  function productDeleteAll() {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('product_model');
    $this->product_model->deleteAll();
    redirect('admin/product','refresh');
  }
	
  function read($id) {
    if(!$this->check_admin()) {
      return;
    }
	 $this->load->model('product_model');
	 $product = $this->product_model->get($id);
	 $data['product']=$product;
    $data['title'] = 'Product Detail';
    $data['main'] = 'admin/read.php';
    $this->load->view('admin/template.php',$data);
  }
	
  function editForm($id) {
    if(!$this->check_admin()) {
      return;
    }
	 $this->load->model('product_model');
	 $product = $this->product_model->get($id);
	 $data['product']=$product;
   $data['title'] = 'Product Edit';
   $data['main'] = 'admin/editForm.php';
	 $this->load->view('admin/template.php',$data);
  }
	
  function update($id) {
    if(!$this->check_admin()) {
      return;
    }
	  $this->load->library('form_validation');
	  $this->form_validation->set_rules('name','Name','required|min_length[1]|max_length[45]|callback_name_check');
	  $this->form_validation->set_rules('description','Description','required');
	  $this->form_validation->set_rules('price','Price','required|greater_than[0]');
    $this->load->model('product_model');
    $product = $this->product_model->get($id);
    $product->name = $this->input->get_post('name');
    $product->description = $this->input->get_post('description');
    $product->price = $this->input->get_post('price');
    $data['title'] = 'Product Edit';
    $data['main'] = 'admin/editForm.php';
    $data['product'] = $product;
	  if ($this->form_validation->run() == true) {
	    $this->load->model('product_model');
      $ret = $this->product_model->update($product);
      //Then we redirect to the index page again
      redirect('admin/product', 'refresh');
	  }
	  else {
	    $this->load->view('admin/template.php',$data);
	  }
  }

  function name_check($name) {
    $this->load->model('product_model');
    $product = $this->product_model->getByName($name);
    if(!empty($product) && $product->id != $this->uri->segment(3)) {
      $this->form_validation->set_message('name_check','Duplicated Names');
      return false;
    }
    return true;
  }
    	
  function delete($id) {
    if(!$this->check_admin()) {
      return;
    }
	  $this->load->model('product_model');
	  if (isset($id)) { 
	    $this->product_model->delete($id);
	  }	
	  //Then we redirect to the index page again
	  redirect('/admin/product', 'refresh');
  }

  function customer() {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('customer_model');
    $customers = $this->customer_model->getAll();
    $data['title'] = 'Customer Page';
    $data['main'] = 'admin/customer.php'; 
    $data['customers']=$customers;
    $this->load->view('admin/template.php',$data); 
  }

  function customerDelete($id) {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('customer_model');
    if(isset($id)) {
      $this->customer_model->delete($id);
    }
    redirect('admin/customer','refresh');
  }

  function customerDeleteAll() {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('customer_model');
    $this->customer_model->deleteAll();
    redirect('admin/customer','refresh');
  }

  function order() {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('order_model');
    $orders = $this->order_model->getAll();
    $data['title'] = 'Order List';
    $data['main'] = 'admin/order.php';
    $data['orders']=$orders;
    $this->load->view('admin/template.php',$data);
  }

  function orderDetail($id) {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('customer_model');
    $this->load->model('order_model');
    $this->load->model('order_item_model');
    $this->load->model('product_model'); 
    $order = $this->order_model->get($id);
    $customer = $this->customer_model->getById($order->customer_id);
    $order_items = $this->order_item_model->get($id);
    $item_array = array();
    foreach($order_items as $item) {
      $product = $this->product_model->get($item->product_id);
      $item_array[$product->id] = $product;
    }
    $data['customer'] = $customer;
    $data['order'] = $order;
    $data['order_items'] = $order_items;
    $data['item_array'] = $item_array;
    $data['title'] = 'Order Detail';
    $data['main'] = 'admin/order_item.php';
    $this->load->view('admin/template.php',$data); 
  }

  function orderDelete($id) {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('order_model');
    if(isset($id)) {
      $this->order_model->delete($id);
    }
    redirect('admin/order','refresh');
  }

  function orderDeleteAll() {
    if(!$this->check_admin()) {
      return;
    }
    $this->load->model('order_model');
    $this->order_model->deleteAll();
    redirect('admin/order','refresh');
  }
}
