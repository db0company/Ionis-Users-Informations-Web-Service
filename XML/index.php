<?php

$format = 'ini';
include_once('../ws.php');

echo '<action>',
  $result['action'],
  '</action>',
  "\n",
  '<error>',
  $result['error'],
  '</error>',
  "\n",
  '<result>',
  "\n";

foreach($result['result'] as $key => $value)
{
  echo '  <', $key, '>', $value, '</', $key, '>', "\n";
}

echo  '</result>', "\n";
