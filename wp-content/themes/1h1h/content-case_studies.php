<?php 
//The case studies page content
?>
<div id="case-studies" class="section">
	<div id="case_studies-wrapper" class="wrapper post-type-wrapper">
			<h2 class="fredericka centered">Case Studies</h2>
			<div id="case_studies-posts" class="">
				<div class="primary">
						<div class="content" role="main">
				<?php
				$post_list = get_transient('case-study-list');
				if($post_list == false){
				$args = array(
								
										'post_type' => 'hh_case_study',
										'post_count' => 6,
										'orderby' => 'menu_order  parent',
										'order' => 'ASC'
									
							);
							$custom_query = new WP_Query( $args );
							if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
								
								$meta_values = hh_get_meta_values(get_the_ID());
								
								$post_list .= '<div id="post_'.get_the_ID().'" class="post case-study three columns hover">';
								
							
								 $post_list .= hh_get_the_thumbnails('rectangle_grid', false);
								
								global $post;
								$post->post_parent ? $has_parent = 'has-parent' : $has_parent = '';
								
								$post_list.= '<div class="details"><a href="/case-studies?case='.$post->post_name.'" class=""><h2 class="post-title muli '.$has_parent.'">'.get_the_title().'</h2></a>';
								$post_list .= '<a href="/case-studies?case='.$post->post_name.'" class="">Read More &rArr; </a>';
								if(is_user_logged_in() && current_user_can('edit_post', $post->ID)){
									$post_list .= '<p class="muli"><a href="'.get_edit_post_link($post->ID).'" title="edit post">Edit Case Study</a></div></div>';
								}
								else{
									$post_list .= '</div>';
								}
								endwhile; 		
								else : 
				
								$post_list .= '<p> nothing for you here</p>';
				
							endif; 
							// Reset Post Data
							wp_reset_postdata();
				
					set_transient('case-study-list', $post_list, 60*60*24*7);
				}
				echo $post_list;
				
				?>
				</div>
				<?php get_template_part('post_footer'); ?>
				</div>
			</div>
			

	</div><!-- end case_studies wrapper -->
</div><!-- end case_studies section -->