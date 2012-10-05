<?php

$format = 'json';
include_once('../ws.php');

echo json_encode(array_reverse($result));
