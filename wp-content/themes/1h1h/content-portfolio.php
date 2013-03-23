<?php 
//The portfolio page content
?>
<div id="portfolio" class="section">
		<div id="portfolio-wrapper" class="wrapper">
		
		
		<?php //Portfolio Loop Goes Here
		hh_portfolio_loop('hh_project', 10);
		/* +++++ T H E   P O R T F O L I O   L O O P ++++++ */
		//////////////////////////////////////////////////////
		function hh_portfolio_loop($hhpost_type, $hhcount){ 
		$portfolio_list = get_transient('portfolio_items');
		if($portfolio_list == ''){
		
		$args = array(
			
					'post_type' => $hhpost_type,
					'post_count' => $hhcount
				
		);
		$custom_query = new WP_Query( $args );
		if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
		
		$portfolio_list .='<div class="portfolio-entry post" data-target="'.get_permalink().'" id="portfolio_post_'.get_the_ID().'">'.hh_get_portfolio_backgrounds("full-bg", false).'</div>';
						endwhile; 
						else : 
						$portfolio_list .='<p> No Items to display </p>';
						endif; 
					// Reset Post Data
					wp_reset_postdata();
					
		
		set_transient('portfolio_items', $portfolio_list, 60*60*24*7);
		}
		echo $portfolio_list;
				
									
		}
		//End Portfolio_Loop()
		
				 ?>
	</div>
	<div id="portfolio-control">
		<!--<div id="portfolio-title" > <span class="hh_text">One Hat One Hand</span> <span class="fredericka" >Portfolio</span></div>
	
		<div id="slider"></div>-->
		<div id="hand-navigation">
			<div id="next-hand" class="arrow"></div>
			<div id="prev-hand" class="arrow"></div>
		</div>
		<div class="instructions" ><?php 
		$page = get_page_by_path( 'instructions' );
		$content = $page->post_content;
		echo $content; 
		?></div>
	</div>
	
	
</div>