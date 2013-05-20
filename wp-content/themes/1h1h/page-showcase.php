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
					<div id="portfolio-wrapper" class="wrapper">
					
			
					<?php
					
					if (have_posts() ) : while ( have_posts() ) : the_post(); 
					
					echo '<div class="portfolio-entry post" data-target="'.get_permalink().'" id="portfolio_post_'.get_the_ID().'">'.hh_get_portfolio_backgrounds("full-bg", false).'</div>';
									endwhile; 
									endif;
					?>
					
					<?php //Portfolio Loop Goes Here
					hh_portfolio_loop($content_type, 10);					
										 
										 ?>
				</div>
				<div id="portfolio-control" class="instructions-modal">
					<!--<div id="portfolio-title" > <span class="hh_text">One Hat One Hand</span> <span class="fredericka" >Portfolio</span></div>
				
					<div id="slider"></div>-->
					<div class="hand-navigation">
						<div class="next arrow"></div>
						<div class="prev arrow"></div>
					</div>
					
				</div>
				
			</div>



<?php get_footer(); ?>