<?php

namespace Pnembot\Hello\Core\Documents;

use Elementor\Controls_Manager;
use Elementor\Core\Base\Document;
use ElementorPro\Modules\ThemeBuilder\Documents\Theme_Document;

class Loop_Term extends Theme_Document
{
  const DOCUMENT_TYPE = 'loop-term';

	const RECOMMENDED_POSTS_WIDGET_NAMES = [
		'theme-post-title',
		'theme-post-excerpt',
		'theme-post-featured-image',
		'theme-post-content',
		'post-info',
	];

	const WIDGETS_TO_HIDE = [
		'loop-grid',
		'woocommerce-product-data-tabs',
		'loop-carousel',
	];

	public static function get_type() {
		return static::DOCUMENT_TYPE;
	}

	public static function get_title() {
		return esc_html__( 'Loop Term', 'pnembot-hello' );
	}

	public static function get_plural_title() {
		return esc_html__( 'Loop Terms', 'pnembot-hello' );
	}

	protected static function get_site_editor_icon() {
		return 'eicon-loop-builder';
	}

	public static function get_site_editor_tooltip_data() {
		return [
			'title' => esc_html__( 'What is a loop?', 'pnembot-hello' ),
			'content' => esc_html__( 'A Loop is a layout you can customize to display recurring dynamic content - like listings, posts, portfolios, products, categories, colections, , etc.', 'pnembot-hello' ),
			'tip' => esc_html__( 'Start by creating a master item. All the other instances in the grid will match this design. Then go back to the widget in the editor panel and assign both a template and a source of content. Your grid should populate automatically.', 'pnembot-hello' ),
		];
	}

	protected static function get_site_editor_thumbnail_url() {
		return ELEMENTOR_PRO_MODULES_URL . 'loop-builder/assets/images/loop-item.svg';
	}

	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['support_conditions'] = false;

		return $properties;
	}

	public function get_container_attributes() {
		$attributes = Document::get_container_attributes();

		$attributes['class'] .= ' pnh-loop-term';
		$attributes['class'] .= defined(TERM_ID)? ' pnh-loop-term-' . TERM_ID : '';

		$attributes['data-custom-edit-handle'] = true;

		return $attributes;
	}

	/**
	 * @return \WP_Post_Type[]
	 */
	private function all_post_types(){
		global $wp_post_types;
		/**
		 * @var \WP_Post_Type[] $post_types
		 */
		$post_types = [];
		
		foreach($wp_post_types as $post_type){
			if($post_type->public and !empty($this->get_taxonomies($post_type->name))){
				$post_types[] = $post_type;
			}
		}
		return $post_types;
	}

	private function get_taxonomies(string $post_type){
		return get_object_taxonomies( $post_type, 'object' );
	}

	private function get_taxonomies_options(){
		$post_type = $this->get_settings("post-type");
		if(empty($post_type)){
			return [];
		}
		$taxonomies = $this->get_taxonomies($post_type);
		$options = [];
		foreach($taxonomies as $tax){
			$options[$tax->name] = $tax->label;
		}

		return $options;
	}

	protected function inject_width_control() {
		$this->start_injection([
			'type' => 'section',
			'at' => 'start',
			'of' => 'preview_settings',
		]);

		$this->add_responsive_control(
			'preview_width',
			[
				'label' => esc_html__( 'Width', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1140,
					],
					'em' => [
						'min' => 20,
						'max' => 100,
					],
					'rem' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--preview-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_injection();
	}

	protected function add_query_control(){
		$this->start_controls_section(
			'_section_query',
			[
				'label' => esc_html__( 'Query', 'pnembot-hello' ),
				'tab' => Controls_Manager::TAB_SETTINGS,
			]
		);

		$post_types = $this->all_post_types();
		$options = [];
		foreach($post_types as $post_type) {
			$options[$post_type->name] = $post_type->label;
		}

		$this->add_control(
			'post-type',
			[
				'label' => esc_html__( 'Post Type', 'pnembot-hello' ),
				'type' => Controls_Manager::SELECT,
				'options' => $options,
				'default' => array_key_first( $options ),
				'prefix_class' => 'elementor-view-',
			]
		);

		$this->add_control(
			'taxonomy',
			[
				'label' => esc_html__( 'Taxonomy', 'pnembot-hello' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_taxonomies_options(),
				'default' => array_key_first( $this->get_taxonomies_options() ),
				'prefix_class' => 'elementor-view-',
				'condition'=> [
					'post-type!'=>''
				]
			]
		);

		$this->add_control(
			'apply_query_source',
			[
				'type' => Controls_Manager::BUTTON,
				'label' => esc_html__( 'Apply', 'pnembot-hello' ),
				'label_block' => true,
				'show_label' => false,
				'text' => esc_html__( 'Apply', 'pnembot-hello' ),
				'event' => 'elementorLoopBuilder:ApplySourceChange',
			]
		);

		$this->add_control(
			'query_source_description',
			[
				'raw' => esc_html__( 'This affects the types of widgets and templates you can use for your master item.', 'pnembot-hello' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->end_controls_section();
	}


	protected function register_controls() {
		parent::register_controls();

		// $this->remove_control( 'content_wrapper_html_tag' );

		// $this->update_preview_control();

		$this->inject_width_control();

		$this->add_query_control();

		// \Elementor::get_instance()::elementor()->controls_manager->add_custom_css_controls( $this );

	}
}