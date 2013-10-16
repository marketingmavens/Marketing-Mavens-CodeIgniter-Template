<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }

  /***
   * @param $table string
   * @param $query array
   * @param bool $force_result
   * @return object|array|bool
   */

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

  /***
   *
   * Gets the result and forces to return the first result if there is more
   * then one
   *
   * @param string $table
   * @param array $query
   * @return object
   */
  function get_first($table,$query)
  {
    $r = $this->get($table,$query);
    if(is_array($r)):
      return $r[0];
    endif;
    return $r;
  }

  /***
   * @param string $table
   * @param array $query
   * @param string $order_by
   * @param string $direction
   * @return object|bool
   */
  function get_first_order_by($table,$query,$order_by = 'id',$direction = 'ASC')
  {
    $r = $this->get_order_by($table,$query,$order_by,$direction);
    if(is_array($r)):
      return $r[0];
    endif;
    return $r;
  }


  /***
   * @param string $table
   * @param string $date_field
   * @param string $start_date
   * @param string $end_date
   * @param array $query
   * @param bool $force_result
   * @return array|object|bool
   */

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

  /***
   * @param string $table
   * @param string $field
   * @param array $not_any
   * @param array $query
   * @param bool $force_result
   * @return bool
   */
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

  /***
   * @param string $table
   * @param string $date_field
   * @param string $start_date
   * @param string $end_date
   * @param string $not_field
   * @param array $not_any
   * @param array $query
   * @param bool $force_result
   * @return bool
   */
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

  /***
   * @param string $table
   * @param array $query
   * @param string $order_by
   * @param string $direction
   * @param bool $force_result
   * @return object|array|bool
   */

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

  /***
   * @param string $table
   * @param array $query
   * @param string $key
   * @param string $name
   * @param string $sort
   * @param string $append_name
   * @param string $prepend_key
   * @return array
   */
  function get_list($table,$query,$key = 'id',$name = 'name', $sort = NULL, $append_name = NULL, $prepend_key = NULL)
  {
    if($sort == NULL) $sort = $name;
    $results = $this->get_order_by($table,$query,$sort,'ASC',TRUE);
    $list = array(0 => 'Please Select One');
    if($results == FALSE) return $list;
    foreach($results as $r):
      $key = $prepend_key . $r->$key;
      if(!empty($append_name) OR $append_name != NULL):
        $list[$key] = $r->$name . ' ' . $r->$append_name;
      else :
        $list[$key] = $r->$name;
      endif;
    endforeach;
    return $list;
  }

  /***
   * @param string $name setting name
   * @return string|bool
   */
  function get_setting($name)
  {
    $r = $this->get('settings',array('name' => $name));
    if(is_object($r)):
      return $r->value;
    endif;
    return FALSE;
  }

  /***
   * @param string $table
   * @param int $id
   * @param string $key
   * @return string|bool
   */
  function get_value($table,$id,$key)
  {
    $r = $this->get($table,array('id' => $id));
    if(isset($r->$key)) return $r->$key;
    return FALSE;
  }

  /***
   * @param string $table
   * @param array $data
   * @return object of inserted data
   */
  function insert($table,$data)
  {
    $this->db->insert($table,$data);
    return $this->get($table,array('id' => $this->db->insert_id()));
  }

  /***
   * @param string $table
   * @param array $data New Data
   * @param array $where
   * @return object|bool
   */
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

  /***
   * @param string $table
   * @param array $where
   */
  function delete($table,$where)
  {
    $this->db->delete($table,$where);
  }

}