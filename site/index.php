<?php

include_once('include/header.php');
include_once('include/page.php');

function	main() {
  session_start();
  $page = get_page();
  if ($page == 'rss') {
    include_once('include/rss.php');
    display_rss();
    return ;
  }
  display_header($page);
  display_page($page);
}

main();

