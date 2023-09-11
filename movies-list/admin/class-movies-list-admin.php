<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://author.example.com/
 * @since      1.0.0
 *
 * @package    Movies_List
 * @subpackage Movies_List/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Movies_List
 * @subpackage Movies_List/admin
 * @author     Bikash Sahoo <bikashsahoobiki1999@gmail.com>
 */
class Movies_List_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
        add_action('init',[$this,"custom_movie_type"]);
        add_action('init',[$this,"custom_movies_taxonomies"]);
        add_action('add_meta_boxes',[$this,"add_movie_meta_box"]);
        add_action('save_post',[$this,"save_movie_meta"]);

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/movies-list-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/movies-list-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function custom_movie_type() {

		$labels = array(
			'name'                  => _x( 'Movie', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Movie', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Movie', 'text_domain' ),
			'name_admin_bar'        => __( 'All Movie Type', 'text_domain' ),
			'archives'              => __( 'Movie Archives', 'text_domain' ),
			'attributes'            => __( 'Movie Attributes', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent movie:', 'text_domain' ),
			'all_items'             => __( 'All Movies', 'text_domain' ),
			'add_new_item'          => __( 'Add New Movie', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			'new_item'              => __( 'New Movie', 'text_domain' ),
			'edit_item'             => __( 'Edit Movie', 'text_domain' ),
			'update_item'           => __( 'Update Movie', 'text_domain' ),
			'view_item'             => __( 'View Movie', 'text_domain' ),
			'view_items'            => __( 'View Movies', 'text_domain' ),
			'search_items'          => __( 'Search movie', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Poster Image', 'text_domain' ),
			'set_featured_image'    => __( 'Set Poster image', 'text_domain' ),
			'remove_featured_image' => __( 'Remove Poster image', 'text_domain' ),
			'use_featured_image'    => __( 'Use as Poster image', 'text_domain' ),
			'insert_into_movie'      => __( 'Insert into Movie', 'text_domain' ),
			'uploaded_to_this_movie' => __( 'Uploaded to this movie', 'text_domain' ),
			'items_list'            => __( 'Movies list', 'text_domain' ),
			'movies_list_navigation' => __( 'Movies list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter movies list', 'text_domain' ),
		);
		$args = array(
			'label'                 => __( 'Movie', 'text_domain' ),
			'description'           => __( 'Movies Description', 'text_domain'  ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			//'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'movies', $args );
	}

	// Register custom taxonomies for 'movies' post type
	public function custom_movies_taxonomies() {
		// Genre Taxonomy
		$genre_labels = array(
			'name'              => _x( 'Genres', 'taxonomy general name', 'custom-movies' ),
			'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'custom-movies' ),
			'search_items'      => __( 'Search Genres', 'custom-movies' ),
			'all_items'         => __( 'All Genres', 'custom-movies' ),
			'edit_item'         => __( 'Edit Genre', 'custom-movies' ),
			'update_item'       => __( 'Update Genre', 'custom-movies' ),
			'add_new_item'      => __( 'Add New Genre', 'custom-movies' ),
			'new_item_name'     => __( 'New Genre Name', 'custom-movies' ),
			'menu_name'         => __( 'Genres', 'custom-movies' ),
		);
	
		register_taxonomy( 'movie_genre', 'movies', array(
			'hierarchical'      => true,
			'labels'            => $genre_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'genre' ),
		) );
	
		// Category Taxonomy
		$category_labels = array(
			'name'              => _x( 'Categories', 'taxonomy general name', 'custom-movies' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'custom-movies' ),
			'search_items'      => __( 'Search Categories', 'custom-movies' ),
			'all_items'         => __( 'All Categories', 'custom-movies' ),
			'edit_item'         => __( 'Edit Category', 'custom-movies' ),
			'update_item'       => __( 'Update Category', 'custom-movies' ),
			'add_new_item'      => __( 'Add New Category', 'custom-movies' ),
			'new_item_name'     => __( 'New Category Name', 'custom-movies' ),
			'menu_name'         => __( 'Categories', 'custom-movies' ),
		);
	
		register_taxonomy( 'movie_category', 'movies', array(
			'hierarchical'      => true,
			'labels'            => $category_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'action' ),
		) );
	}
	   
	
	// Add custom fields to the 'movies' post type
	public function add_movie_meta_box() {
		add_meta_box(
			'movie_details',
			'Movie Details',
			array($this, 'movie_details_callback'),
			'movies',
			'normal',
			'high'
		);
	}
	
	// Callback function for the Movie details meta box
	public function movie_details_callback($post) {
		// Retrieve the current values of custom fields if they exist
		$release_year = get_post_meta($post->ID, '_release_year', true);
		$movie_length = get_post_meta($post->ID, '_movie_length', true);
		$movie_trailer = get_post_meta($post->ID, '_movie_trailer', true);
		
		?>
		<label for="release_year">Release Year:</label>
		<input type="text" id="release_year" name="release_year" value="<?php echo esc_attr($release_year); ?>"/><br><br>
	
		<label for="movie_length">Movie Length:</label>
		<input type="text" id="movie_length" name="movie_length" value="<?php echo esc_attr($movie_length); ?>"><br><br>
	
		<label for="movie_trailer">Movie Trailer Link:</label>
		<input type="text" id="movie_trailer" name="movie_trailer" value="<?php echo esc_url($movie_trailer); ?>"><br><br>
		<?php
	}
	
	public function save_movie_meta($post_id) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
		if (!empty($_POST['post_type']) && 'movies' != $_POST['post_type']) {
			return $post_id;
		}
	
		$release_year = !empty($_POST['release_year']) ? sanitize_text_field($_POST['release_year']) : '';
		$movie_length = !empty($_POST['movie_length']) ? sanitize_text_field($_POST['movie_length']) : '';
		$movie_trailer_link = !empty($_POST['movie_trailer']) ? esc_url($_POST['movie_trailer']) : '';
	
		// Save custom fields data
		update_post_meta($post_id, '_release_year', $release_year);
		update_post_meta($post_id, '_movie_length', $movie_length);
		update_post_meta($post_id, '_movie_trailer', $movie_trailer_link);
	}
}
