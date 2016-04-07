<?php
class order_item_model extends CI_Model {
  function get($order_id) {
    $query = $this->db->get_where('order_items',array('order_id'=>$order_id));
    return $query->result('OrderItem');
  }
  // Atomic write operation
  function insert($order_item) {
    $this->db->trans_start();	
    $this->db->insert("order_items",array('order_id' => $order_item->order_id,
      'product_id' => $order_item->product_id,'quantity' => $order_item->quantity));
    $insert_id = $this->db->insert_id();
    $this->db->trans_complete();
    if($this->db->trans_status() === FALSE) {
      return false;
    }
    else {
      return $insert_id;
    }
  }
}
