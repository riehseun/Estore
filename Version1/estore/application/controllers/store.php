<?php
class Store extends CI_Controller {
  function __construct() {
    // Call the Controller constructor
    parent::__construct();
    session_start();
    $this->load->database();
  }

  function check_login() {    
    if (!isset($_SESSION["login"])) {
      //$this->load->view('login');
      redirect('store/login', 'refresh');
      return false;
    }
    return true;
  }

  function drawview($title,$view_name,$data) {
    $data['title'] = $title;
    $data['main'] = $view_name;
    if (isset($_SESSION['login'])) {
      $data['user'] = $_SESSION['login'];
    }
    $this->load->view('template.php',$data);
  }


  // Entry point
  function index() {
    $this->drawview('Welcome to Estore!','index.php',[]);
  }

  function register() {
    if (isset($_SESSION["login"])) {
      redirect('store/product','refresh');
      return;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $this->drawview('Registering new customer','register.php',[]);
      return;
    }
    // Server side input validation
    $this->load->library('form_validation');
    $this->form_validation->set_rules('first','First','required|min_length[1]|max_length[24]');
    $this->form_validation->set_rules('last','Last','required|min_length[1]|max_length[24]');
    $this->form_validation->set_rules('login','Username','required|is_unique[customers.login]|min_length[1]|max_length[16]');
    $this->form_validation->set_rules('password','Password','required|min_length[6]|max_length[16]');
    $this->form_validation->set_rules('passwordconf','Password Confirmation','required|matches[password]');
    $this->form_validation->set_rules('email','Email address','required|min_length[1]|max_length[45]|valid_email');
    if ($this->form_validation->run() == true) {
      $this->load->model('customer_model');
      $result = $this->customer_model->insert($_POST); 
      if ($result !== false) {
        $_SESSION["id"] = $result;
        $_SESSION["login"] = $_POST["login"];
        $_SESSION["password"] = $_POST["password"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION['cart_array'] = array();
        redirect('store/product','refresh');
        return;
      }
      else {
        $data['message'] = $this->db->_error_number();
        //1062 means same unique contraint violation
        $this->drawview('Registering new customer','register.php',$data);
      }
    }
    else {
      $data['message'] = 'Use miss something.';
      $this->drawview('Registering new customer','register.php',$data);
    }
  }

  function login() {
    if (isset($_SESSION["login"])) {
      redirect('store/product','refresh');
      return;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $this->drawview('Login','login.php',[]);
      return;
    }
    // Server side input validation
    $this->load->library('form_validation');
    $this->form_validation->set_rules('login','Username','required|min_length[1]|max_length[16]');
    $this->form_validation->set_rules('password','Password','required|min_length[6]|max_length[16]');
    if ($this->form_validation->run() == true) {
      $this->load->model('customer_model');
      $customer = $this->customer_model->get($_POST["login"]);
      // Password checking
      if ( $customer !== false && strcmp($customer->password,$_POST["password"]) == 0) {
        $_SESSION["id"] = $customer->id;
        $_SESSION["login"] = $customer->login;
        $_SESSION["password"] = $customer->password;
        $_SESSION["email"] = $customer->email;
        $_SESSION['cart_array'] = array();
        redirect('store/product','refresh');
        return;
      } 
      else {
        $some['message'] = 'Wrong ID/Password';
        $this->drawview('Login','login.php',$some);
        return;
      }
    }
    else {
      $this->drawview('Login','login.php',[]);
    }
  }

  function logout() {
    if (!$this->check_login()) {
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

  function product() {
    if (!$this->check_login()) {
      return;
    }
    $this->load->model('product_model');
    $products = $this->product_model->getAll();
    $data['products'] = $products;
    $this->drawview('Product List','product.php',$data);
  }

  function product_detail($id) {
    if (!$this->check_login()) {
      return;
    }
    $this->load->model('product_model');
    $product = $this->product_model->get($id);
    if (is_a($product,'product')) {
      $data['product'] = $product;
      $this->drawview($product->name,'product_detail.php',$data);
    }
    else {
      redirect('store/product','refresh');
    }
  }

  function cart() {
    if (!$this->check_login()) {
      return;
    }
    $cart_array = $_SESSION['cart_array'];       
    $item_array = array();
    $total_amount = 0;
    foreach ($cart_array as $pid => $order_item) {
      $this->load->model('product_model');
      $item = $this->product_model->get($order_item->product_id);
      $item_array[$pid] = $item;
    }
    $data['cart_array'] = $cart_array;
    $data['item_array'] = $item_array;
    $this->drawview('Cart','cart.php',$data);
  }

  function addcart($id) {
    if (!$this->check_login()) {
      return;
    }
    $this->load->model('product_model');
    $product = $this->product_model->get($id);
    if (is_a($product,'product')) {
      if (isset($_SESSION['cart_array'][$id])) {
        $_SESSION['cart_array'][$id]->quantity++;
      }
      else {
        $order_item = new OrderItem();
        $order_item->product_id = $id;
        $order_item->quantity = 1;
        $_SESSION['cart_array'][$id] = $order_item;
      }
    }
    redirect('store/cart','refresh');
  }

  function updatecart($id) {
    if (!$this->check_login()) {
      return;
    }
    if (isset($_REQUEST['quantity'])) {
      $quantity = $_REQUEST['quantity'];
      if ($quantity >= 1 && $quantity <= 100) {
        if (isset($_SESSION['cart_array'][$id])) {
          $_SESSION['cart_array'][$id]->quantity = $quantity;
        }
      }
    }        
    redirect('store/cart','refresh');
  }

  function removecart($id) {
    if (!$this->check_login()) {
      return;
    }
    if (strcmp($id,"0") === 0) {
      $_SESSION['cart_array'] = array();
    }
    else {
      unset($_SESSION['cart_array'][$id]);
    }
    redirect('store/cart','refresh');
  }

  function checkout() {
    if (!$this->check_login()) {
      return;
    }
    $cart_array = $_SESSION['cart_array'];       
    $item_array = array();
    $total_amount = 0;
    foreach ($cart_array as $pid => $order_item) {
      $this->load->model('product_model');
      $item = $this->product_model->get($order_item->product_id);
      $item_array[$pid] = $item;
      $total_amount = $total_amount + $item->price * $order_item->quantity;
    }
    $data['cart_array'] = $cart_array;
    $data['item_array'] = $item_array;
    // User presses "checkout" button
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $this->drawview('Chcekout','checkout.php',$data);
      return;
    }
    // User presses "place order" button
    else {
      date_default_timezone_set('America/New_York');
      $date = date("Y/m/d");
      $time = date("h:i:s A");
      $email = $_SESSION["email"];
      $this->load->library('form_validation');
      $this->form_validation->set_rules('credit','Credit Card Number','required|callback_check_card');
      $this->form_validation->set_rules('month','Expiration Month','required|callback_check_month');
      $this->form_validation->set_rules('year','Expiration Year','required|callback_check_year');
      if ($this->form_validation->run() == true) {
        $this->load->model('order_model');
        $order = array();
        $order['customer_id']=$_SESSION['id'];
        $order['order_date'] = $date;
        $order['order_time'] = $time;
        $order['total'] = $total_amount;
        $order['creditcard_number'] = $_POST['credit'];
        $order['creditcard_month'] = $_POST['month'];
        $order['creditcard_year'] = $_POST['year'];
        $return_val = $this->order_model->insert($order,$cart_array);
        if ($return_val !== false) {
          $this->load->library('email');
          $this->email->set_mailtype("html");
          $this->email->from('fkcsc309a3@gmail.com', 'estore');
          $this->email->to($email);
          $this->email->subject('Receipt');
          $this->email->message($this->load->view('receipt.php', $data, true));
          $this->email->send(); 
          
          $_SESSION['cart_array'] = array(); //Cart goes empty.
          $_SESSION['order_id'] = $return_val; 

          redirect('store/receipt', 'refresh');
        }
        else {
          $data['message'] = 'something wrong during transcation';
          $this->drawview('Checkout','checkout.php',$data);
        }
      }
      else {
        $this->drawview('Checkout','checkout.php',$data);
      }
    }
  }

  function receipt() {
    if (!$this->check_login()) {
      return;
    }
    if (!isset($_SESSION['order_id'])) {
      redirect('store/product','refresh');
      return;
    }
    $id = $_SESSION['order_id'];
    unset( $_SESSION['order_id'] );
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
    $this->drawview('Thanks for purchasing!','finalized_order.php',$data);
  }

  function small_month_check($month) {
    $month_array = ['01','02','03','04','05','06','07','08','09','10','11','12'];
    $valid = false;
    for ($i=0; $i<12; $i++) {
      if(strcmp($month,$month_array[$i]) == 0) {
        $valid = true;
        break;
      }
    }
    return $valid;
  }
  function small_year_check($year) {
    return !(preg_match("/^\d{2}$/i",$year) == 0);
  }

  function check_month($month) {
    if (!$this->small_month_check($month)) {
      $this->form_validation->set_message('check_month','Not valid month');
      return false;
    }
    return true;
  }

  function check_card($card) {
    $a = preg_match("/^\d{16}$/i",$card);
    if (preg_match("/^\d{16}$/i",$card) == 0) {
      $this->form_validation->set_message('check_card','Not valid card');
      return false;
    }
    $month = $_POST['month'];
    $year = '20'.$_POST['year'];

    if( $this->small_year_check($_POST['year']) && $this->small_month_check($_POST['month']) ) {

	    $exp_ts = mktime(0, 0, 0, $month + 1, 1, $year);
	    date_default_timezone_set('America/New_York');
	    $cur_ts = time();
	    if ($cur_ts > $exp_ts) {
	      $this->form_validation->set_message('check_card','Expired Card');
	      return false;
	    }
    }
    return true;
  }

  function check_year($year) {
    if (!$this->small_year_check($year)) {
      $this->form_validation->set_message('check_year','Not valid year');
      return false;
    }
    return true;
  }
}
?>
