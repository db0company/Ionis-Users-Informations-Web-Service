<?php

include_once('include/menu.php');
include_once('include/footer.php');

function	get_page() {
  $page = '';
  if (isset($_GET['rss']))
    return 'rss';
  if ($_SERVER["SERVER_NAME"] == 'peuple.paysdu42.fr')
    $page = 'peuple';
  $menu = get_menu();
  foreach ($menu as $elem)
    if (isset($_GET[menu_url($elem)]))
      $page = menu_url($elem);
  return $page;
}

function	display_page_($content, $title = '', $description = '', $no_header = false) {
  echo '    <div class="container-fluid">

';
  if (!$no_header)
    echo '        <div class="page-header">
          <h1>', $title, ' <small>- ', $description, '</small></h1>
        </div>';
  echo '      <div class="content">', $content;
  display_footer();
  echo '</div>';
}

function	display_page($page = 0) {
  if (empty($page))
    $page = 'home';
  $page = 'page/'.$page.'.php';
  if (!file_exists($page)) {
    $title = '404';
    $description = 'Not found';
    $content = 'Woops! This page does not exists.';
  }
  else
    include_once($page);
  display_page_($content, $title, $description, $no_header);
  echo '</div>';
  }
