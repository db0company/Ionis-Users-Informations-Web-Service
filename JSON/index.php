<?php

$format = 'ini';
include_once('../ws.php');

echo '{',
  "\n",
  '  "action"="',
  $result['action'],
  '",',
  "\n",
  '  "error"="',
  $result['error'],
  '",',
  "\n",
  '  "result"=',
  "\n",
  '  {',
  "\n";

$flag = false;
foreach($result['result'] as $key => $value)
{
  if ($flag)
    echo ',', "\n";
  echo '    "', $key, '":"', $value, '"';
  $flag = true;
}

echo  "\n",
  '  }',
  "\n",
  '}',
  "\n";
