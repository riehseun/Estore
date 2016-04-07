<?php
class Product_model extends CI_Model {
  function getAll() {  
	$query = $this->db->get('products');
	return $query->result('Product');
  }  
  function get($id) {
	$query = $this->db->get_where('products',array('id' => $id));	
	return $query->row(0,'Product');
  }
  function getByName($name) {
	$query = $this->db->get_where('products',array('name' => $name));	
	return $query->row(0,'Product');
  }
  function delete($id) {
	return $this->db->delete("products",array('id' => $id ));
  }
  function deleteAll() {
    return $this->db->empty_table('products');
  }
  // Atomic write operation	
  function insert($product) {	
    $this->db->trans_start();
	  $this->db->insert("products", array('name' => $product->name,'description' => $product->description,
	    'price' => $product->price,'photo_url' => $product->photo_url));
    $insert_id = $this->db->insert_id();
    $this->db->trans_complete();
    if($this->db->trans_status() === FALSE) {
      return false;
    }
    else {
      return $insert_id;
    }
  }
  function update($product) {
	  $this->db->where('id', $product->id);
	  return $this->db->update("products", array('name' => $product->name,'description' => $product->description,
	    'price' => $product->price));
  }	
}
?>
