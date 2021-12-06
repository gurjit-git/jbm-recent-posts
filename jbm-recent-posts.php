<?php
/*
Plugin Name: JBM Recent Posts
Plugin URI: http://wordpress.org/
Description: This is a simple plugin to display recent posts. Use [recent-posts] shortcode
Author: Gurjit Singh
Version: 0.1
Author URI: http://gurjitsingh.com
*/
defined( 'ABSPATH' ) or die( 'Direct access not allowed!' );
define( 'JBM_LOCATION_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

include( JBM_LOCATION_PLUGIN_PATH. 'functions/shortcode.php' );
include( JBM_LOCATION_PLUGIN_PATH. 'functions/shortcode-2.php' );

function jbm_include_css_js(){
	wp_enqueue_style( 'jbm_recent_posts_css', plugins_url( '/assets/css/custom.css' , __FILE__ ), true, '1.1', 'all');
	wp_enqueue_script( 'jmb_recent_posts_js', plugins_url( '/assets/js/custom.js' , __FILE__ ), array( 'jquery' ), '1.0.0', true  );

	wp_localize_script('jmb_recent_posts_js', 'ajax_recentpost_load', array('ajaxurl' => admin_url('admin-ajax.php')));
	
}
add_action('wp_enqueue_scripts', 'jbm_include_css_js'); //public scripts and styles

function jbm_ajax_return_post(){
	//echo '<ul>';
        $content = get_post_field('post_content', $_POST["post_id"]);
		$content_pieces = explode(" ", $content);
		$content_part = implode(" ", array_splice($content_pieces, 0, 60));
		
		$active = ($counter == 0) ? 'class="active"' : '';
		echo '<li id="post_'.$_POST['post_id'].'" '.$active.'>';
			echo '<div class="thumbnail-big">'.get_the_post_thumbnail($_POST['post_id'], 'post-thumbnail-560-500').'</div>';
			$cats = get_the_category($_POST['post_id']);
			echo '<div class="RP-cats">';
			foreach($cats as $cat)
			{
				echo '<a href="'.get_category_link( $cat->term_id ).'">'.$cat->name.'</a>';
			}
			echo '</div>';
			echo '<h2><a href="' . get_permalink($_POST['post_id']) .'"  data-id="'.$recent["ID"].'" class="RP-title">' .   ( __(get_the_title($_POST["post_id"]))).'</a></h2>
			<p>'. $content_part . ' [<a href="'. get_permalink($_POST['post_id']).'">...</a>]</p>
			
		</li>';
	//echo '</ul>';
	die();
}
add_action( 'wp_ajax_jmb_singlepost_action', 'jbm_ajax_return_post' );
add_action( 'wp_ajax_nopriv_jmb_singlepost_action', 'jbm_ajax_return_post' );

add_theme_support( 'post-thumbnails' );
add_image_size( 'post-thumbnail-560-500', 560, 500, true );
