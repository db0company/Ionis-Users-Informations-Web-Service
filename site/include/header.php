<?php

include_once('include/menu.php');

function	get_title() {
  return 'Ionis Users Informations';  
}

function	get_description() {
  return 'Get informations about Ionis people';
}

function	display_header($current_page = 0) {
  $title = get_title();
  $short_description = get_description();
  $description = 'Ionis-Users-Informations is a service made by students for'
    .' students to get informations about all the people at Ionis Institute of Technology';
  $author = 'Made by db0 :: http://db0.fr/ :: db0company@gmail.com';
  $menu = get_menu();
  echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>', $title, ' :: ', $short_description, '</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="', $description, '">
    <meta name="author" content="', $author, '">
    <link rel="shortcut icon" type="image/x-icon" href="fav.ico" /> 
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
  </head>

  <body>

    <div class="navbar navbar-fixed-top navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="',
    (($_SERVER["SERVER_NAME"] == 'peuple.paysdu42.fr') ? 'http://iui.paysdu42.fr/' : '.'),
    '">', $title, '</a>
          <div class="nav-collapse">
            <ul class="nav">';
  foreach ($menu as $elem) {
    echo '<li', ($current_page == menu_url($elem) ? ' class="active"' : ''),
      '><a href="', (menu_internal($elem) ? '?' : ''), menu_url($elem), '"',
      (menu_popout($elem) ? ' target="blank"' : ''),
      '>', menu_name($elem), '</a></li>';
  }
  echo '            </ul>
          </div>
        </div>
      </div>
    </div>';
  }
