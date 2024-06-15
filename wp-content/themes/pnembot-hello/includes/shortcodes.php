<?php

namespace Pnembot\Hello;

function custom_menu_shortcode($atts)
{
    $atts = shortcode_atts([
        'menu' => null,
        'class' => 'custom-menu-container',
        'id' => 'custom-menu-container'
    ], $atts, "pn_custom_menu");

    if (is_null($atts['menu'])) {
        echo 'Specify the menu parameter';
        return;
    }

    $echo = wp_nav_menu(array(
        'menu' => $atts['menu'],
        'container' => 'div',
        'container_class' => 'custom-menu ' . $atts['class'],
        'container_id' => $atts['class'],
        'echo' => false,
    ));

    if (is_string($echo)) {
        echo $echo;
    } else if (!$echo) {
        echo 'there is no menu with id "' . $atts['menu'] . '".';
    }
    return;
}
add_shortcode('pn_custom_menu', 'custom_menu_shortcode');

function menu_trigger_button_shortcode($atts)
{
    $atts = shortcode_atts([
        'menu_id' => null,
        'class' => 'menu-trigger-btn',
        'id' => null,
    ], $atts, "pn_custom_menu");
?>
    <a href="#" role="button" class="burger <?= $atts['class'] ?>" aria-label="menu toggler" onclick="document.body.classList.toggle('menu-open');">
        <div class="burger-box">
            <div class="burger-inner"></div>
        </div>
    </a>
<?php
}
add_shortcode('menu_trigger_button', 'menu_trigger_button_shortcode');
