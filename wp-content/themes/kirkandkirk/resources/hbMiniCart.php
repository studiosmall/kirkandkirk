<?php

/**
 * Adds Hb_Mini_Cart widget.
 */
class Hb_Mini_Cart extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'hb_mini_cart_widget', // Base ID
            esc_html__('Mini Cart', 'text_domain'), // Name
            array( 'description' => esc_html__('Professional User Mini Cart', 'text_domain'), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        $user_id = get_current_user_id();
        $optician_cart_data = get_user_meta($user_id, 'optician_cart_data', true);
        $optician_cart_data_array = unserialize($optician_cart_data);

        // print_r( $optician_cart_data);

        $quantity = 0;

        foreach ($optician_cart_data_array as $value) {
            $quantity += $value['quantity'];
        }
        $items = count($optician_cart_data_array);
        ?>
         <a class="your-class-name" href="<?php echo wc_get_cart_url(); ?>"
            title="<?php _e('Cart View', 'text_domain'); ?>">
            <span class="ico-basket"></span>

            <span>(<?php echo $quantity; ?>)</span>
        </a>

        <?php
        echo $args['after_widget'];
    }
} // class Hb_Mini_Cart


/**
 * Register our Common widget.
 *
 */
function hb_common_menu_widgets_init()
{

    register_sidebar(array(
        'name'          => 'Common Menu Widget',
        'id'            => 'hb_common_right_widget',
        'before_widget' => '<div class="hb_common_right_widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
        'description' => __('Shown at right side of menus', 'text_domain'),
    ));
}
add_action('widgets_init', 'hb_common_menu_widgets_init');