<?php

namespace Pnembot\Hello\Core;

use Elementor\Core\Documents_Manager;
use Elementor\Plugin as ElementorPlugin;

class Document_Registry
{
    private static $instance = null;
    private $documents = [
        'loop-term' => '\Pnembot\Hello\Core\Documents\Loop_Term',
    ];
    private $elementor;

    private function __construct()
    {
      $this->elementor = ElementorPlugin::instance();
      $this->init();
    }

    public function init()
    {
        if (!did_action('elementor/documents/register')) {
            add_action('elementor/documents/register', [$this, 'register_documents']);
        } else {
          $this->register_documents($this->elementor->documents);
        }
    }

    public function register_documents(Documents_Manager $documents_manager)
    {
        foreach ($this->documents as $document_id => $class_name) {
            if ($this->include_document($document_id, true)) {
              $documents_manager->register_document_type($document_id, $class_name);
            }
        }
    }

    public function include_document($document_id, $grouped = false)
    {

        $filename = sprintf('includes/core/documents/' . $document_id . '.php');

        if (!file_exists(PN_THEME_PATH . '/' . $filename)) {
            return false;
        }

        require_once PN_THEME_PATH . '/' . $filename;

        return true;
    }

    public static function get_instance()
    {
      if (null == self::$instance) {
        self::$instance = new self();
      }
      return self::$instance;
    }
}

function load_documents(){ 
  return Document_Registry::get_instance();
}