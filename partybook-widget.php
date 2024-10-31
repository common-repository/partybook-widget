<?php
/**
 Plugin Name: PartyBook Widget
 Plugin URI: https://www.upwork.com/freelancers/~0161ad757072c0105b
 Description: A plugin to display a booking form using GET method, through a widget named, PartyBook.
 Version: 1.1
 Author: Keith Renn
 Author URI: https://www.upwork.com/freelancers/~0161ad757072c0105b
 License: GPLv2
 License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

defined( 'ABSPATH' ) or exit;
defined( 'PARTYBOOK_WIDGET_DEBUG' ) or define( 'PARTYBOOK_WIDGET_DEBUG', false );



//Initiate required classes
add_action( 'widgets_init', 'register_partybook_widget' );
function register_partybook_widget() {
	register_widget( __( 'PartyBook_Widget', 'pbw' ) );
}



/**
 * Define the partybook widget object
 */
class PartyBook_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 
			'classname' => 'my_widget',
			'description' => 'My Widget is awesome',
		);
		parent::__construct( false, 'PartyBook Widget', $widget_ops );
	}

	// Widget output
	function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		} ?>
		<!-- Start PartyBook Widget -->
		<form action="http://partycache.com/private_dining_venues/index.php" target="_blank" method="get">
			<div class="">
				<div class="partybook-element">
					<label for="partybook_datepicker"><span><?php _e( 'What Date?', 'pbw' ); ?></span></label>
					<input type="text" id="partybook_datepicker" data-toggle="datepicker" class="" name="d" value="">
				</div>
				<div class="partybook-element">
					<label for="partybook_guests"><span><?php _e( 'No. of Guests', 'pbw' ); ?></span></label>
					<input type="number" min="1" id="partybook_guests" class="" name="o" value="">
				</div>
				<input type="hidden" name="sp_id" value="<?php echo $instance['customer']; ?>">
				<div class="partybook-element">
					<input type="submit" class="partybook-submit-element" value="<?php _e( 'Submit', 'pbw' ); ?>"><br>
					<span class="dis"><?php _e( 'No date yet? Just click Submit.', 'pbw' ); ?></span>
				</div>
			</div>
			<span><?php _e( 'Powered by:', 'pbw' ); ?> <img src="<?php echo plugins_url( 'assets/partycache_logo_tm_80.png', __FILE__ ); ?>" border="0" /></span>
		</form>
		<!-- End PartyBook Widget -->
	<?php echo $args['after_widget'];
	}

	// Save widget options
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['customer'] = ( ! empty( $new_instance['customer'] ) ) ? strip_tags( $new_instance['customer'] ) : '';
		return $instance;
	}

	// Output admin widget options form
	function form( $instance ) {
		$title = ( isset( $instance['title'] ) ? $instance['title'] : false );
		$customer = ( isset( $instance['customer'] ) ? $instance['customer'] : false ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'customer' ); ?>"><?php _e( 'Widget ID:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'customer' ); ?>" name="<?php echo $this->get_field_name( 'customer' ); ?>" type="numeric" value="<?php echo esc_attr( $customer ); ?>">
		</p>
		<span><?php _e( 'Powered by', 'pbw' ); ?><br><img src="<?php echo plugins_url( 'assets/partycache_logo_tm_80.png', __FILE__ ); ?>" border="0" /></span><br>
	<?php
	}
}



add_action( 'wp_footer', 'pbw_partybook_datepicker_script' );
function pbw_partybook_datepicker_script() {
	wp_enqueue_script( 'pbw-datepicker-script', plugins_url() . '/partybook-widget/assets/datepicker.js', array( 'jquery' ) );
	wp_enqueue_style( 'pbw-datepicker-style', plugins_url() . '/partybook-widget/assets/datepicker.css' );
 ?>
		<style type="text/css">
			.partybook-element { width: 100%; margin: 15px 0px 15px 0px; }
			.partybook-submit-element { margin: 0px 0px 10px 0px; }
		</style>
		<script type="text/javascript">
			jQuery(document).ready( function() { jQuery('[data-toggle="datepicker"]').datepicker(); });
		</script>
<?php } ?>
