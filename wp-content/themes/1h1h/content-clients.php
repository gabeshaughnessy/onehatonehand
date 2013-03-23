<?php 
//The clients page content
?>
<div id="clients" class="section">
	<div id="clients-wrapper" class="wrapper post-type-wrapper">
			<div id="clients-posts" class="post-box full-width">
			<h2 class="section-title center" id="clients-title">clients</h2>
				<div class="primary">
						<div class="content" role="main">
				
							<?php 
							$client_list = get_transient('client_list');
							if($client_list == '') {
							$args = array(
											
													'post_type' => 'hh_client',
													'posts_per_page' => -1
												
												
										);
										$custom_query = new WP_Query( $args );
										if ( $custom_query->have_posts() ) :
											$client_list .= '<div class="row "><div class="three columns first">';
											$i = 1;
											$post_count = $custom_query->post_count;
											 while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
											
											$meta_values = hh_get_meta_values(get_the_ID());
											
											$client_list .= '<div id="post_'.get_the_ID().'" class="client hh_client_post">';
										
										    $client_list .= '<h2 class="post-title">'.get_the_title().'</h2>';
											$client_list .= '</div>'; 
											if ($i > $post_count/3 && $i <= ($post_count/3 + 1)){
											$client_list .= '</div><div class="three columns">';
											}
											elseif($i > 2*($post_count/3)&& $i <= 2*($post_count/3)+1) { 
											$client_list .= '</div><div class="three columns last">';
											}
											elseif($i == $post_count){
											$client_list .= '</div>';
											
											}
											$i = $i + 1;
											
											endwhile;							
											$client_list .= '</div>';
											 else :
										$client_list .= '<p> nothing for you here</p>';
											 endif; 
										// Reset Post Data
										wp_reset_postdata();
										
							
							set_transient('client_list', $client_list, 60*60*24*7);
							}
							echo $client_list;
							
					 get_template_part('post_footer'); ?>
				
			
				</div>
				</div>
			</div>
			

	</div><!-- end clients wrapper -->
</div><!-- end clients section -->