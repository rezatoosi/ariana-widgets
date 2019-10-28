<?php

add_action('widgets_init', function() { register_widget('Ariana_Widget_Recent_Posts'); });

class Ariana_Widget_Recent_Posts extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'ariana_widget_recent_entries',
			'description' => __( 'Your site&#8217;s most recent Posts.', 'ariana-widgets' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'ariana-recent-posts', __( 'Ariana - Recent Posts', 'ariana-widgets' ), $widget_ops );
		$this->alt_option_name = 'ariana_widget_recent_entries';
	}

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

    $container_class = ( ! empty( $instance['container_class'] ) ) ? ' class="' . $instance['container_class'] . '"' : '';
    $ul_class = ( ! empty( $instance['ul_class'] ) ) ? ' class="' . $instance['ul_class'] . '"' : '';

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		), $instance ) );

		if ( ! $r->have_posts() ) {
			return;
		}
		?>
		<?php echo $args['before_widget']; ?>
		<?php
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
    <div<?php echo $container_class ?>>
  		<ul<?php echo $ul_class ?>>
  			<?php foreach ( $r->posts as $recent_post ) : ?>
  				<?php
  				$post_title = get_the_title( $recent_post->ID );
  				$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)', 'ariana-widgets' );

          // get_the_post_thumbnail_caption( $recent_post->ID )
          $thumbnail_id = get_post_thumbnail_id( $recent_post->ID );
          $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
  				?>
  				<li>
            <a href="<?php esc_url(the_permalink( $recent_post->ID )); ?>">
              <?php if (has_post_thumbnail( $recent_post->ID )) { ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url( $recent_post->ID, 'thumbnail' )); ?>" alt="<?php echo esc_html( $alt ); ?>" class="img-responsive">
              <?php } else { ?>
                <img src="<?php echo esc_url(ARIANA_WIDGETS_ASSETS_DIR . 'img/post-default.png'); ?>" alt="<?php echo esc_html($title); ?>" class="img-responsive">
              <?php } ?>
  					<h3><?php echo $title ; ?></h3>
  					<?php if ( $show_date ) : ?>
  						<small><span class="post-date"><?php echo get_the_date( '', $recent_post->ID ); ?></span></small>
  					<?php endif; ?>
            </a>
  				</li>
  			<?php endforeach; ?>
  		</ul>
    </div>
		<?php
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
    $instance['container_class'] = sanitize_text_field( $new_instance['container_class'] );
    $instance['ul_class'] = sanitize_text_field( $new_instance['ul_class'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
    $container_class = isset( $instance['container_class'] ) ? esc_attr( $instance['container_class'] ) : '';
    $ul_class = isset( $instance['ul_class'] ) ? esc_attr( $instance['ul_class'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ariana-widgets' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

    <p><label for="<?php echo $this->get_field_id( 'container_class' ); ?>"><?php _e( 'Container Class:', 'ariana-widgets' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'container_class' ); ?>" name="<?php echo $this->get_field_name( 'container_class' ); ?>" type="text" value="<?php echo $container_class; ?>" /></p>

    <p><label for="<?php echo $this->get_field_id( 'ul_class' ); ?>"><?php _e( 'UL Class:', 'ariana-widgets' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ul_class' ); ?>" name="<?php echo $this->get_field_name( 'ul_class' ); ?>" type="text" value="<?php echo $ul_class; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'ariana-widgets' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'ariana-widgets' ); ?></label></p>
<?php
	}
}
