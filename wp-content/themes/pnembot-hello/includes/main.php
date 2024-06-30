<?php

namespace Pnembot\Hello;
use function Pnembot\Hello\Core\load_documents;


function alert($v){
  echo "<script> alert('{$v}')</script>";
}

require_once __DIR__ . '/shortcodes.php';
require_once __DIR__ . '/widgets-registry.php';
// require_once __DIR__ . '/core/document_registry.php';

add_action('wp_enqueue_scripts', function () {
  $script_file = get_stylesheet_directory_uri() . '/dist/script.js';
  $style_file = get_stylesheet_directory_uri() . '/dist/style.css';
  wp_enqueue_style('parent-style', get_template_directory() . '/style.css');
  wp_enqueue_style('child_style', get_stylesheet_directory_uri() . '/style.css', ['parent-style']);
  wp_enqueue_style('styles', $style_file, [], filemtime($style_file));

  wp_enqueue_script('main-script', $script_file, array('jquery'), filemtime($script_file), array('strategy' => 'defer'));
});

load_widgets();

// load_documents();