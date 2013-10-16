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

  function get_between($table,$date_field,$start_date,$end_date, $query = array(), $force_result = FALSE)
  {
    $q = $this->db->where($query)->where($date_field . ' >= ',$start_date)->where($date_field . ' <=',$end_date)->get($table);
    if($q->num_rows() == 1 && $force_result === FALSE) :
      return $q->row();
    elseif($q->num_rows() > 0) :
      return $q->result();
    else :
      return FALSE;
    endif;
  }

  function get_not_any($table,$field,$not_any = array(),$query = array(),$force_result = FALSE)
  {
    $this->db->where($query);
    foreach($not_any as $v):
      $this->db->where($field . ' != ', $v);
    endforeach;
    $q = $this->db->get($table);
    if($q->num_rows() == 1 && $force_result === FALSE) :
      return $q->row();
    elseif($q->num_rows() > 0) :
      return $q->result();
    else :
      return FALSE;
    endif;
  }

  function get_between_and_not_any($table,$date_field,$start_date,$end_date,$not_field,$not_any = array(),$query = array(),$force_result = FALSE)
  {
    $this->db->where($query);
    foreach($not_any as $v):
      $this->db->where($not_field . ' != ', $v);
    endforeach;
    $this->db->where($date_field . ' >= ',$start_date);
    $this->db->where($date_field . ' <=',$end_date);
    $q = $this->db->get($table);
    if($q->num_rows() == 1 && $force_result === FALSE) :
      return $q->row();
    elseif($q->num_rows() > 0) :
      return $q->result();
    else :
      return FALSE;
    endif;
  }

  function get_order_by($table,$query,$order_by,$direction = 'ASC',$force_result = FALSE)
  {
    $q = $this->db->where($query)->order_by($order_by,$direction)->get($table);
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