<?php
/*
Plugin Name: Shuffle Post Gallery
Version:     1.1.1
Author:      Mihail Teodor Gurzu
Description: Multimedia Design and Production Project : Enables [ShuffleGallery] shortcode which outputs a post gallery.
Text Domain: shuffle-post-gallery
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die;

define( 'SPG_PLUGIN_VERSION', '1.1.1' );

if ( ! class_exists( 'Shuffle_Post_Gallery' ) ) {
	class Shuffle_Post_Gallery {
		public static function getInstance() {
			if ( self::$instance == null ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		private static $instance = null;

		private function __clone() { }

		private function __wakeup() { }

		private function __construct() {
			// Shortcode definition
			add_shortcode( 'ShuffleGallery', array( $this, 'output_gallery' ) );

			// Hook for registering the necessary js scripts and css stylesheet files
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		}

		// This function will generate the shortcode outout (HTML) and enqueue scripts
		public function output_gallery( $atts ) {
			// Get posts to show
			$wp_query = new WP_Query( array(
				'post_type'      => 'post',
				'posts_per_page' => 20,
				'order'          => 'DESC',
				'orderby'        => 'ID',
				'meta_query'     => array(
					array(
						'key'     => '_thumbnail_id',
						'compare' => 'EXISTS'
					)
				)
			) );

			// If no posts, return empty content
			if ( $wp_query->found_posts < 1 ) return '';

			// Store found posts into new variable
			$_posts = $wp_query->posts;

			// Define global categorories array
			$categories = array();

			// Define global posts array
			$posts = array();

			// Loop through each found post
			foreach ( $_posts as $post ) {
				// Set up "aspect", "span" and "img_src" for current post
				$data = $this->calculate_data( $post );

				// If above returns false, skip current post
				if ( ! $data ) continue;

				// Store above data into the current post, using property "spg_data"
				$post->spg_data = $data;

				// Define array to store current post's category slugs
				$post->category_slugs = array();

				// Get current post's categories
				$_categories = wp_get_post_terms( $post->ID, 'category', array( 'fields' => 'all' ) );

				// Store current post's categories into global $categories array and append it to current post's "category_slugs" property
				foreach( $_categories as $category ) {
					if ( ! isset( $categories[$category->slug] ) ) $categories[$category->slug] = $category->name;
					array_push( $post->category_slugs, $category->slug );
				}

				// Append current post to global $posts array
				array_push( $posts, $post );
			}

			// Insert our styles
			wp_enqueue_style( 'spg-shuffle' );

			// Insert our scripts
			wp_enqueue_script( 'spg-shuffle-init' );

			// Output buffering start
			ob_start();

			// Include gallery template
			include( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'gallery.php' );

			// Output buffering end and return shortcode's output
			return ob_get_clean();
		}

		public function register_assets() {
			// Register gallery stylesheet file
			wp_register_style( 'spg-shuffle', plugins_url( 'css/style.css', __FILE__ ), array(), SPG_PLUGIN_VERSION, 'all' );

			// Register shuffle.js script and init script
			wp_register_script( 'spg-shuffle', plugins_url( 'js/shuffle.min.js', __FILE__ ), array(), SPG_PLUGIN_VERSION, true );
			wp_register_script( 'spg-shuffle-init', plugins_url( 'js/init.js', __FILE__ ), array( 'spg-shuffle' ), SPG_PLUGIN_VERSION, true );
		}

		// Function for calculate a post's "aspect", "span" and "img_src"
		private function calculate_data( $post ) {
			$post_thumbnail_id = get_post_thumbnail_id( $post );
			if ( ! wp_attachment_is_image( $post_thumbnail_id ) ) return false;
			$file = get_attached_file( $post_thumbnail_id );
			$size  = @getimagesize( $file );
			if ( ! $size ) return false;
			$ratio = $size[0] / $size[1];
			$img_src = get_the_guid( $post_thumbnail_id );
			switch( true ) {
				case $ratio <= 0.95 :
					return array( 'aspect' => 'aspect--9x80', 'span' => 'row-span', 'img_src' => $img_src );
				case $ratio >= 1.67 :
					return array( 'aspect' => 'aspect--32x9', 'span' => 'col-span', 'img_src' => $img_src );
				default:
					return array( 'aspect' => 'aspect--16x9', 'span' => 'normal-span', 'img_src' => $img_src );
			}
		}
	}
}
Shuffle_Post_Gallery::getInstance();