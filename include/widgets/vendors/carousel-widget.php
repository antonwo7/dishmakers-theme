<?php

namespace Elementor;

class Vendors_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'Vendors Carousel';
    }

    public function get_title() {
        return 'Vendors Carousel';
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
//            'view',
//            [
//                'label' => __( 'View', 'elementor' ),
//                'type' => \Elementor\Controls_Manager::SELECT,
//                'default' => 'carousel',
//                'options' => [
//                    'carousel'  => __( 'Carousel', 'elementor' ),
//                    'list' => __( 'List', 'elementor' ),
//                ],
//            ]
//        );

        $this->add_control(
            'category',
            [
                'label' => __( 'Vendors category', 'elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'all',
                'options' => [
                    'all'  => __( 'All', 'elementor' ),
                    'new' => __( 'New', 'elementor' ),
                    'popular'  => __( 'Popular', 'elementor' ),
                    'trending' => __( 'Trending', 'elementor' ),
                    'toprated'  => __( 'Top Rated', 'elementor' )
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Vendors title', 'elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter vendors title', 'elementor' ),
            ]
        );

        $this->add_control(
            'link_text',
            [
                'label' => __( 'All link text', 'elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter link text', 'elementor' ),
            ]
        );

        $this->add_control(
            'link_url',
            [
                'label' => __( 'All Link url', 'elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'elementor' ),
                'default' => [
                    'url' => '',
                ]
            ]
        );

        $this->add_control(
            'count',
            [
                'label' => __( 'Count of vendors', 'elementor' ),
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

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $settings['view'] = 'carousel';
        require 'include/vendors-list.php';
    }

    protected function _content_template() {

    }


}
