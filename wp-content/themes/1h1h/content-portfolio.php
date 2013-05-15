<?php 
//The portfolio page content
?>
<div id="portfolio" class="section">
		<div class="portfolio-wrapper wrapper">
		
		<?php
		$args = array(
		'pagename' =>'instructions',
		'post_count' => 1
		);
		$custom_query = new WP_Query($args);
		if ($custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
		
		echo '<div class="portfolio-entry post" data-target="'.get_permalink().'" id="portfolio_post_'.get_the_ID().'">'.hh_get_portfolio_backgrounds("full-bg", false).'</div>';
						endwhile; 
						endif;
		?>
		<?php //Portfolio Loop Goes Here
		hh_portfolio_loop('hh_project', 10);
				
				 ?>
	</div>
	<div id="portfolio-control" class="instructions-modal">
		<!--<div id="portfolio-title" > <span class="hh_text">One Hat One Hand</span> <span class="fredericka" >Portfolio</span></div>
	
		<div id="slider"></div>-->
		<div class="hand-navigation">
			<div class="next arrow"></div>
			<div class="prev arrow"></div>
		</div>
		<div class="instructions" ><?php 
		$page = get_page_by_path( 'instructions' );
		$content = $page->post_content;
		echo $content; 
		?></div>
	</div>
	
	
</div>