<?php
/**
 * Widget API: WP_Widget_Archives class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement the Archives widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class Bootswatches_Widget_Archives extends WP_Widget {

	/**
	 * Sets up a new Archives widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_archive',
			'description' => __( 'A monthly archive of your site&#8217;s Posts.', 'bootswatches' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct('archives', __('Archives', 'bootswatches'), $widget_ops);
	}


    public function dropdown($c)
    {
        $dropdown_id = "{$this->id_base}-dropdown-{$this->number}";

            /**
             * Filters the arguments for the Archives widget drop-down.
             *
             * @since 2.8.0
             *
             * @see wp_get_archives()
             *
             * @param array $args An array of Archives widget drop-down arguments.
             */
            $dropdown_args = apply_filters( 'widget_archives_dropdown_args', array(
                'type'            => 'monthly',
                'format'          => 'option',
                'show_post_count' => $c
            ) );

            switch ( $dropdown_args['type'] ) {
                case 'yearly':
                    $label = __( 'Select Year', 'bootswatches' );
                    break;
                case 'monthly':
                    $label = __( 'Select Month', 'bootswatches' );
                    break;
                case 'daily':
                    $label = __( 'Select Day', 'bootswatches' );
                    break;
                case 'weekly':
                    $label = __( 'Select Week', 'bootswatches' );
                    break;
                default:
                    $label = __( 'Select Post', 'bootswatches' );
                    break;
            }
            ?>
    <div class="form-group">

        <select class="form-control" id="<?php echo esc_attr( $dropdown_id ); ?>"
            name="archive-dropdown"
            onchange='document.location.href=this.options[this.selectedIndex].value;
        '>
            <option value="">
                <?php echo esc_attr( $label ); ?>
            </option>
            <?php wp_get_archives( $dropdown_args ); ?>
        </select>
    </div>
    <?php
    }



    public function list($c, $style = null)
    {

        $class = '';
        $elm = 'ul';
        $format = 'html';
        $before = null;
        if($style == 'unordered-list'):
            $elm = 'ul';
        elseif($style == 'ordered-list'):
            $elm = 'ol';
        elseif($style == 'unstyled-list') :
            $class = 'list-unstyled';
        elseif( $style == 'list-group') :
            $class = 'list-group';
            $li_class = 'list-group-item';
            $format = 'custom';
            $before = '<li class="list-group-item">';
        elseif($style == 'pills'):
            $class = 'nav nav-pills nav-stacked';
        endif;

        echo '<'.esc_attr($elm) .' class="widget-list '.esc_attr($class) .'">';
		/**
		 * Filters the arguments for the Archives widget.
		 *
		 * @since 2.8.0
		 *
		 * @see wp_get_archives()
		 *
		 * @param array $args An array of Archives option arguments.
		 */
        wp_get_archives(
            apply_filters(
                'widget_archives_args',
                array(
                    'type'            => 'monthly',
                    'show_post_count' => $c,
                    'format' => $format,
                    'before' => $before,
                )
            )
        );
	?>
		</<?php echo esc_attr($elm); ?>>
	<?php

    }


	/**
	 * Outputs the content for the current Archives widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Archives widget instance.
	 */
	public function widget( $args, $instance ) {
		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';

        $style = ! empty( $instance['menu_style'] ) ? $instance['menu_style'] : 'side_nav';
        // $style_args = $this->menuStyleArgs($style);


		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Archives', 'bootswatches' ) : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget']; //WPCS: xss ok.
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];  //WPCS: xss ok.
		}

		if ( $style == 'dropdown' )
            $this->dropdown($c);
        else
            $this->list($c, $style);


		echo $args['after_widget'];  //WPCS: xss ok.
	}

	/**
	 * Handles updating settings for the current Archives widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget_Archives::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = $new_instance['count'] ? 1 : 0;
        if ( ! empty( $new_instance['menu_style'] ) ) {
            $instance['menu_style'] = sanitize_text_field($new_instance['menu_style']);
        }


		return $instance;
	}

	/**
	 * Outputs the settings form for the Archives widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
		$title = sanitize_text_field( $instance['title'] );

        $saved_style = isset( $instance['menu_style'] ) ? $instance['menu_style'] : '';

		?>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php echo __('Title:', 'bootswatches');  // WPCS: xss ok.?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                name="<?php echo esc_attr($this->get_field_name('title')); ?>" placeholder="<?php echo esc_attr( 'Archives', 'bootswatches' ); ?>"
                type="text" value="<?php echo esc_attr($title); ?>"
            />
        </p>
        <?php
        // styles
        $find = array('-', '_');
        $menu_styles = array('dropdown', 'unordered-list', 'ordered-list', 'unstyled-list', 'list-group', 'pills');

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'menu_style' )); ?>">
                <?php echo __( 'Menu Style:', 'bootswatches' );  // WPCS: xss ok.?>
            </label>
            <select id="<?php echo esc_attr($this->get_field_id( 'menu_style' )); ?>"
                  name="<?php echo esc_attr($this->get_field_name( 'menu_style' )); ?>">
                <?php
                    foreach ( $menu_styles as $style ) :
                        $label = ucwords(str_replace($find, ' ', $style ));
                ?>
                    <option value="<?php echo esc_attr( $style ); ?>"
                        <?php selected( $saved_style, $style ); ?>>
                        <?php echo esc_html( $label ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['count'] ); ?>
                id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                name="<?php echo esc_attr($this->get_field_name('count')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">
                <?php echo __('Show post counts', 'bootswatches'); // WPCS: xss ok. ?>
            </label>
		</p>
		<?php
	}
}
