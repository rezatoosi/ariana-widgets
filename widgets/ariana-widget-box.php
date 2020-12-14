<?php

add_action( 'widgets_init', function(){ register_widget( 'Ariana_Widget_Box' ); } );

if ( ! function_exists( 'ariana_get_attachment_image' ) ) {
  function ariana_get_attachment_image() {
    $id  = intval( $_POST['attachment_id'] );
    $src = wp_get_attachment_image_src( $id, 'full', false );
    if ( ! empty( $src[0] ) ) {
      echo esc_url( $src[0] );
    }
    die();
  }
}
add_action( 'wp_ajax_ariana_get_attachment_media', 'ariana_get_attachment_image' );

class Ariana_Widget_Box extends WP_Widget {

	function __construct() {
		parent::__construct(
			'ariana_box', __( 'Ariana - Box', 'ariana-widgets' ), array(
				'description' => __( 'Add a box in predefined style.', 'ariana-widgets' ),
				'customize_selective_refresh' => true,
			)
		);

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );
	}


	public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'underscore' );
		wp_enqueue_media();
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		// wp_enqueue_script( 'ariana-widget-upload-image', ARIANA_WIDGETS_ASSETS_DIR . 'js/widget-upload-image.js', false, '1.0', true );
		wp_enqueue_script( 'ariana-widgets-epsilon-object', ARIANA_WIDGETS_ASSETS_DIR . '/js/epsilon.js', array( 'jquery' ) );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'iconpicker-css' );
		wp_enqueue_style( 'iconpicker-theme-css' );
		wp_enqueue_script( 'iconpicker-js' );
		wp_enqueue_script( 'ariana-widget-text-editor-js' );
	}

	public function print_scripts() {
		?>
			<script>
				( function( $ ) {
				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
					defaultColor: '#000000',
					change: _.throttle( function() { // For Customizer
						$( this ).trigger( 'change' );
					}, 3000 )
					} );
				}

				function initIconPicker( widget ) {
					widget.find( '.fontawesome-picker' ).fontIconPicker();
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
					initIconPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.color-picker)' ).each( function() {
					initColorPicker( $( this ) );
					} );
					$( '#widgets-right .widget:has(.fontawesome-picker)' ).each( function() {
					initIconPicker( $( this ) );
					} );
				} );
				}( jQuery ) );
			</script>
		<?php
	}

	function default_array() {
		$defaults = array(
			'title' => 'Box Title',
			'text' => '',
			'image' => '',
			'icon'  => '',
			'color' => '',
			'con_class' =>  apply_filters( 'ariana_widget_box_con_class_default', '' ),
			'icon_con_class' => apply_filters( 'ariana_widget_box_icon_con_class_default', '' ),
			'content_con_class' => apply_filters( 'ariana_widget_box_content_con_class_default', '' ),
      'btn_text' => '',
      'btn_class' => apply_filters( 'ariana_widget_box_btn_class_default', 'btn btn-border btn-icon-right' ),
      'btn_link' => '#',
		);
		return $defaults;
	}

	public function widget_styles(){
		$instance_id = $this->id;
		$color = '#000'; //$this->$instance['color'];

		$widget_styles = "<style type=\"text/css\" id=\"$instance_id\">
		.$instance_id {
		    background-color: $color !important;
		}

		.$instance_id.hovicon.effect-1:after {
		    box-shadow: 0 0 0 2px $color;
		}</style>";

		// wp_enqueue_style( 'ariana-style' );
		// wp_add_inline_style( 'ariana-style', $widget_styles );
		echo $widget_styles;
	}

	public function widget_html( $instance ){
		$instance = wp_parse_args( $instance, $this->default_array() );
		$instance_id = $this->id;

		$img_ico = '';
		if ( !empty( $instance['image'] ) ){
			$img_ico = wp_get_attachment_image_src( $instance['image'] , 'thumbnail', false );
			if ( ! empty( $img_ico[0] ) ) {
				$img_ico = sprintf( '<img src="%1$s" alt="%2$s" />', esc_url( $img_ico[0] ), esc_attr( $instance['title'] ) );
			}
		}elseif ( !empty( $instance['icon'] ) ){
			$img_ico = sprintf( '<i class="fa %1$s"></i>', esc_attr( $instance['icon'] ) );
		}

    $btn = '';
    if ( ! empty( $instance['btn_text'] ) ) {
      $btn = sprintf( '<a href="%1$s" class="%2$s">%3$s <i class="fa fa-chevron-left"></i></a>',
          esc_attr( $instance['btn_link'] ),
          esc_attr( $instance['btn_class'] ),
          esc_attr( $instance['btn_text'] )
        );
    }

		$output  = '<div class="' . esc_attr( apply_filters( 'ariana_widget_box_con_class', $instance['con_class'] ) ) . '">';
		$output .=		'<div class="' . $instance_id . ' ' . esc_attr( apply_filters( 'ariana_widget_box_icon_con_class', $instance['icon_con_class'] ) ) . '">';
		$output .=				$img_ico;
		$output .=		'</div>';
		$output .=		'<div class="' . esc_attr( apply_filters( 'ariana_widget_box_content_con_class', $instance['content_con_class'] ) ) . '">';
		$output .=				'<h2>' . wp_kses_post( $instance['title'] ) . '</h2>';
		$output .=				'<p>';
		$output .=						wp_kses_post( $instance['text'] );
    $output .=				'</p>';
		$output .=				$btn;
		$output .=		'</div>';
		$output .= '</div>';

		$color = $instance['color'];
		if ( !empty( $color ) ){
			$widget_styles = "
			/* .$instance_id {
			    background-color: $color !important;
			}
      .$instance_id.hovicon.effect-1:after {
			    box-shadow: 0 0 0 2px $color;
			}
      */

      .$instance_id i {
			    color: $color !important;
			}

			";
			wp_enqueue_style( 'ariana-widgets', ARIANA_WIDGETS_ASSETS_DIR . 'css/style.css');
			wp_add_inline_style( 'ariana-widgets', $widget_styles );
		}

		return $output;
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		echo $this->widget_html($instance);

		echo $args['after_widget'];
	}

	public function form( $instance ) {

		$instance = wp_parse_args( $instance, $this->default_array() );

		if ( !empty( $instance['image'] ) ){
			$image_src = wp_get_attachment_image_src( $instance['image'] , 'full', false );
			if ( ! empty( $image_src[0] ) ) {
				$image_src = esc_url( $image_src[0] );
				$upload_link = esc_url( get_upload_iframe_src( 'image', $image_src ) );
			}
		}else{
			$image_src = '';
		}

		$get_fontawesome_icons = Ariana_FontAwesome::fontawesome_icons();
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ariana-widgets' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>

    <p class="ariana-editor-container">
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:', 'ariana-widgets' ); ?></label>
			<textarea class="widefat" rows="7" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo wp_kses_post( $instance['text'] ); ?></textarea>
		</p>

		<p class="ariana-media-control" data-delegate-container="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php _e( 'Image', 'ariana-widgets' ); ?>:</label>

			<span class="img-preview">
				<a href="<?php echo $image_src ?>" style="background-color:<?php echo esc_attr( $instance['color'] ); ?>" target="_blank">
					<img src="<?php echo $image_src ?>"/>
				</a>
			</span>

			<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" value="<?php echo $instance['image']; ?>" class="image-id blazersix-media-control-target">

			<button type="button" class="button upload-button"><?php _e( 'Choose Image', 'ariana-widgets' ); ?></button>
			<button type="button" class="button remove-button"><?php _e( 'Remove Image', 'ariana-widgets' ); ?></button>
		</p>

		<!--<p>
			<label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:', 'ariana-widgets' ); ?></label>
			<img src="<?php echo  esc_url( $instance['image'] ); ?>" width="100%" class="custom_media_image_<?php echo $this->get_field_id( 'image' ); ?>" />
			<input type="text" class="widefat custom_media_url_<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" value="<?php echo $instance['image']; ?>" >
			<input type="text" class="widefat custom_media_id" name="" value="" >
			<input type="button" class="button button-primary custom_media_button" id="custom_media_button_service" data-fieldid="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php _e( 'Upload Image', 'ariana-widgets' ); ?>" style="margin-top: 5px;">
		</p>-->

		<p>
			<label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php _e( 'Icon:', 'ariana-widgets' ); ?><br/></label>
			<select class="widefat fontawesome-picker" id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>">
				<option value="all-font-awesome-icons"><?php _e( 'All Font Awesome Icons', 'ariana-widgets' ); ?></option>
				<?php foreach ( $get_fontawesome_icons as $key => $get_fontawesome_icon ) : ?>
					<option value="fa <?php echo esc_attr( $key ); ?>" <?php selected( $instance['icon'], 'fa ' . $key ); ?>>
						fa <?php echo esc_html( $get_fontawesome_icon ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e( 'Color:', 'ariana-widgets' ); ?></label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'color' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'color' ); ?>" value="<?php echo esc_attr( $instance['color'] ); ?>" data-default-color="#000000"/>
		</p>

    <p>
			<label for="<?php echo $this->get_field_id( 'btn_text' ); ?>"><?php _e( 'Button Text:', 'ariana-widgets' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'btn_text' ); ?>" name="<?php echo $this->get_field_name( 'btn_text' ); ?>" type="text" value="<?php echo esc_attr( $instance['btn_text'] ); ?>">
		</p>

    <p>
			<label for="<?php echo $this->get_field_id( 'btn_link' ); ?>"><?php _e( 'Button Link:', 'ariana-widgets' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'btn_link' ); ?>" name="<?php echo $this->get_field_name( 'btn_link' ); ?>" type="text" value="<?php echo esc_url( $instance['btn_link'] ); ?>">
		</p>

    <p>
			<label for="<?php echo $this->get_field_id( 'btn_class' ); ?>"><?php _e( 'Button CSS Class:', 'ariana-widgets' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'btn_class' ); ?>" name="<?php echo $this->get_field_name( 'btn_class' ); ?>" type="text" value="<?php echo esc_attr( $instance['btn_class'] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'con_class' ); ?>"><?php _e( 'Container CSS Class:', 'ariana-widgets' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'con_class' ); ?>" name="<?php echo $this->get_field_name( 'con_class' ); ?>" type="text" value="<?php echo esc_attr( $instance['con_class'] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'icon_con_class' ); ?>"><?php _e( 'Icon Container CSS Class:', 'ariana-widgets' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'icon_con_class' ); ?>" name="<?php echo $this->get_field_name( 'icon_con_class' ); ?>" type="text" value="<?php echo esc_attr( $instance['icon_con_class'] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'content_con_class' ); ?>"><?php _e( 'Content Container CSS Class:', 'ariana-widgets' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'content_con_class' ); ?>" name="<?php echo $this->get_field_name( 'content_con_class' ); ?>" type="text" value="<?php echo esc_attr( $instance['content_con_class'] ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_kses_post( $new_instance['title'] ) : '';
    $instance['text'] = ( ! empty( $new_instance['text'] ) ? wp_kses_post( $new_instance['text'] ) : '' );
		$instance['image']  = ( ! empty( $new_instance['image'] ) ? sanitize_text_field( $new_instance['image'] ) : '' );
    $instance['icon']  = ( ! empty( $new_instance['icon'] ) ? sanitize_text_field( $new_instance['icon'] ) : '' );
    $instance['color'] = ( ! empty( $new_instance['color'] ) ? sanitize_hex_color( $new_instance['color'] ) : '' );
    $instance['con_class']  = ( ! empty( $new_instance['con_class'] ) ? sanitize_text_field( $new_instance['con_class'] ) : '' );
    $instance['icon_con_class']  = ( ! empty( $new_instance['icon_con_class'] ) ? sanitize_text_field( $new_instance['icon_con_class'] ) : '' );
    $instance['content_con_class']  = ( ! empty( $new_instance['content_con_class'] ) ? sanitize_text_field( $new_instance['content_con_class'] ) : '' );
    $instance['btn_text']  = ( ! empty( $new_instance['btn_text'] ) ? sanitize_text_field( $new_instance['btn_text'] ) : '' );
    // $instance['btn_link']  = ( ! empty( $new_instance['btn_link'] ) ? sanitize_text_field( $new_instance['btn_link'] ) : '' );
    $instance['btn_link']  = ( ! empty( $new_instance['btn_link'] ) ? $new_instance['btn_link'] : '' );
    $instance['btn_class']  = ( ! empty( $new_instance['btn_class'] ) ? sanitize_text_field( $new_instance['btn_class'] ) : '' );
		return $instance;
	}

}
