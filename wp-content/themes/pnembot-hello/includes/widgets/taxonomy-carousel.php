<?php

namespace Pnembot\Hello\Widgets;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;

class Taxonomy_Carousel extends Widget_Base
{
    public function get_name()
    {
        return 'pnh-taxonomy-carousel';
    }

    public function get_title()
    {
        return esc_html__('Taxonomy Carousel', 'pnembot-hello');
    }

    public function get_icon()
    {
        return 'eicon-nested-carousel';
    }

    public function get_categories()
    {
        return ['theme-elements', 'pnembot-hello'];
    }

    public function get_keywords()
    {
        return [
            'taxonomy',
            'category',
            'carousel',
            'list',
            'blog',
        ];
    }
    public function get_script_depends()
    {
        return ['taxonomy-carousel-ajax'];
    }

    /**
     * @return \WP_Post_Type[]
     */
    private function all_post_types()
    {
        global $wp_post_types;
        /**
         * @var \WP_Post_Type[] $post_types
         */
        $post_types = [];

        foreach ($wp_post_types as $post_type) {
            if ($post_type->public and !empty($this->get_taxonomies($post_type->name))) {
                $post_types[] = $post_type;
            }
        }
        return $post_types;
    }

    private function get_taxonomies(string $post_type)
    {
        return get_object_taxonomies($post_type, 'object');
    }

    private function get_taxonomies_options()
    {
        $post_type = $this->get_settings("post-type");
        if (empty($post_type)) {
            return [];
        }
        $taxonomies = $this->get_taxonomies($post_type);
        $options = [];
        foreach ($taxonomies as $tax) {
            $options[$tax->name] = $tax->label;
        }

        return $options;
    }

