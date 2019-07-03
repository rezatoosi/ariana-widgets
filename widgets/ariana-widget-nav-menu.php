<?php

function ariana_widget_nav_menu_register(){
  unregister_widget('WP_Nav_Menu_Widget');
  register_widget('Ariana_Nav_Menu_Widget');
}
add_action('widgets_init', 'ariana_widget_nav_menu_register');

class Ariana_Nav_Menu_Widget extends WP_Widget {


	public function __construct() {
		$widget_ops = array(
			'description' => __( 'Add a nav menu to your sidebar.', 'ariana-widgets' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'ariana_nav_menu', __('Ariana - Navigation Menu', 'ariana-widgets'), $widget_ops );
	}

	public function widget( $args, $instance ) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( ! $nav_menu ) {
			return;
		}

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

    $container_class = ! empty( $instance['container_class'] ) ? $instance['container_class'] : '';
    $ul_class = ! empty( $instance['ul_class'] ) ? $instance['ul_class'] : '';

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$nav_menu_args = array(
			'fallback_cb' => '',
			'menu'        => $nav_menu
		);

		// wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );
    wp_nav_menu( array(
        'menu'            => $nav_menu,
        'container'       => 'div',
        'container_class' => $container_class,
        'container_id'    => '',
        'menu_class'      => $ul_class,
        'menu_id'         => '',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'depth'           => 0
      ) );

		echo $args['after_widget'];
	}


	public function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
    if ( ! empty( $new_instance['container_class'] ) ) {
			$instance['container_class'] = sanitize_text_field( $new_instance['container_class'] );
		}
    if ( ! empty( $new_instance['ul_class'] ) ) {
			$instance['ul_class'] = sanitize_text_field( $new_instance['ul_class'] );
		}
		if ( ! empty( $new_instance['nav_menu'] ) ) {
			$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		}
		return $instance;
	}

	public function form( $instance ) {
		global $wp_customize;
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
    $container_class = isset( $instance['container_class'] ) ? $instance['container_class'] : '';
    $ul_class = isset( $instance['ul_class'] ) ? $instance['ul_class'] : '';

		// Get menus
		$menus = wp_get_nav_menus();

		// If no menus exists, direct the user to go and create some.
		?>
		<p class="nav-menu-widget-no-menus-message" <?php if ( ! empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<?php
			if ( $wp_customize instanceof WP_Customize_Manager ) {
				$url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
			} else {
				$url = admin_url( 'nav-menus.php' );
			}
			?>
      <?php /* translators: %s: url to create a new menu */ ?>
			<?php echo sprintf( __( 'No menus have been created yet. <a href="%s">Create some</a>.', 'ariana-widgets' ), esc_attr( $url ) ); ?>
		</p>
		<div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<p>
        <?php /* translators: Title of menu */ ?>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ariana-widgets' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
      <p>
				<label for="<?php echo $this->get_field_id( 'container_class' ); ?>"><?php _e( 'Container Class:', 'ariana-widgets' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'container_class' ); ?>" name="<?php echo $this->get_field_name( 'container_class' ); ?>" value="<?php echo esc_attr( $container_class ); ?>"/>
			</p>
      <p>
				<label for="<?php echo $this->get_field_id( 'ul_class' ); ?>"><?php _e( 'UL Class:', 'ariana-widgets' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ul_class' ); ?>" name="<?php echo $this->get_field_name( 'ul_class' ); ?>" value="<?php echo esc_attr( $ul_class ); ?>"/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'nav_menu' ); ?>"><?php /* translators: List of existing menus */ _e( 'Select Menu:', 'ariana-widgets' ); ?></label>
				<select id="<?php echo $this->get_field_id( 'nav_menu' ); ?>" name="<?php echo $this->get_field_name( 'nav_menu' ); ?>">
					<option value="0"><?php _e( '&mdash; Select &mdash;', 'ariana-widgets' ); ?></option>
					<?php foreach ( $menus as $menu ) : ?>
						<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
							<?php echo esc_html( $menu->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php if ( $wp_customize instanceof WP_Customize_Manager ) : ?>
				<p class="edit-selected-nav-menu" style="<?php if ( ! $nav_menu ) { echo 'display: none;'; } ?>">
					<button type="button" class="button"><?php _e( 'Edit Menu', 'ariana-widgets' ) ?></button>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}
}
