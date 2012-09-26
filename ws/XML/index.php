<?php

$format = 'ini';
include_once('../ws.php');

function	spaces($nb) {
  for ($i = 0; $i < $nb; $i++)
    echo '  ';
}

function	display_xml_result($name, $tree, $depth) {
  spaces($depth);
  if (is_array($tree) && empty($tree))
    echo '<'.$name.' />'."\n";
  else {
    echo '<'.$name.'>';
    if (is_array($tree)) {
      echo "\n";
      foreach ($tree as $key => $value)
	display_xml_result($key, $value, $depth + 1);
      spaces($depth);
    }
    else
      echo $tree;
    echo '</'.$name.'>'."\n";
  }
}

echo '<?xml version="1.0"?>'."\n";
display_xml_result('ws', array_reverse($result), 0);
