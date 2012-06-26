<?php

$format = 'ini';
include_once('../ws.php');

echo '<?xml version="1.0"?><ws><action>',
  $result['action'],
  '</action>',
  '<error>',
  $result['error'],
  '</error>',
  '<result>';

foreach($result['result'] as $key => $value)
{
  echo '<', $key, '>', $value, '</', $key, '>';
}

echo  '</result></ws>', "\n";
