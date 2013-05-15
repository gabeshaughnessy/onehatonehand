<?php
/**
 * Template Name: Full Width Title
  *
 *
 *
 * @package WordPress
 * @subpackage 1H1H
 */

get_header(); 
wp_nav_menu( array('menu' => 'Global Menu' ));
?>
		<div class="full-width wrapper post-type-wrapper">
			<?php if ( have_posts() ) : ?>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
		
									
								<h2 class="section-title"><?php the_title(); ?></h2>
								<div  class="page-content">
									<div class="primary">
											<div class="content" role="main">
											<?php
										the_content();
											?>
										</div>
									</div>
								</div>
								
								
					
						</div>

				<?php endwhile; ?>

				

			<?php else : ?>
			<?php endif; ?>

<?php get_footer(); ?>