<?php
/**
 * Template Name: Edge Animation
 *
 *
 *
 * @package WordPress
 * @subpackage 1H1H
 */

get_header(); 
wp_nav_menu( array('menu' => 'Global Menu' ));
?>
<?php 
//The contact page content
?>
<div  class="section edge-animation" id="<?php echo $post->post_name; ?>">
	<div  class="wrapper edge-animation">
		<?php 
		if(have_posts()) : while(have_posts()) : the_post();
		the_content(); 
		endwhile;
		endif;
		?>
					
	</div><!-- end contact-wrapper -->
</div><!-- end contact section -->


<?php get_footer(); ?>