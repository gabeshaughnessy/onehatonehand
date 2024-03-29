<div id="tour" class="section">
			<div class="portfolio-wrapper cycle">		
			<?php
			$content_type = 'hh_artist';//settings for the artist grid layout
			$filter_tax = 'hh_classification'; //also for the artists grid layout
			$tour = 'shop-tour';//This is the hardcoded tour value
			
			//Collect all the posts that go in this tour into a query
			$args = array(
						'meta_key' => 'hh_tour',
						'meta_value' => $tour,
						'post_type' => array('hh_project', 'page', 'hh_service', 'hh_casestudy', 'hh_artist', 'hh_client'),
						'post_count' => 20,
						'orderby' => 'modified',
						'order' => 'DESC',
						
					
			);
			$custom_query = new WP_Query( $args );
			$tour_items= '';
			if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
			
			//if this page uses the grid template
			if(get_post_meta( $post->ID, '_wp_page_template', true )=='page-grid.php'){
				$tour_items .= '<div class="tour-entry post-grid isotope-grid post" id="tour_post_'.get_the_ID().'"><div id="artists-wrapper" class="wrapper post-type-wrapper"><div id="artists-sidebar" class="sidebar"><h2 class="section-title" id="artists-title">'.get_the_title(get_the_id()).'</h2><p class="section-logo">One Hat One Hand</p><p>filter by:<ul id="profile-filter" class="filter-menu button-group nine columns">';
								
				 $filter_menu = get_transient('filter_menu_classification');
								if($filter_menu == ''){
								$filter_menu_items = isotope_filter_menu('hh_classification');
								set_transient('filter_menu_classification', $filter_menu_items, 60*60*24*7);//one week
								$filter_menu = $filter_menu_items;
								}
								
				$tour_items .= $filter_menu; 
				
				$tour_items .= '</ul></div>';
				if ( is_user_logged_in() && current_user_can('edit_post', $post->ID) ) {
					$tour_items .='<div class="edit-post"><a href="'.get_edit_post_link( $post->ID ).'">Edit This Item</a></div>';
				}
				$tour_items .= '<div id="artists-posts" class="post-box"><div class="primary"><div class="content" role="main">';
								
				$artist_list = get_transient('artist_list');
								 if($artist_list == ''){
									$args = array(
												
														'post_type' => 'hh_artist',
														'posts_per_page' => '-1',
														'orderbyZ' => 'rand'
													
											);
								
								 
								 
								 	$artist_query = new WP_Query( $args );
								 			if ( $artist_query->have_posts() ) :
											$artist_list_items = '';
								 			$artist_list_items .= '<div class="filter-target row">';
								 
								 				/* Start the Loop */ 
								 				
								 				while ( $artist_query->have_posts() ) : $artist_query->the_post(); 
								 				$id = get_the_ID();
								 				
								 				$artist_list_items .= '<div id="post_'. $id .'" class="artist profile listing '.print_the_terms('hh_classification', ' ').'" data-target="'.get_permalink().'">';
								 			
								 				$artist_list_items .= get_the_post_thumbnail($id, 'isotope-grid', array('class' => 'no-texture')).'</div>';
								 				
								 				endwhile;
												
												$artist_list_items .= '</div>';
								 				
								 
								 			 else : 
								 
								 				$artist_list_items .= '<p> nothing for you here</p>';
								 
								 			endif; 
								 			// Reset Post Data
								 			wp_reset_postdata();
								 $artist_list = $artist_list_items;
								 set_transient('artist_list', $artist_list, 60*60*24*7);//one week
								 }
								 
						$tour_items .=  $artist_list;
						
					$tour_items .= locate_template('post_footer', true);
					$tour_items .=	'</div></div></div></div></div>';
				
			}//end page grid template 

			//if the page uses the full-width template:
			else if(get_post_meta( $post->ID, '_wp_page_template', true )=='page-full-width.php'){
				$tour_items .='
					<div class="tour-entry post full-width" data-target="'.get_permalink().'" id="tour_post_'.get_the_ID().'"><div class=" ">'.get_the_content().'</div>';
					if ( is_user_logged_in() && current_user_can('edit_post', $post->ID) ) {
						$tour_items .= '<div class="edit-post"><a href="'.get_edit_post_link( get_the_ID() ).'">Edit This Item</a></div>';
					}
					$tour_items .= '</div>';
			}//end full-width template

			//if the page uses the full-width with title template:
			else if(get_post_meta( $post->ID, '_wp_page_template', true )=='page-full-width-title.php'){
				$tour_items .='
					<div class="tour-entry full-width wrapper" data-target="'.get_permalink().'" id="tour_post_'.get_the_ID().'"><h2 class="section-title">'.get_the_title().'</h2><div class=" primary"><div class="content">'.get_the_content().'</div></div>';
					if ( is_user_logged_in() && current_user_can('edit_post', $post->ID) ) {
						$tour_items .= '<div class="edit-post"><a href="'.get_edit_post_link( get_the_ID() ).'">Edit This Item</a></div>';
					}
					$tour_items .= '</div>';
			}//end full-wdith with title template
			
			//if the page uses the media-grid:
			else if(get_post_meta( $post->ID, '_wp_page_template', true )=='page-media-grid.php'){
				$tour_items .='<div class="tour-entry media full-width wrapper" data-target="'.get_permalink().'" id="tour_post_'.get_the_ID().'"><h2 class="section-title">'.get_the_title().'</h2><div class=" primary"><div class="content">';
				
				$photo_args = array(
 						//'post_type' => 'post',
 						//'category_name' => 'instagrams',
 						'posts_per_page' => 8,
 						//'orderby' => 'rand',			
				 			);
	 			$media_query = new WP_Query( $photo_args );
					$tour_items .= '<ul class="block-grid four-up">';

		 			if ( $media_query->have_posts() ) : while ( $media_query->have_posts() ) : $media_query->the_post(); 
	 				$id = get_the_ID();
					$tour_items .= '<li id="post_'.$id.'" class="instagram listing" data-target="'.get_permalink().'">';
					$tour_items .= '<a href="'.wp_get_attachment_url( get_post_thumbnail_id($id) ).'">';
					$tour_items .= get_the_post_thumbnail($id,  array(200,200), array('class' => 'no-texture'));
					$tour_items .= '</a>';
					$tour_items .= '</li>';
					 endwhile;
					 endif;
					wp_reset_postdata();
					$tour_itmes .= '</ul>';
					$tour_items .= '<div class="row social-wrapper"><ul class="block-grid two-up">';
					$tour_items .= '<li class="intro"><h4 class="Fredericka">Find many, many more photos on  Instagram & Facebook:</h4></li>';
					$tour_items .= '<li class="social-link "><a class="instagram" href="http://instagram.com/onehatonehand" >Instagram</a><a class="facebook" href="https://www.facebook.com/pages/One-Hat-One-Hand/231016490378800" >Facebook</a></li>';
					$tour_items .= '<li class="social-link facebook"></li>';
					$tour_items .= '</ul></div>';
					$tour_items .= '</div></div>';
					if ( is_user_logged_in() && current_user_can('edit_post', $post->ID) ) {
						$tour_items .= '<div class="edit-post"><a href="'.get_edit_post_link( get_the_ID() ).'">Edit This Item</a></div>';
					}
					
					$tour_items .= '</div>';
			}//end media-grid with title template

			//if the page uses the edge-animation template:
			else if(get_post_meta( $post->ID, '_wp_page_template', true )=='page-animation.php'){
				$tour_items .='<div class="tour-entry media edge-animation wrapper" data-target="'.get_permalink().'" id="tour_post_'.get_the_ID().'"><div class=" primary"><div class="content">';
				$tour_items .= get_the_content($post->ID);
					$tour_items .= '</div></div>';
					if ( is_user_logged_in() && current_user_can('edit_post', $post->ID) ) {
						$tour_items .= '<div class="edit-post"><a href="'.get_edit_post_link( get_the_ID() ).'">Edit This Item</a></div>';
					}
					
					$tour_items .= '</div>';
			}//end edge-animation template

			//all other posts/pages/projects/etc use this output:
			else{
			
			$tour_items .='<div class="tour-entry post" data-target="'.get_permalink().'" id="tour_post_'.get_the_ID().'">';
			if(get_the_content() != ''){//only show the content box if the post has content in the editor
				$tour_items .= '<div class="post-content ">'.get_the_content().'</div>';
			}
			
			if ( is_user_logged_in() && current_user_can('edit_post', $post->ID) ) {
				$tour_items .='<div class="edit-post"><a href="'.get_edit_post_link( get_the_ID() ).'">Edit This Item</a></div>';
			}
			$tour_items .= hh_get_portfolio_backgrounds("full-bg", false).'</div>';
			}
			
							endwhile; 
							else : 
							$tour_items .='<p> No Items to display </p>';
							endif; 
						// Reset Post Data
						wp_reset_postdata();
						
			echo apply_filters('the_content', $tour_items);
			
								 
								 ?>
		</div>
		<div id="tour-control" class="instructions-modal">
			<!--<div id="portfolio-title" > <span class="hh_text">One Hat One Hand</span> <span class="fredericka" >Portfolio</span></div>
		
			<div id="slider"></div>-->
			<div class="hand-navigation">
				<div  class="next arrow"></div>
				<div  class=" prev arrow"></div>
			</div>
			
		</div>
		
	</div>