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