<?php

add_action('widgets_init', function() {
  unregister_widget('WP_Widget_Archives');
  register_widget('Ariana_Widget_Archives');
});

class Ariana_Widget_Archives extends WP_Widget_Archives {

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( $d ) {
			$dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
			?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $dropdown_id ); ?>"><?php echo $title; ?></label>
		<select id="<?php echo esc_attr( $dropdown_id ); ?>" name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'>
			<?php
			$dropdown_args = apply_filters( 'widget_archives_dropdown_args', array(
				'type'            => 'monthly',
				'format'          => 'option',
				'show_post_count' => $c
			), $instance );

			switch ( $dropdown_args['type'] ) {
				case 'yearly':
					$label = __( 'Select Year', 'ariana-widgets' );
					break;
				case 'monthly':
					$label = __( 'Select Month', 'ariana-widgets' );
					break;
				case 'daily':
					$label = __( 'Select Day', 'ariana-widgets' );
					break;
				case 'weekly':
					$label = __( 'Select Week', 'ariana-widgets' );
					break;
				default:
					$label = __( 'Select Post', 'ariana-widgets' );
					break;
			}
			?>

			<option value=""><?php echo esc_attr( $label ); ?></option>
			<?php wp_get_archives( $dropdown_args ); ?>

		</select>
		<?php } else { ?>
		<ul class="check">
		<?php
  		wp_get_archives( apply_filters( 'widget_archives_args', array(
  			'type'            => 'monthly',
  			'show_post_count' => $c
  		), $instance ) );
		?>
		</ul>
		<?php
		}

		echo $args['after_widget'];
	}

}