    protected function add_query_controls()
    {
        $this->start_controls_section(
            'section_filter',
            [
                'label' => esc_html__('Query', 'pnembot-hello'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $post_types = $this->all_post_types();
        $options = [];
        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->label;
        }

        $this->add_control(
            'post-type',
            [
                'label' => esc_html__('Post Type', 'pnembot-hello'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => '',
                'label_block' => true,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'taxonomy',
            [
                'label' => esc_html__('Taxonomy', 'pnembot-hello'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Select a taxonomy', 'pnembot-hello'),
                ],
                'label_block' => true,
                'condition' => [
                    'post-type!' => '',
                ],
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();
    }

    protected function register_controls()
    {
        $this->add_query_controls();
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'pnembot-hello'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => esc_html__('Categories Count', 'pnembot-hello'),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
            ]
        );

        $this->end_controls_section();
    }

    protected function get_empty_widget_message_by_key($message_key)
    {
        $messages = [
            'selected_post_type' => esc_html__('Choose a Post Type to view the Taxonomy Carousel.', 'pnembot-hello'),
            'no_taxonomy_selected' => esc_html__('Please select a taxonomy.', 'pnembot-hello'),
            'no_terms_found' => esc_html__('No taxonomy terms found.', 'pnembot-hello'),
        ];

        return $messages[$message_key];
    }

    protected function print_empty_results_if_editor($message_key)
    {
        if (!Plugin::instance()->editor->is_edit_mode()) {
            return;
        }

        ?>
      <div class="e-filter-empty">
        <?php echo esc_html($this->get_empty_widget_message_by_key($message_key)); ?>
      </div>
      <?php
}

    private function has_empty_results($selected_post_type, $user_selected_taxonomy, $terms): bool
    {
        if (empty($selected_post_type)) {
            $this->print_empty_results_if_editor('selected_post_type');

            return true;
        }

        if (empty($user_selected_taxonomy)) {
            $this->print_empty_results_if_editor('no_taxonomy_selected');

            return true;
        }

        if (empty($terms)) {
            $this->print_empty_results_if_editor('no_terms_found');

            return true;
        }

        return false;
    }

    // protected function add_carousel_settings_controls(){
    //   $this->start_controls_section(
    //     'section_carousel_settings',
    //     [
    //       'label' => esc_html__( 'Settings', 'pnembot-hello' ),
    //     ]
    //   );

    //   $this->add_control(
    //     'autoplay',
    //     [
    //       'label' => esc_html__( 'Autoplay', 'pnembot-hello' ),
    //       'type' => Controls_Manager::SWITCHER,
    //       'default' => 'yes',
    //       'options' => [
    //         'yes' => esc_html__( 'On', 'pnembot-hello' ),
    //         'no' => esc_html__( 'Off', 'pnembot-hello' ),
    //       ],
    //       'frontend_available' => true,
    //     ]
    //   );

    //   $this->add_control(
    //     'autoplay_speed',
    //     [
    //       'label' => esc_html__( 'Scroll Speed', 'pnembot-hello' ) . ' (ms)',
    //       'type' => Controls_Manager::NUMBER,
    //       'default' => 5000,
    //       'condition' => [
    //         'autoplay' => 'yes',
    //       ],
    //       'render_type' => 'none',
    //       'frontend_available' => true,
    //     ]
    //   );

    //   $this->add_control(
    //     'pause_on_hover',
    //     [
    //       'label' => esc_html__( 'Pause on hover', 'pnembot-hello' ),
    //       'type' => Controls_Manager::SWITCHER,
    //       'default' => 'yes',
    //       'options' => [
    //         'yes' => esc_html__( 'On', 'pnembot-hello' ),
    //         'no' => esc_html__( 'Off', 'pnembot-hello' ),
    //       ],
    //       'condition' => [
    //         'autoplay' => 'yes',
    //       ],
    //       'render_type' => 'none',
    //       'frontend_available' => true,
    //     ]
    //   );

    //   $this->add_control(
    //     'pause_on_interaction',
    //     [
    //       'label' => esc_html__( 'Pause on interaction', 'pnembot-hello' ),
    //       'type' => Controls_Manager::SWITCHER,
    //       'default' => 'yes',
    //       'options' => [
    //         'yes' => esc_html__( 'On', 'pnembot-hello' ),
    //         'no' => esc_html__( 'Off', 'pnembot-hello' ),
    //       ],
    //       'condition' => [
    //         'autoplay' => 'yes',
    //       ],
    //       'frontend_available' => true,
    //     ]
    //   );

    //   $this->add_control(
    //     'infinite',
    //     [
    //       'label' => esc_html__( 'Infinite scroll', 'pnembot-hello' ),
    //       'type' => Controls_Manager::SWITCHER,
    //       'default' => 'yes',
    //       'options' => [
    //         'yes' => esc_html__( 'On', 'pnembot-hello' ),
    //         'no' => esc_html__( 'Off', 'pnembot-hello' ),
    //       ],
    //       'frontend_available' => true,
    //     ]
    //   );

    //   $this->add_control(
    //     'speed',
    //     [
    //       'label' => esc_html__( 'Transition Duration', 'pnembot-hello' ) . ' (ms)',
    //       'type' => Controls_Manager::NUMBER,
    //       'default' => 500,
    //       'render_type' => 'none',
    //       'frontend_available' => true,
    //     ]
    //   );

    //   $this->add_control(
    //     'direction',
    //     [
    //       'label' => esc_html__( 'Direction', 'pnembot-hello' ),
    //       'type' => Controls_Manager::SELECT,
    //       'default' => is_rtl() ? 'rtl' : 'ltr',
    //       'options' => [
    //         'ltr' => esc_html__( 'Left', 'pnembot-hello' ),
    //         'rtl' => esc_html__( 'Right', 'pnembot-hello' ),
    //       ],
    //     ]
    //   );

    //   $this->end_controls_section();
    // }

    // public function add_navigation__controls(){

    // }

}

add_action("wp_footer", function () {
    wp_register_script('taxonomy-carousel-ajax', get_template_directory_uri() . '/includes/widgets/assets/taxonomy-carousel.js', ['jquery', 'json2']);

    wp_localize_script('taxonomy-carousel-ajax', 'taxonomy_carousel_ajax', [
        'ajax-url' => admin_url('admin-ajax.php'),
        'postTypeNonce' => wp_create_nonce('taxonomy-carousel-post-type-nonce'),
    ]);
});