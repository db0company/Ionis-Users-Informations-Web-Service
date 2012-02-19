<?php

$format = 'ini';
include_once('../ws.php');

echo '[action]',
  "\n",
  'action=',
  $result['action'],
  "\n",
  "\n",
  '[error]',
  "\n",
  'error=',
  $result['error'],
  "\n",
  "\n",
  '[result]',
  "\n";

foreach($result['result'] as $key => $value)
{
  echo $key,'=',$value,"\n";
}

