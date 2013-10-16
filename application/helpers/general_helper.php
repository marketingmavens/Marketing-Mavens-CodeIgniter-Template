<?php

/***
 *
 * Simple Print function allowing easier
 * printing of arrays or data, dumbs data
 * if passed as TRUE
 *
 * @param string|array|object $data
 * @param bool $dump
 */
function pr($data,$dump = FALSE)
{
  if($dump == TRUE):
    var_dump($data);
  else :
    echo '<pre>';
    print_r($data);
    echo '</pre>';
  endif;
}



/***
 *
 * Checks if isset and also allows a default as
 * well as appending the string before or after
 *
 * @param $content
 * @param null $default
 * @param null $before
 * @param null $after
 * @return null|string
 */

function _e(&$content,$default = NULL, $before = NULL, $after = NULL)
{
  if(isset($content) && strlen($content) > 1)
    return $before . $content . $after;
  elseif(strlen($default) < 1)
    return NULL;
  else
    return $before . $default . $after;
}




/***
 *
 * Checks if isset and returns number format
 *
 * @param $content
 * @param int $dec
 * @return string
 */
function _m(&$content,$dec = 2)
{
  if(isset($content) && strlen($content) > 1)
    return number_format($content,$dec);
  else
    return number_format(0,$dec);
}

/***
 *
 * Converts an array to object
 *
 * @param $data
 * @return mixed
 */
function array_to_object($data)
{
  return json_decode (json_encode ($data), FALSE);
}


/***
 *
 * Sorts a multi dimensional array by a key
 *
 * @param array|object $array
 * @param string $key to sort by
 * @param string $direction either ASC or DESC
 * @param string $type
 * @return array|mixed
 */
function sort_array ($array, $key, $direction = 'ASC', $type = 'arr') {
  $sorter = array();
  $ret = array();
  reset($array);
  foreach ($array as $ii => $va) {
    if($type == 'obj')
      $sorter[$ii] = $va->$key;
    else
      $sorter[$ii] = $va[$key];
  }
  if($direction == 'DESC')
    arsort($sorter);
  else
    asort($sorter);

  foreach ($sorter as $ii => $va) {
    $ret[$ii] = $array[$ii];
  }
  if($type == 'obj')
    return json_decode (json_encode ($ret), FALSE);
  return $ret;

}

/***
 *
 * Gets the number of months between two dates
 *
 * @param $start_date
 * @param $end_date
 * @return int
 */
function get_months_between($start_date,$end_date)
{
  return (int)abs((strtotime($start_date) - strtotime($end_date))/(60*60*24*30));
}




/***
 * @param string $key_format
 * @param string $value_format
 * @param bool $include_select_one
 * @return array
 */
function month_list($key_format = 'm',$value_format = 'F',$include_select_one = TRUE)
{
  if($include_select_one == FALSE):
    $months = array();
  else :
    $months = array('' => 'Please Select One');
  endif;

  for($i = 1; $i < 13; $i++):
    $month_str = mktime(0,0,0,$i);
    $months[date($key_format,$month_str)] = date($value_format,$month_str);
  endfor;

  return $months;

}


/***
 * @param $start int
 * @param $end int
 * @param bool $include_select_one
 * @return array
 */

function year_list($start,$end,$include_select_one = TRUE)
{
  if($include_select_one == FALSE):
    $list = array();
  else :
    $list = array('' => 'Please Select One');
  endif;

  while($start <= $end):
    $list[$start] = $start;
    $start++;
  endwhile;
  return $list;
}


/***
 * Converts a normal string to what could be a formatted
 * permalink, removes strange characters, and replaces spaces
 * with hyphens, and lower cases the word
 *
 * @param $string string
 * @return mixed string
 */

function str_to_permalink($string)
{
  $string = strtolower($string);
  $string = str_replace(' ','-',$string);
  $string = str_replace('---','-',$string);
  $string = str_replace('--','-',$string);
  $string = str_replace(array(',',"'",'"','!','@','#','$','%','^','&','*','(',')'),'',$string);
  return $string;
}

/***
 * @param $url
 * @param array $data
 * @param bool $result
 * @return bool|mixed
 */

function execute_curl($url, $data = array(), $result = FALSE)
{
  $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US;rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $output = curl_exec($ch);

  if($result) {
    return $output;
  }
  curl_close($ch);

  return TRUE;

}