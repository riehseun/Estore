<?php
class order_model extends CI_Model {
  function getAll() {
    $query = $this->db->get('orders');
    return $query->result('Order');
  }
  function get($id) {
    $query = $this->db->get_where('orders',array('id'=>$id));
    return $query->row(0,'Order');
  }
  function deleteAll() {
    return $this->db->empty_table('orders');
  }
  function delete($id) {
    return $this->db->delete("orders",array('id'=>$id));
  }
  // Atomic write operation
  function insert($order,$cart_array) {
    $this->load->model('order_item_model');
    $this->db->trans_start();
    $this->db->insert("orders",array('customer_id' => $order['customer_id'],'order_date' => $order['order_date'],
      'order_time' => $order['order_time'],'total' => $order['total'],'creditcard_number' => $order['creditcard_number'],
      'creditcard_month' => $order['creditcard_month'],'creditcard_year' => $order['creditcard_year'] ));
    $insert_id = $this->db->insert_id();
    foreach($cart_array as $order_item) {
      $order_item->order_id = $insert_id;
      $this->order_item_model->insert($order_item);
    }
    $this->db->trans_complete();
    if($this->db->trans_status() === FALSE) {
      return false;
    }
    else {
      return $insert_id;
    }
  }
}
