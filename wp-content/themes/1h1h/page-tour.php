<?php
/**
 * Template Name: Tour
 *
 *
 *
 * @package WordPress
 * @subpackage 1H1H
 */

get_header(); 
wp_nav_menu( array('menu' => 'Global Menu' ));
global $post;
$content_type = get_post_meta($post->ID, 'hh_content_post_type', true);
$filter_tax = get_post_meta($post->ID, 'hh_filter_taxonomy', true);
$tour = get_post_meta($post->ID, 'hh_tour', true);
?>

			<div id="portfolio" class="section">
					<div id="portfolio-wrapper" class="wrapper">
					
					
					<?php //Portfolio Loop Goes Here
		
					$args = array(
								'meta_key' => 'hh_tour',
								'meta_value' => $tour,
								'post_type' => array('hh_project', 'page', 'hh_service', 'hh_casestudy', 'hh_artist', 'hh_client', 'post'),
								'post_count' => 20,
								  'orderby' => 'modified',
								  'order' => 'ASC',
							
					);
					$custom_query = new WP_Query( $args );
					$tour_items= '';
					if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
					
					if(get_the_title() == 'Artists'){
					
					$tour_items .= '<div class="tour-entry post" id="tour_post_'.get_the_ID().'"><div id="artists-wrapper" class="wrapper post-type-wrapper"><div id="artists-sidebar" class="sidebar"><h2 class="section-title" id="artists-title">artists</h2><p class="section-logo">One Hat One Hand</p><p>filter by:<ul id="profile-filter" class="filter-menu button-group nine columns">';
									
					 $filter_menu = get_transient('filter_menu_classification');
									if($filter_menu == ''){
									$filter_menu_items = isotope_filter_menu('hh_classification');
									set_transient('filter_menu_classification', $filter_menu_items, 60*60*24*7);//one week
									}
									
					$tour_items .= $filter_menu; 
					
					$tour_items .= '</ul></div><div id="artists-posts" class="post-box"><div class="primary"><div class="content" role="main">';
									
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
									 				
									 				$artist_list_items .= '<div id="post_'. $id .'" class="artist profile listing'.print_the_terms('hh_classification', ' ').'" data-target="'.get_permalink().'">';
									 			
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
					
				}
					else{
					
					$tour_items .='<div class="tour-entry post" data-target="'.get_permalink().'" id="tour_post_'.get_the_ID().'"><div class="post-content ">'.get_the_content().'</div>'.hh_get_portfolio_backgrounds("full-bg", false).'</div>';
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
				<div id="portfolio-control" class="instructions-modal">
					<!--<div id="portfolio-title" > <span class="hh_text">One Hat One Hand</span> <span class="fredericka" >Portfolio</span></div>
				
					<div id="slider"></div>-->
					<div id="hand-navigation">
						<div id="next-hand" class="arrow"></div>
						<div id="prev-hand" class="arrow"></div>
					</div>
					
				</div>
				
			</div>



<?php get_footer(); ?>