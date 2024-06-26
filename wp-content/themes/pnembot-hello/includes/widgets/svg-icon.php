<?php

namespace Pnembot\Hello\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Utils;
use Elementor\Widget_Base;
use enshrined\svgSanitize\Sanitizer;

class Svg_Icon extends Widget_Base
{

    public function get_name()
    {
        return 'pnh-svg-icon';
    }

    public function get_title()
    {
        return esc_html__('Svg Icon', 'pnembot-hello');
    }

    public function get_icon()
    {
        return 'eicon-favorite';
    }

    public function get_categories()
    {
        return ['theme-elements', 'pnembot-hello'];
    }

    public function get_keywords()
    {
        return [
            'svg',
            'icon',
        ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'pnembot-hello'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'pnembot-hello'),
                "type" => Controls_Manager::MEDIA,
                "media_types" => ['svg'],
                "dynamic" => [
                    "active" => true,
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('View', 'pnembot-hello'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('Default', 'pnembot-hello'),
                    'stacked' => esc_html__('Stacked', 'pnembot-hello'),
                    'framed' => esc_html__('Framed', 'pnembot-hello'),
                ],
                'default' => 'default',
                'prefix_class' => 'elementor-view-',
            ]
        );

        $this->add_control(
            'shape',
            [
                'label' => esc_html__('Shape', 'pnembot-hello'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'circle' => esc_html__('Circle', 'pnembot-hello'),
                    'square' => esc_html__('Square', 'pnembot-hello'),
                ],
                'default' => 'circle',
                'condition' => [
                    'view!' => 'default',
                ],
                'prefix_class' => 'elementor-shape-',
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'pnembot-hello'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'pnembot-hello'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'pnembot-hello'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'pnembot-hello'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'pnembot-hello'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'pnembot-hello'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('icon_colors');

        $this->start_controls_tab(
            'icon_colors_normal',
            [
                'label' => esc_html__('Normal', 'pnembot-hello'),
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Primary Color', 'pnembot-hello'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' => esc_html__('Secondary Color', 'pnembot-hello'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_colors_hover',
            [
                'label' => esc_html__('Hover', 'pnembot-hello'),
            ]
        );

        $this->add_control(
            'hover_primary_color',
            [
                'label' => esc_html__('Primary Color', 'pnembot-hello'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_secondary_color',
            [
                'label' => esc_html__('Secondary Color', 'pnembot-hello'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'size',
            [
                'label' => esc_html__('Size', 'pnembot-hello'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-icon svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'fit_to_size',
            [
                'label' => esc_html__('Fit to Size', 'pnembot-hello'),
                'type' => Controls_Manager::SWITCHER,
                'description' => 'Avoid gaps around icons when width and height aren\'t equal',
                'label_off' => esc_html__('Off', 'pnembot-hello'),
                'label_on' => esc_html__('On', 'pnembot-hello'),
                'condition' => [
                    'selected_icon[library]' => 'svg',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-wrapper svg' => 'width: 100%;',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'pnembot-hello'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $this->add_responsive_control(
            'rotate',
            [
                'label' => esc_html__('Rotate', 'pnembot-hello'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['deg', 'grad', 'rad', 'turn', 'custom'],
                'default' => [
                    'unit' => 'deg',
                ],
                'tablet_default' => [
                    'unit' => 'deg',
                ],
                'mobile_default' => [
                    'unit' => 'deg',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__('Border Width', 'pnembot-hello'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'view' => 'framed',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pnembot-hello'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if ($settings['icon']['url'] == false) {
            return;
        }

        $sanitizer = new Sanitizer();
        $sanitizer->minify(true);

        $content = file_get_contents($settings['icon']['url']);
        $icon = $sanitizer->sanitize($content);

        if ($icon == false) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'elementor-icon-wrapper');

        $this->add_render_attribute('icon-wrapper', 'class', 'elementor-icon');

        $icon_tag = 'div';

        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('icon-wrapper', $settings['link']);
            $icon_tag = 'a';
        }
        ?>
        <div <?php $this->print_render_attribute_string('wrapper');?>>
			<<?php Utils::print_unescaped_internal_string($icon_tag . ' ' . $this->get_render_attribute_string('icon-wrapper'));?>>
				<?=$icon?>
			</<?php Utils::print_unescaped_internal_string($icon_tag);?>>
		</div>
        <?php
    }
}
