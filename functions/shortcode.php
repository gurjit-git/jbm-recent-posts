<?php
if(!function_exists('jbm_recent_posts_shortcode')){
	function jbm_recent_posts_shortcode($atts){
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
				<div class="RP-post">';
					$list .= '<ul>';
					foreach( $recent_posts as $recent ){
						
						$content_pieces = explode(" ", $recent["post_content"]);
						$content_part = implode(" ", array_splice($content_pieces, 0, 60));
						
						$active = ($counter == 0) ? 'class="active"' : '';
						$list .= '<li id="post_'.$recent["ID"].'" '.$active.'>';
							$list .= '<div class="thumbnail-big">'.get_the_post_thumbnail($recent["ID"]).'</div>';
							$cats = get_the_category($recent["ID"]);
							$list .= '<div class="RP-cats">';
							foreach($cats as $cat)
							{
								$list .= '
									<a href="'.get_category_link( $cat->term_id ).'">'.$cat->name.'</a>
								';
							}
							$list .= '</div>';
							$list .= '<h2><a href="' . get_permalink($recent["ID"]) .'"  data-id="'.$recent["ID"].'" class="RP-title">' .   ( __($recent["post_title"])).'</a></h2>
							<p>'. $content_part . ' [<a href="'. get_permalink($recent["ID"]).'">...</a>]</p>
							
						</li>';
						$counter++; 
					}
					wp_reset_query();
					$list .= '
					</ul>
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
							$list .= '<h2><a href="' . get_permalink($recent["ID"]) .'"  data-id="'.$recent["ID"].'" class="RP-title">' .   ( __($recent["post_title"])).'</a></h2>
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

	add_shortcode('recent-posts', 'jbm_recent_posts_shortcode');
}