<?php
class customer_model extends CI_Model {
  function getAll() {
    $query = $this->db->get('customers');
    return $query->result('Customer');
  }
  function getById($id) {
    $query = $this->db->get_where('customers',array('id'=>$id));
    if($query->num_rows() > 0) {
      return $query->row(0,'Customer');
    }
    else {
      return false;
    }
  }
  function get($login) {
    $query = $this->db->get_where('customers',array('login'=>$login));
    if($query->num_rows() > 0) {
      return $query->row(0,'Customer');
    }
    else {
      return false;
    }
  }
  function deleteAll() {
    $this->db->where_not_in('login','admin');
    return $this->db->delete('customers');
  }
  function delete($id) {
    return $this->db->delete("customers",array('id'=>$id));
  }
  // Atomic write operation
  function insert($customer) {
    $this->db->trans_start();
    $this->db->insert("customers",array('first' => $customer['first'],'last' => $customer['last'],
      'login' => $customer['login'],'password' => $customer['password'],'email' => $customer['email']));
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
