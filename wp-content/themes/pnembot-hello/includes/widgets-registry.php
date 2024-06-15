<?php

namespace Pnembot\Hello;

use Elementor\Widgets_Manager;
use Elementor\Elements_Manager;

class Widget_Registry {

  private static $instance = null;

  private $widgets = array(
    'terms-carousel'=>'\Pnembot\Hello\Widgets\Terms_Carousel',
    'custom-menu'=>'\Pnembot\Hello\Widgets\Custom_Menu'
  );

  private function __construct() {
			
    $this->init();
  }

  public function init() {
    add_action( 'elementor/elements/categories_registered', array($this, 'register_categories' ) );
    add_action( 'elementor/widgets/register', array($this, 'add_widgets' ) );
  }

  public function add_widgets(Widgets_Manager $widgets_manager) {

    foreach ( $this->widgets as $widget_id => $class_name ) {
        if ( $this->include_widget( $widget_id, true ) ) {
          $widgets_manager->register( new $class_name() );
        }
    }
  }

  public function include_widget( $widget_id, $grouped = false ) {

    $filename = sprintf('includes/widgets/'.$widget_id.'.php');

    if ( ! file_exists( PN_THEME_PATH.'/'.$filename ) ) {
      return false;
    }

    require_once PN_THEME_PATH.'/'.$filename;

    return true;
  }

  private function register_categories(Elements_Manager $manager){
    $manager->add_category(
      'pnembot-hello',
      [
        'title'=>\esc_html__('Pnembot Hello', 'pnembot-hello'),
        'icon'=>'fa fa-plug'
      ]
    );
  }

  public static function get_instance( $shortcodes = array() ) {

    if ( null == self::$instance ) {
      self::$instance = new self( $shortcodes );
    }
    return self::$instance;
  }
}


function load_widgets(){ 
  return Widget_Registry::get_instance();
}
