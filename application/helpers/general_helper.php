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

function _e(&$content,$default = NULL, $extra = NULL)
{
  if(isset($content))
    return $content . $extra;
  else
    return $default . $extra;
}