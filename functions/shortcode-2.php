<?php
if(!function_exists('jbm_recent_posts_shortcode2')){
	function jbm_recent_posts_shortcode2($atts){
		$args = array(
			'numberposts' => 4,
			'offset' => 0,
			'category' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'include' => '',
			'exclude' => '',
			'meta_key' => '',
			'meta_value' =>'',
			'post_type' => 'post',
			'post_status' => 'publish',
			'suppress_filters' => true
		);
		$counter = '';
		$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
		
		$list = '<div class="RP-container">';
		
			$list .= '<div class="RP-col-left">
				<div class="RP-post">
					<div class="RP-post-inner">';
					$list .= '<ul>';
						$latest_post = explode(" ", $recent_posts[0]["post_content"]);
						$latest_post_part = implode(" ", array_splice($latest_post, 0, 60));
						$active = ($counter == 0) ? 'class="active"' : '';
						$list .= '<li id="post_'.$recent_posts[0]["ID"].'" '.$active.'>';
							$list .= '<div class="thumbnail-big">'.get_the_post_thumbnail($recent_posts[0]["ID"], 'post-thumbnail-560-500').'</div>';
							$cats = get_the_category($recent_posts[0]["ID"]);
							$list .= '<div class="RP-cats">';
							foreach($cats as $cat)
							{
								$list .= '
									<a href="'.get_category_link( $cat->term_id ).'">'.$cat->name.'</a>
								';
							}
							$list .= '</div>';
							$list .= '<h2><a href="' . get_permalink($recent_posts[0]["ID"]) .'"  data-id="'.$recent_posts[0]["ID"].'" class="RP-title">' .   ( __($recent_posts[0]["post_title"])).'</a></h2>
							<p>'. $latest_post_part . ' [<a href="'. get_permalink($recent_posts[0]["ID"]).'">...</a>]</p>
							
						</li>';
						$counter++; 
					$list .= '
					</ul>
					
					</div>
					<div id="loading-image">
						<img src="' . esc_url( plugins_url( 'images/loader.gif', dirname(__FILE__) ) ) . '">
					</div>
				</div>
			</div>';
			
			$list .= '<div class="RP-col-right">';
				$list .= '<ul class="gs-recent-posts">';
				foreach( $recent_posts as $recent ){
					$excerpt_pieces = explode(" ", $recent["post_content"]);
					$excerpt_part = implode(" ", array_splice($excerpt_pieces, 0, 5));
					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $recent["ID"] ), 'thumbnail' );
					$list .= '<li>';
						$list .= '<div class="RP-thumbnail inline">
							<a href="' . get_permalink($recent["ID"]) .'"><div class="RP-thumbnail-inner" style="background:url('.$large_image_url[0].')"></div></a>
						</div>';
						
						$list .= '<div class="RP-text inline">';
						$cats = get_the_category($recent["ID"]);
							$list .= '<div class="RP-cats">';
							foreach($cats as $cat)
							{
								$list .= '
									<a href="'.get_category_link( $cat->term_id ).'">'.$cat->name.'</a>
								';
							}
							$list .= '</div>';
							$list .= '<h2><a href="' . get_permalink($recent["ID"]) .'"  data-id="'.$recent["ID"].'" class="RP-title-1">' .   ( __($recent["post_title"])).'</a></h2>
							<p>' . $excerpt_part .'</p>
							
						</div>
					</li>';

				}
				wp_reset_query();
				$list .= '
				</ul>
			</div>
			
		</div>';
		
		return $list;

	}

	add_shortcode('recent-posts-2', 'jbm_recent_posts_shortcode2');
}