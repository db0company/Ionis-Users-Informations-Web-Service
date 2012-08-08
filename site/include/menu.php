<?php

function	menu_name($element) {
  return $element[0];
}

function	menu_url($element) {
  return $element[1];
}

function	menu_internal($element) {
  return $element[2];
}

function	menu_popout($element) {
  return $element[3];
}

function	get_menu() {
  return array(
	       'peuple' => array('« Peuple »', 'peuple', false, false),
	       'ws' => array('Web Service', 'ws', true, false),
	       'php' => array('PHP Class', 'https://github.com/db0company/Ionis-Users-Informations', false, true),
	       'who' => array('Who\'s using it?', 'who', true, false),
	       'contact' => array('Contact', 'contact', true, false),
	       );
  }

function	get_menu_elem($key) {
  $menu = get_menu();
  return $menu[$key];
}

function	menu_link($elem) {
  return '<a href="'
    .(menu_internal($elem) ? '?' : '')
    .menu_url($elem). '"'
    .(menu_popout($elem) ? ' target="blank"' : '')
    .'>';
}
