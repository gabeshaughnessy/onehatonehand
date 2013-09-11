<?php
/**
 * Template Name: Showcase
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
					
			
					
					<?php //Portfolio Loop Goes Here
					hh_portfolio_loop($content_type, 10);					
										 
										 ?>
				</div>
				<div id="portfolio-control" class="instructions-modal">
					<!--<div id="portfolio-title" > <span class="hh_text">One Hat One Hand</span> <span class="fredericka" >Portfolio</span></div>
				
					<div id="slider"></div>-->
					<div class="hand-navigation">
						<div class="next arrow"></div>
						<h2 class="fredericka"><?php the_title(); ?></h2>
						<div class="prev arrow"></div>
					</div>
					
				</div>
				
			</div>



<?php get_footer(); ?>