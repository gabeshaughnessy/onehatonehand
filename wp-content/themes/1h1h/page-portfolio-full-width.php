<?php
/**
 * Template Name: Portfolio (fullwidth)
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

?>

			<div id="portfolio" class="section">
					<div id="portfolio-wrapper" class="cycle">
					
			
					
					<?php 
					//Portfolio Loop Goes Here
					$group = $_GET['group'];
					if($group != ''){
					$args = array(	
						'post_type' => 'hh_project',
						'posts_per_page' => -1,
						'tax_query' => array(
							array(
								'taxonomy' => 'hh_portfolio',
								'field' => 'slug',
								'terms' => $group
							)
						)
					);					
						$group_name = get_term_by('slug', $group, 'hh_portfolio');	
						error_log(print_r($group_name, true));
						$group_name = $group_name->name;
						error_log($group_name);
					$custom_query = new WP_Query( $args );
						if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
							if (has_post_thumbnail()) {
								//save the image markup to a global javascript variable.

								$img = get_the_post_thumbnail();
								$img_id = get_post_thumbnail_id();
								$img_src = wp_get_attachment_image_src($img_id, $thumbnail_size );
								$thumbnail = htmlentities('<div class="portfolio_bg"><img src="'.urlencode($img_src[0]).'" width="100%" height="auto" alt=" '.get_the_title().'"/></div>');

								
								echo '<div class="portfolio-entry post" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'"><div class="portfolio-group">'.$group_slug.'</div>'.hh_get_portfolio_backgrounds("full-bg", false).'</div>';
								
							}
							elseif(!has_post_thumbnail()){
								if($current_post_index <= $posts_to_show){
									$portfolio_list .='<div class="portfolio-entry post" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'"><div class="portfolio_bg"><img src="'.get_bloginfo('stylesheet_directory').'/images/paper_bg2.png" width="100%" height="auto" alt=" '.get_the_title().'"/><div class="portfolio-content centered">'.wpautop(get_the_content()).'</div></div></div>';
								}
							}
							endwhile; 

							endif; 
					}
										 ?>
				</div>
				<div id="portfolio-control" class="instructions-modal">
					<!--<div id="portfolio-title" > <span class="hh_text">One Hat One Hand</span> <span class="fredericka" >Portfolio</span></div>
				
					<div id="slider"></div>-->
					<div class="hand-navigation">
						<div class="next arrow"></div>
						<h2 class="fredericka"><?php echo $group_name; ?></h2>
						<div class="prev arrow"></div>
					</div>
					
				</div>
				
			</div>



<?php get_footer(); ?>