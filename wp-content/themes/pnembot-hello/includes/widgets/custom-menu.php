<?php

namespace Pnembot\Hello\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Custom_Menu extends Widget_Base
{
    public function get_name()
    {
        return 'pnh-custom-menu';
    }

    public function get_title()
    {
        return __('Custom Menu', 'pnembot-hello');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function get_categories()
    {
        return ['theme-elements', 'pnembot-hello'];
    }

    public function get_keywords()
    {
        return [
            'menu',
            'header',
            'navigation',
            'nav menu',
        ];
    }

    private function get_available_menus()
    {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }

        return $options;
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'pnembot-hello'),
            ]
        );

        $menus = $this->get_available_menus();

        if (!empty($menus)) {
            $this->add_control(
                'menu',
                [
                    'label' => esc_html__('Menu', 'pnembot-hello'),
                    'type' => Controls_Manager::SELECT,
                    'options' => $menus,
                    'default' => array_keys($menus)[0],
                    'save_default' => true,
                    'separator' => 'after',
                    'description' => sprintf(
                        /* translators: 1: Link opening tag, 2: Link closing tag. */
                        esc_html__('Go to the %1$sMenus screen%2$s to manage your menus.', 'pnembot-hello'),
                        sprintf('<a href="%s" target="_blank">', admin_url('nav-menus.php')),
                        '</a>'
                    ),
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type' => Controls_Manager::ALERT,
                    'alert_type' => 'info',
                    'heading' => esc_html__('There are no menus in your site.', 'pnembot-hello'),
                    'content' => sprintf(
                        /* translators: 1: Link opening tag, 2: Link closing tag. */
                        esc_html__('Go to the %1$sMenus screen%2$s to create one.', 'pnembot-hello'),
                        sprintf('<a href="%s" target="_blank">', admin_url('nav-menus.php?action=edit&menu=0')),
                        '</a>'
                    ),
                    'separator' => 'after',
                ]
            );
        }

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_main-menu',
            [
                'label' => esc_html__('Main Menu', 'pnembot-hello'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .pnh-custom-menu .menu-item',
            ]
        );

        $this->start_controls_tabs('tabs_menu_item_style');

        $this->start_controls_tab(
            'tab_menu_item_normal',
            [
                'label' => esc_html__('Normal', 'pnembot-hello'),
            ]
        );

        $this->add_control(
            'color_menu_item',
            [
                'label' => esc_html__('Text Color', 'pnembot-hello'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pnh-custom-menu--main .menu-item' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_item_hover',
            [
                'label' => esc_html__('Hover', 'pnembot-hello'),
            ]
        );

        $this->add_control(
            'color_menu_item_hover',
            [
                'label' => esc_html__('Text Color', 'pnembot-hello'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pnh-custom-menu--main .menu-item:not(.active):hover,
										{{WRAPPER}} .pnh-custom-menu--main .menu-item:not(.active):focus' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_item_active',
            [
                'label' => esc_html__('Active', 'pnembot-hello'),
            ]
        );

        $this->add_control(
            'color_menu_item_active',
            [
                'label' => esc_html__('Text Color', 'pnembot-hello'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pnh-custom-menu--main .menu-item.active' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_responsive_control(
            'padding_horizontal_menu_item',
            [
                'label' => esc_html__('Horizontal Padding', 'pnembot-hello'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 5,
                    ],
                    'rem' => [
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pnh-custom-menu--main .menu-item a' => 'padding-inline: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_vertical_menu_item',
            [
                'label' => esc_html__('Vertical Padding', 'pnembot-hello'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 5,
                    ],
                    'rem' => [
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pnh-custom-menu--main .menu-item a' => 'padding-block: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_space_between',
            [
                'label' => esc_html__('Space Between', 'pnembot-hello'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                    'em' => [
                        'max' => 10,
                    ],
                    'rem' => [
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--pnh-menu-gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pnh-custom-menu--main .pnh-custom-menu ' => 'gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

				$this->end_controls_section();

        $this->start_controls_section(
            'section_style_indicator',
            [
                'label' => esc_html__('Indicator', 'pnembot-hello'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

				$this->add_responsive_control(
					'menu_item_active_indicator_height',
					[
							'label' => esc_html__('Height', 'pnembot-hello'),
							'type' => Controls_Manager::SLIDER,
							'size_units' => ['px', 'em', 'rem', 'custom'],
							'range' => [
									'px' => [
											'min'=>2,
											'max' => 16,
									],
									'em' => [
											'min'=>0.125,
											'max' => 1,
									],
									'rem' => [
											'min'=>0.125,
											'max' => 1,
									],
							],
							'default'=>"3px",
							'selectors' => [
									'{{WRAPPER}}' => '--pnh-menu-active-indicator-height: {{SIZE}}{{UNIT}}; --pnh-menu-active-indicator-radius: calc( {{SIZE}}{{UNIT}} / 2);',
							],
					]
			);

			$this->add_responsive_control(
					'menu_item_active_indicator_width',
					[
							'label' => esc_html__('width', 'pnembot-hello'),
							'type' => Controls_Manager::SLIDER,
							'size_units' => ['px', 'em', 'rem', 'custom'],
							'range' => [
									'px' => [
											'max' => 100,
									],
									'em' => [
											'max' => 10,
									],
									'rem' => [
											'max' => 10,
									],
							],
							'default'=>'24px',
							'selectors' => [
									'{{WRAPPER}}' => '--pnh-menu-active-indicator-width: {{SIZE}}{{UNIT}};',
							],
					]
			);

        $this->end_controls_section();
    }

    protected function render()
    {
        $available_menus = $this->get_available_menus();

        if (!$available_menus) {
            return;
        }

        $settings = $this->get_active_settings();

        $args = [
            'echo' => false,
            'menu' => $settings['menu'],
            'menu_class' => 'pnh-custom-menu',
            'menu_id' => 'menu-' . $this->get_id(),
            'fallback_cb' => '__return_empty_string',
            'container' => '',
        ];

        // Add custom filter to handle Nav Menu HTML output.
        add_filter('nav_menu_item_id', '__return_empty_string');

        // General Menu.
        $menu_html = wp_nav_menu($args);

        // Remove all our custom filters.
        remove_filter('nav_menu_item_id', '__return_empty_string');

        if (empty($menu_html)) {
            return;
        }

        $this->add_render_attribute('main-menu', 'class', [
            'pnh-custom-menu--main',
            'pnh-custom-menu__container',
        ]);
        ?>
					<nav <?php $this->print_render_attribute_string('main-menu');?>>
						<?php
							// PHPCS - escaped by WordPress with "wp_nav_menu"
							echo $menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</nav>
				<?php
		}

		public function render_plain_content() {}

}
