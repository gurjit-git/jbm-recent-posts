jQuery(document).ready(function(){
	
	jQuery('.RP-container .gs-recent-posts li .RP-title').mouseover(
		function () {
			var post_id = jQuery(this).data('id');
			//jQuery('.RP-post li').removeClass('active rp-fadein');
			//jQuery('#post_'+post_id).addClass('active rp-fadein');
			jQuery('.RP-post li').fadeOut('slow');
			jQuery('#post_'+post_id).delay(700).fadeIn('slow');
		}	
	);
	
	jQuery('.RP-container .gs-recent-posts li .RP-title-1').on('mouseenter',
		function (e) {
			$this = jQuery(this);
			var timeout = setTimeout(function () { 
				
				var post_id = $this.data('id');
	
				jQuery('.RP-post-inner').fadeOut();
				jQuery('#loading-image').show();
				jQuery.ajax({
					type: 'POST',
					data: {action:"jmb_singlepost_action", post_id: post_id},
					url: ajax_recentpost_load.ajaxurl,
					success:function(response){
						jQuery(".RP-post-inner").html(response);
						jQuery('.RP-post-inner').fadeIn('slow');	
					},
					complete: function(){
						jQuery('#loading-image').hide();
					},
					error: function (response) {
					  //$('.gallery').html(response); 
					  console.log(response)
					}

				});
				
			}, 100 );
			 jQuery(e.target).one('mouseleave', function () {
				 clearTimeout(timeout);
			 });
			
		}	
	);
	
});