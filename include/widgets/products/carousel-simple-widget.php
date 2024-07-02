<?php

namespace Elementor;

class Simple_Products_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'Simple Products Carousel';
    }

    public function get_title() {
        return 'Simple Products Carousel';
    }

    public function get_icon() {
        return 'fa fa-font';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Content', 'elementor' ),
            ]
        );

//        $this->add_control(
//            'category',
//            [
//                'label' => __( 'Products category', 'elementor' ),
//                'type' => \Elementor\Controls_Manager::SELECT,
//                'default' => 'all',
//                'options' => [
//                    'all'  => __( 'All', 'elementor' ),
//                    'new' => __( 'New', 'elementor' ),
//                    'popular'  => __( 'Popular', 'elementor' ),
//                    'trending' => __( 'Trending', 'elementor' ),
//                    'toprated'  => __( 'Top Rated', 'elementor' )
//                ],
//            ]
//        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Products title', 'elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter products title', 'elementor' ),
            ]
        );

//        $this->add_control(
//            'link_text',
//            [
//                'label' => __( 'All link text', 'elementor' ),
//                'label_block' => true,
//                'type' => Controls_Manager::TEXT,
//                'placeholder' => __( 'Enter link text', 'elementor' ),
//            ]
//        );

//        $this->add_control(
//            'link_url',
//            [
//                'label' => __( 'All Link url', 'elementor' ),
//                'type' => Controls_Manager::URL,
//                'placeholder' => __( 'https://your-link.com', 'elementor' ),
//                'default' => [
//                    'url' => '',
//                ]
//            ]
//        );

        $this->add_control(
            'count',
            [
                'label' => __( 'Count of products', 'elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'placeholder' => __( 'Enter count', 'elementor' ),
            ]
        );

        $this->add_control(
            'sorting',
            [
                'label' => __( 'Sorting', 'elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => __( 'Ascendente', 'elementor' ),
                    'desc' => __( 'Descending', 'elementor' ),
                ],
            ]
        );

        $this->add_control(
            'cats_include',
            [
                'label' => __( 'Choose categories', 'hestia' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => get_product_terms_for_widgets('product_cat'),
                'multiple' => true,
            ]
        );

        $this->add_control(
            'tags_include',
            [
                'label' => __( 'Choose tags', 'hestia' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => get_product_terms_for_widgets('product_tag'),
                'multiple' => true,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $settings['view'] = 'carousel';
        $settings['only_simple_product'] = true;
        require 'include/products-list.php';
    }

    protected function _content_template() {

    }


}
