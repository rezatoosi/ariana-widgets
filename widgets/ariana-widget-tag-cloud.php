<?php

add_action('widgets_init', function() {
  unregister_widget('WP_Widget_Tag_Cloud');
  register_widget('Ariana_Widget_Tag_Cloud');
});

class Ariana_Widget_Tag_Cloud extends WP_Widget_Tag_Cloud {

	public function widget( $args, $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy( $instance );

		if ( ! empty( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' === $current_taxonomy ) {
				$title = __( 'Tags', 'ariana-widgets' );
			} else {
				$tax = get_taxonomy( $current_taxonomy );
				$title = $tax->labels->name;
			}
		}

		$show_count = ! empty( $instance['count'] );

		// $tag_cloud = wp_tag_cloud( apply_filters( 'widget_tag_cloud_args', array(
		// 	'taxonomy'   => $current_taxonomy,
		// 	'echo'       => false,
		// 	'show_count' => $show_count,
		// ), $instance ) );
    $tags = get_tags(array(
     'orderby' => 'count',
     'order'   => 'DESC',
     'number'  => 20
    ));
    foreach ( (array) $tags as $tag ) {
     $tag_cloud .= '<a href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name . '</a>';
    }

		if ( empty( $tag_cloud ) ) {
			return;
		}

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="tags">';

		echo $tag_cloud;

		echo "</div>\n";
		echo $args['after_widget'];
	}

}
