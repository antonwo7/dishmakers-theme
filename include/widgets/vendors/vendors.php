<?php

class Vendors_Elementor_Widgets {

    protected static $instance = null;

    public static function get_instance() {
        if ( ! isset( static::$instance ) ) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    protected function __construct() {
        require_once('carousel-widget.php');
        require_once('list-widget.php');
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
    }

    public function register_widgets() {
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Vendors_List_Widget() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Vendors_Carousel_Widget() );
    }

}

add_action( 'init', 'my_vendors_elementor_init' );
function my_vendors_elementor_init() {
    Vendors_Elementor_Widgets::get_instance();
}
