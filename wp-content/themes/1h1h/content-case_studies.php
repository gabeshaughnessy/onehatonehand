<?php 
//The case studies page content
?>
<div id="case-studies" class="section">
	<div id="case_studies-wrapper" class="wrapper post-type-wrapper">
			<h2 class="fredericka centered">Projects</h2>
			<div id="case_studies-posts" class="">
				<div class="primary">
					<div class="content" role="main">
						<?php
						if(!is_user_logged_in()){
						$post_list = get_transient('case-study-list');
							}
						elseif (is_user_logged_in()) {
							$post_list = false;
						}
						if($post_list == false){
						$args = array(
										
										'post_type' => 'hh_case_study',
										'post_count' => -1,
										'orderby' => 'menu_order  parent',
										'order' => 'ASC'
											
									);
						$custom_query = new WP_Query( $args );

						$post_count = 1;

						$post_list .=  '<div id="slide-container" class="cycle">';
							if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
								
								if($post_count == 1 || $post_count % 3 == 1){ $post_list .=  '<div class="slide">';}
								$meta_values = hh_get_meta_values(get_the_ID());
								
								$post_list .= '<div id="post_'.get_the_ID().'" class="post case-study three columns hover">';
								
							
								 $post_list .= hh_get_the_thumbnails('rectangle_grid', false);
								
								global $post;

								$post->post_parent ? $has_parent = 'has-parent' : $has_parent = '';
								$post_list.= '<div class="details"><a href="/case-studies?case='.$post->post_name.'" class=""><h2 class="post-title muli '.$has_parent.'">'.get_the_title().'</h2></a>';

								//get meta value for pdf upload and assign to variable.
								$pdf_file = get_field('case_study_file');
								if(!empty($pdf_file) && !empty($pdf_file['url'])){
									$post_list .= '<a href="'.$pdf_file["url"].'" target="_blank" >View the PDF</a>';//assign the meta value here
									
								}
								else {
									$post_list .=  '<a href="/case-studies?case='.$post->post_name.'" class="">Read More &rArr; </a>';
								}
								if(is_user_logged_in() && current_user_can('edit_post', $post->ID)){
									$post_list .= '<p class="muli"><a href="'.get_edit_post_link($post->ID).'" title="edit post">Edit Project</a></div>';
								}
								else{
									$post_list .= '</div>';
								}
								
								$post_list .= '</div>';

								//placeholder images
								if($post_count == $custom_query->post_count){
									if($post_count % 3 - 2 == 0){
										$post_list .= '<div class="post coming-soon hat case-study three columns hover"><img class="placeholder" width="300" height="150" src="'.get_bloginfo('stylesheet_directory').'/images/coming-soon-hat.jpg"  /><p>coming soon!</p></div>';
										
									}
									if($post_count % 3 - 1  == 0){

										$post_list .= '<div class="post coming-soon hat case-study three columns hover"><img class="placeholder" width="300" height="150" src="'.get_bloginfo('stylesheet_directory').'/images/coming-soon-hand.jpg" /><p>coming soon!</p></div>';
										$post_list .= '<div class="post coming-soon hat case-study three columns hover"><img class="placeholder" width="300" height="150" src="'.get_bloginfo('stylesheet_directory').'/images/coming-soon-hat.jpg" /><p>coming soon!</p></div>';

									}
								}
								if($post_count % 3 == 0 || $post_count == $custom_query->post_count){ $post_list .=  '</div>';}//close slide
								$post_count++;
								endwhile; 		
								else : 
				
								$post_list .= '<p> nothing for you here</p>';
				
							endif; 

						$post_list .=  '</div>';
						// Reset Post Data
						wp_reset_postdata();
						if(!is_user_logged_in()){
							set_transient('case-study-list', $post_list, 60*60*24*7);
						}
					}
					echo $post_list;			
					?>
					</div>
					
				<?php get_template_part('post_footer'); ?>
				</div>
			</div>
			<div id="slider-nav" class="hand-navigation">
						<div class="next arrow"></div>
						<div class="prev arrow"></div>
					</div>
	</div><!-- end case_studies wrapper -->
</div><!-- end case_studies section -->