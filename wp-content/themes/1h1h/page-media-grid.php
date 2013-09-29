<?php
/**
 * TEMPLATE NAME: Media Grid 
 *
 *
 * @package WordPress
 * @subpackage 1H1H
 */


get_header(); 

global $post;
wp_nav_menu( array('menu' => 'Global Menu' ));
if(have_posts()) : while(have_posts()) : the_post();
$content_type = 'post';
$category_name = 'instagrams';
$post_count = 8;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
				<div class="full-width wrapper post-type-wrapper" id="<?php echo $post->post_name; ?>">				
					<h2 class="section-title"><?php the_title(); ?></h2>
					<div  class="page-content">
						<div class="primary">
								<div class="content" role="main">
						<?php						 
						 			$args = array(
								 				'paged' => $paged,
						 						'post_type' => $content_type,
						 						'category_name' => $category_name,
						 						'posts_per_page' => $post_count,
						 						//'orderby' => 'rand',
						 						
						 					
						 			);
						 			$custom_query = new WP_Query( $args );

						 			if ( $custom_query->have_posts() ) : ?>
						 
						 			<ul class="block-grid four-up">
						
						 
						 				<?php /* Start the Loop */ ?>
						 				
						 				<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
						 				$id = get_the_ID();
						 				
						 				?>
						 				<li id="post_<?php echo $id ?>" class="instagram listing" data-target="<?php echo the_permalink(); ?>">
						 			
						 				<?php echo get_the_post_thumbnail($id,  array(200,200), array('class' => 'no-texture')); ?>
						 					
							 			</li><!--end of the post -->

						 				<?php endwhile; ?>
									 </ul><!-- end filter-target -->
								 	<div class="center post-nav"><span class="older"><?php next_posts_link( 'Older Photos', $custom_query->max_num_pages ); ?>
									</span><span class="newer"><?php echo get_previous_posts_link( 'Newer Photos' ); ?></span></div>
						 			
						 			<div class="row social-wrapper">
<ul class="block-grid two-up">
	 <li class="intro">
<h4 class="Fredericka">Find many, many more photos on  Instagram & Facebook:</h4>
						 </li>
<li class="social-link "><a class="instagram" href="http://instagram.com/onehatonehand" >Instagram</a><a class="facebook" href="https://www.facebook.com/pages/One-Hat-One-Hand/231016490378800" >Facebook</a></li>
<li class="social-link facebook"></li>
</ul>
						 			</div>


						 			<?php else : ?>
								
						 
						 				<p> nothing for you here</p>
						 
						 			<?php endif; 
						 			// Reset Post Data
						 			wp_reset_postdata();
						 			
						 
						 				?>
						 		
						 				<?php get_template_part('post_footer'); ?>
						</div>
						</div>
					</div>
						
			
				</div><!-- end media-grid wrapper -->			
			
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>