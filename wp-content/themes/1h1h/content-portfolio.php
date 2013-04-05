<?php 
//The portfolio page content
?>
<div id="portfolio" class="section">
		<div id="portfolio-wrapper" class="wrapper">
		
		
		<?php //Portfolio Loop Goes Here
		hh_portfolio_loop('hh_project', 10);
				
				 ?>
	</div>
	<div id="portfolio-control" class="instructions-modal">
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