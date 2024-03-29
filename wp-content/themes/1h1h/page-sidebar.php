<?php
/**
 * Template Name: Sidebar
 *
 *
 *
 * @package WordPress
 * @subpackage 1H1H
 */

get_header(); 
wp_nav_menu( array('menu' => 'Global Menu' ));
?>
			<div class="section" id="<?php echo $post->post_name; ?>">
		<div class="wrapper post-type-wrapper">
			<?php if ( have_posts() ) : ?>

		

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
		
									<div class="sidebar">
									<h2 class="section-title"><?php the_title(); ?></h2>
									<p class="section-logo">One Hat One Hand</p>
									
									
									</div>
								<div  class="post-box">
									<div class="primary">
											<div class="content" role="main">
											<?php
										the_content();
											?>
										</div>
									</div>
								</div>
								
								
					
						</div><!-- end case_studies wrapper -->
					</div><!-- end case_studies section -->
				<?php endwhile; ?>

				

			<?php else : ?>
			<?php endif; ?>

<?php get_footer(); ?>