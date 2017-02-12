<?php

/*
  Plugin Name: Tim Reddit Widget
  Description: Displays top reddit posts
*/

require('inc/simple_html_dom.php');

class Tim_Reddit_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'A Reddit Widget by Tim', 'text_domain' ),
		);
		parent::__construct(
			'tim_reddit_widget', // Base ID
			esc_html__( 'Tim Reddit Widget', 'text_domain' ), // Name
			$widget_ops
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
	public function widget( $args, $instance ) {
		$title = 'Top 10 reddit posts';

		// Get top 10 posts on reddit
		$html = \simplehtmldom_1_5\file_get_html('https://www.reddit.com/');
		$posts = [];
		$i = 1;
		foreach($html->find('#siteTable') as $post) {
			if ($i > 10) {
				break;
			}
			echo $post->find('a.title', 0)->plaintext;
			$i++;
		}
		
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];
		echo esc_html__( 'Hello, World!', 'text_domain' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Tim_Reddit_Widget

function register_tim_reddit_widget() {
    register_widget( 'Tim_Reddit_Widget' );
}
add_action( 'widgets_init', 'register_tim_reddit_widget' );

?>
