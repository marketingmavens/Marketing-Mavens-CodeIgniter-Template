<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }

  function get($table,$query, $force_result = FALSE)
  {
    $q = $this->db->where($query)->get($table);
    if($q->num_rows() == 1 && $force_result === FALSE) :
      return $q->row();
    elseif($q->num_rows() > 0) :
      return $q->result();
    else :
      return FALSE;
    endif;
  }


  function insert($table,$data)
  {
    $this->db->insert($table,$data);
    return $this->get($table,array('id' => $this->db->insert_id()));
  }

  function update($table,$data,$where)
  {
    $this->db->update($table,$data,$where);
    if(isset($data['id']))
      return $this->get($table,array('id' => $data['id']));
    elseif(isset($where['id']))
      return $this->get($table,array('id' => $where['id']));
    else
      return TRUE;
  }

  function delete($table,$where)
  {
    $this->db->delete($table,$where);
  }

}