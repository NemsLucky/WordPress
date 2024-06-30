<?php

namespace Pnembot\Hello\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Svg_Icon extends Widget_Base
{

    public function get_name()
    {
        return 'pnh-svg-icon';
    }

    public function get_title()
    {
        return esc_html__('Acf Icon', 'pnembot-hello');
    }

    public function get_icon()
    {
        return 'eicon-star-o';
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
            'icon_url',
            [
                'label' => esc_html__('Icon Url', 'pnembot-hello'),
                "type" => Controls_Manager::URL,
                "dynamic" => [
                    "active" => true,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'pnembot-hello'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->end_controls_section();
    }
}
