<?php

namespace Elementor;

class Vendors_List_Widget extends Widget_Base {

    public function get_name() {
        return 'Vendors List';
    }

    public function get_title() {
        return 'Vendors List';
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
            'search_button_label',
            [
                'label' => __( 'Search button label', 'elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter search button label', 'elementor' ),
            ]
        );

        $this->add_control(
            'search_input_placeholder',
            [
                'label' => __( 'Search input placeholder', 'elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter search input placeholder', 'elementor' ),
            ]
        );

        $this->add_control(
            'search_all_label',
            [
                'label' => __( 'Search all label', 'elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter search all label', 'elementor' ),
            ]
        );

        $this->add_control(
            'show_more_label',
            [
                'label' => __( 'Show more label', 'elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter show more label', 'elementor' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $settings['view'] = 'list';
        require 'include/vendors-list.php';
    }

    protected function _content_template() {

    }


}

