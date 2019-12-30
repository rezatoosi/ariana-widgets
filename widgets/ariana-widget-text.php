<?php

function ariana_widget_text(){
  register_widget('Ariana_Widget_Text');
}
add_action('widgets_init','ariana_widget_text');

class Ariana_Widget_Text extends WP_Widget {

	protected $registered = false;

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_text',
			'description' => __( 'Arbitrary text.', 'ariana-widgets' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array(
			'width' => 400,
			'height' => 350,
		);
		parent::__construct( 'ariana_text', __( 'Ariana - Text', 'ariana-widgets' ), $widget_ops, $control_ops );

    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

  public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_script( 'ariana-widget-text-editor-js' );
	}

	public function widget( $args, $instance ) {
		global $post;

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$text = ! empty( $instance['text'] ) ? $instance['text'] : '';

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

    echo $text;

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance = wp_parse_args( $new_instance, array(
			'title' => '',
			'text' => ''
		) );

		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = wp_kses_post( $new_instance['text'] );
		}

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title' => '',
				'text' => '',
			)
		);
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ariana-widgets' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
			</p>
			<p class="ariana-editor-container">
				<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:', 'ariana-widgets' ); ?></label>
				<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $instance['text']; ?></textarea>
			</p>
		<?php
	}

}
