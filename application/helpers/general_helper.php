<?php

function pr($data,$dump = FALSE)
{
  if($dump = FALSE):
    var_dump($data);
  else :
    echo '<pre>';
    print_r($data);
    echo '</pre>';
  endif;
}

function _e(&$content,$default = NULL, $before = NULL, $after = NULL)
{
  if(isset($content) && strlen($content) > 1)
    return $before . $content . $after;
  elseif(strlen($default) < 1)
    return NULL;
  else
    return $before . $default . $after;
}

function _m(&$content,$dec = 2)
{
  if(isset($content) && strlen($content) > 1)
    return number_format($content,$dec);
  else
    return number_format(0,$dec);
}

function array_to_object($data)
{
  return json_decode (json_encode ($data), FALSE);
}

function sort_array ($array, $key, $type = 'arr') {
  $sorter = array();
  $ret = array();
  reset($array);
  foreach ($array as $ii => $va) {
    if($type == 'obj')
      $sorter[$ii] = $va->$key;
    else
      $sorter[$ii] = $va[$key];
  }
  asort($sorter);
  foreach ($sorter as $ii => $va) {
    $ret[$ii] = $array[$ii];
  }
  if($type == 'obj')
    return $ret;
  return $ret;

}