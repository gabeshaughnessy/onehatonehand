<?php
/**
 * Template Name: Case Studies
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

/* +++++ T H E  CASE STUDY L O O P ++++++ */
//////////////////////////////////////////////////////
function hh_case_study_loop($hhpost_type, $hhcount){ 
$case_study_list = '';//get_transient('case_study_items');
if($case_study_list == ''){

$args = array(
	
			'post_type' => $hhpost_type,
			'post_count' => $hhcount
		
);
$custom_query = new WP_Query( $args );
global $post;
if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 


if (has_post_thumbnail()) {
$case_study_list .='<div class="portfolio-entry post '.$post->post_name.'" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'">'.hh_get_portfolio_backgrounds("full-bg", false).'</div>'.wpautop(get_the_content());
}
elseif(!has_post_thumbnail()){
$case_study_list .='<div class="portfolio-entry post" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'"><div class="portfolio_bg"><img src="'.get_bloginfo('stylesheet_directory').'/images/paper_bg2.png" width="100%" height="auto" alt=" '.get_the_title().'"/><div class="portfolio-content centered">'.apply_filter('the_content',get_the_content()).'</div></div></div>';
}

				endwhile; 
				else : 
				$case_study_list .='<p> No Items to display </p>';
				endif; 
			// Reset Post Data
			wp_reset_postdata();
			

set_transient('case_study_items', $case_study_list, 60*60*24*7);
}
echo $case_study_list;
		
							
}
//End Portfolio_Loop()


?>

			<div id="projects" class="section">
					<div id="project-wrapper" class="wrapper cycle">
					
			
					<?php
					
					if (have_posts() ) : while ( have_posts() ) : the_post(); 
					
					if (has_post_thumbnail()) {
					echo '<div class="first-slide portfolio-entry post" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'">'.hh_get_portfolio_backgrounds("full-bg", false).'</div>'.wpautop(get_the_content());
					}
					elseif(!has_post_thumbnail()){
					echo '<div class="first-slide portfolio-entry post" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'"><div class="portfolio_bg"><img src="'.get_bloginfo('stylesheet_directory').'/images/paper_bg2.png" width="100%" height="auto" alt=" '.$post->post_name.'"/></div><div class="portoflio-content centered">'.wpautop(get_the_content()).'</div></div>';
					}
					
									endwhile; 
									endif;
					?>
					
					<?php //Case Study Loop Goes Here
					hh_case_study_loop($content_type, 10);					
										 
										 ?>
				</div>
				<div id="project-control" class="instructions-modal">
					<!--<div id="portfolio-title" > <span class="hh_text">One Hat One Hand</span> <span class="fredericka" >Portfolio</span></div>
				
					<div id="slider"></div>-->
					<div class="hand-navigation">
						<div class="next arrow"></div>
						<div class="prev arrow"></div>
					</div>
					
				</div>
				
			</div>



<?php get_footer(); ?>