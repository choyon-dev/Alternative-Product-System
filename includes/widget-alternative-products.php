<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Alternative_Products_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'alternative-products';
    }

    public function get_title() {
        return __( 'Alternative Products', 'text-domain' );
    }

    public function get_icon() {
        return 'eicon-post-list'; // Modern list icon
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'text-domain' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'acf_field',
            [
                'label' => __( 'ACF Field', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'software_alternatives',
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => __( 'Limit', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $product_id = get_the_ID();
        $acf_field = $settings['acf_field'];
        $limit = $settings['limit'];

        if ( $product_id && $acf_field ) {
            $related_products = get_field( $acf_field, $product_id );

            if ( $related_products && is_array( $related_products ) ) {
                echo '<div class="alternative-products">';
                foreach ( array_slice( $related_products, 0, $limit ) as $product ) {
                    $product_image = get_the_post_thumbnail_url( $product->ID, 'thumbnail' );
                    echo '<div class="product-card">';
                    echo '<div class="product-image">';
                    echo '<img src="' . esc_url( $product_image ) . '" alt="' . esc_attr( $product->post_title ) . '">';
                    echo '</div>';
                    echo '<div class="product-info">';
                    echo '<h3>' . esc_html( $product->post_title ) . '</h3>';
                    echo '<p>' . wp_trim_words( $product->post_content, 15, '...' ) . '</p>';
                    echo '<a href="' . get_permalink( $product->ID ) . '" class="product-link">Learn More</a>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p>No alternative products found.</p>';
            }
        }
    }
}
