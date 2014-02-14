<?php 
//The portfolio page content
?>
<div id="portfolio" class="section">
	<script type="text/javascript">
		var portfolioItems = Array();
	</script>
	<?php 
		$portfolio_image_srcs = array();
	?>
		<div class="portfolio-wrapper cycle">
		
			<?php //Portfolio Loop Goes Here
				hh_portfolio_loop('hh_project', 10);
			
			 ?>
	</div>
	<script>
	<?php 
	global $portfolio_image_srcs;
	if(is_array($portfolio_image_srcs)){
	foreach($portfolio_image_srcs as $src) {
			echo 'portfolioItems.push("'.$src.'");';
		}
	}
	?>
	</script>
	<div id="portfolio-control" class="instructions-modal">
		<!--<div id="portfolio-title" > <span class="hh_text">One Hat One Hand</span> <span class="fredericka" >Portfolio</span></div>
	
		<div id="slider"></div>-->
		<div class="hand-navigation">
			<div class="next arrow"></div>
			<h2 class="fredericka">Portfolio</h2>
			<div class="prev arrow"></div>
		</div>
	</div>
	
	
</div>