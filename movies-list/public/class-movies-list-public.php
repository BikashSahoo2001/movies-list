<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://author.example.com/
 * @since      1.0.0
 *
 * @package    Movies_List
 * @subpackage Movies_List/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Movies_List
 * @subpackage Movies_List/public
 * @author     Bikash Sahoo <bikashsahoobiki1999@gmail.com>
 */
class Movies_List_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode( 'movie_list', array( $this, 'movie_list_shortcode' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Movies_List_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Movies_List_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/movies-list-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Movies_List_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Movies_List_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/movies-list-public.js', array( 'jquery' ), $this->version, false );

	}

	public function movie_list_shortcode($atts) {
		$atts = shortcode_atts(array(
			'number' => 4,
			'genre' => 'all',
		), $atts);
		$number = intval($atts['number']);
		$genre = sanitize_text_field($atts['genre']);
		$args = array(
			'post_type' => 'movies',
			'posts_per_page' => $number,
		);
		if ($genre !== 'all') {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'movie_category',
					'field' => 'slug',
					'terms' => $genre,
				),
			);
		}
		$movie_query = new WP_Query
		($args);
		// Display the list of movies
		if ($movie_query->have_posts()) {
			$output = '<ul>';
			while ($movie_query->have_posts()) {
				$movie_query->the_post();
				$output .= '<li>' . get_the_title() . '</li>';
			}
			$output .= '</ul>';
		} else {
			$output = 'No movies found.';
		}
		wp_reset_postdata();
		return $output;
	}

}
