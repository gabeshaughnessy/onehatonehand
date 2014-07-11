<?php 
//The portfolio page content

?>
<div id="portfolio" class="section">
	<script type="text/javascript">
		var portfolioItems = Array();
		function cycleNav(index){
			jQuery("#portfolio .portfolio-wrapper").cycle(index); 
		}
	</script>
	<?php 
		$portfolio_image_srcs = array();
		$portfolio_groups = array(); //array of portfolio group terms
	?>
	<div class="portfolio-wrapper cycle">
		
			<?php /* +++++ T H E   P O R T F O L I O   L O O P ++++++ */
				//////////////////////////////////////////////////////

//INTERNAL PAGE
if(!is_front_page()){
	global $post;
	$content_type = get_post_meta($post->ID, 'hh_content_post_type', true);
	$filter_tax = get_post_meta($post->ID, 'hh_filter_taxonomy', true);

						$group = $_GET['group'];
						if($group == ''){
							$terms = get_terms('hh_portfolio');
							$group = array();
							foreach ($terms as $term) {
								if(isset($term->slug)) :
									$group[] = $term->slug;
								endif;
							}
							$group_name = 'Portfolio';
						}
						
						$args = array(	
							'post_type' => 'hh_project',
							'posts_per_page' => -1,
							'tax_query' => array(
								array(
									'taxonomy' => 'hh_portfolio',
									'field' => 'slug',
									'terms' => $group
								)
							)
						);	
						if(!isset($group_name)){
							$group_name = get_term_by('slug', $group, 'hh_portfolio');	
							$group_name = $group_name->name;
							}
							
						$custom_query = new WP_Query( $args );
						
						if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
							if (has_post_thumbnail()) {
								//save the image markup to a global javascript variable.

								$img = get_the_post_thumbnail();
								$img_id = get_post_thumbnail_id();
								$img_src = wp_get_attachment_image_src($img_id, 'feature_slide' );
								$thumbnail = htmlentities('<div class="portfolio_bg"><img src="'.urlencode($img_src[0]).'" width="100%" height="auto" alt=" '.get_the_title().'"/></div>');

								
								echo '<div class="portfolio-entry post" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'"><div class="portfolio-content large-8 columns centered"><div class="portfolio-group">'.$group_slug.'</div>'.hh_get_portfolio_backgrounds("full-bg", false).'</div></div>';
								
							}
							elseif(!has_post_thumbnail()){
								if($current_post_index <= $posts_to_show){
									$portfolio_list .='<div class="portfolio-entry post" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'"><div class="portfolio_bg"><img src="'.get_bloginfo('stylesheet_directory').'/images/paper_bg2.png" width="100%" height="auto" alt=" '.get_the_title().'"/><div class="portfolio-content centered">'.wpautop(get_the_content()).'</div></div></div>';
								}
							}
							endwhile; 

							endif; 
							
	}//not the front page
	
//FRONT PAGE - part of the long scroll
	else{
		$hhpost_type = 'hh_project';
		$current_post_index = 1;
		//global $portfolio_image_srcs;
		if($portfolio_list == ''){

		$args = array(
			
					'post_type' => $hhpost_type,
					'post_count' => -1,
					'posts_per_page' => 100
		);
		
		$custom_query = new WP_Query( $args );

		
		
		
		
		if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
		//query to get the portfolio group from all the posts

			$portfolio_group = get_the_terms( get_the_ID(), 'hh_portfolio');
			if(!empty($portfolio_group)){
				foreach ($portfolio_group as $group) {
				 	$portfolio_groups[] = $group->term_id;
				 } 
			}
		endwhile;
		endif;
		

		$portfolio_groups = array_unique($portfolio_groups); //remove the dupes
		

		//Now we have each portfolio group and we can query them and print posts from them.
        
        //First slide
		$portfolio_list .='<div class="portfolio-entry post index" data-target="" id="pre_portfolio_post">'; 	
			$portfolio_list .='<div class="row">';
				$portfolio_list .='<div class="portfolio-content large-4 columns centered"><ul class=" index-list inline-list">';
					$i = 1;
					foreach ($portfolio_groups as $group) { 
						$group_meta = get_term_by('id', $group, 'hh_portfolio');
						$group_name = $group_meta->name;
						$group_slug = $group_meta->slug;
					$portfolio_list .='<li><a onClick="cycleNav('.$i.')" "href="/portfolio-groups?group='.$group_slug.'" title="Explore" class="group-link" target="_blank">';	
						$portfolio_list .= '<p>'.$group_name.'</p>';	
					$portfolio_list .='</a></li>';
					$i++;
					}

				$portfolio_list .='</ul></div>';

			$portfolio_list .='</div>';
			$portfolio_list .= '<div class="portfolio_bg"><img src="'.get_bloginfo('stylesheet_directory').'/images/paper_bg2.png" width="100%" height="auto" alt=" Index"/></div>';

		$portfolio_list .='</div>';

		foreach ($portfolio_groups as $group) { //loop through each group and show one post
			$args = array(
			
					'post_type' => $hhpost_type,
					'posts_per_page' => 5,
					'tax_query' => array(
						array(
							'taxonomy' => 'hh_portfolio',
							'terms' => $group
						)
					)
			);
			$count = 0;
			$group_slug = get_term_by('id', $group, 'hh_portfolio');
			$group_name = $group_slug->name;
			$group_slug = $group_slug->slug;
			
			$group_query = new WP_Query( $args );
			if ( $group_query->have_posts() ) :
				$portfolio_list .='<div class="portfolio-entry post" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'">'; 
			$portfolio_list .='<div class="portfolio-group">'.$group_name.'</div>';
				while ( $group_query->have_posts() ) : $group_query->the_post(); 
				if (has_post_thumbnail()) {
					//save the image markup to a global javascript variable.
					$img_sizes = array("full-size", 'thumbnail');
					$img = get_the_post_thumbnail();
					$img_id = get_post_thumbnail_id();
					$img_src = wp_get_attachment_image_src($img_id, ($count == 0 ? 'feature_slide' : 'post-thumbnail') );

					
					
					$thumbnail = htmlentities('<div class="portfolio_bg"><img src="'.urlencode($img_src[0]).'" width="100%" height="auto" alt=" '.get_the_title().'"/></div>');

					

						if($count == 0){
						$portfolio_list .='<div class="row"><div class="portfolio-content large-8 columns centered">';
						$portfolio_list .='<a href="/portfolio-groups?group='.$group_slug.'" title="View Portfolio" target="_blank">';
							
						$portfolio_list .= '<div class="portfolio_bg"><img src="'.$img_src[0].'" width="100%" height="auto" alt=" '.get_the_title().'"/></div>';

						$portfolio_list .='</a>';
						$portfolio_list .='</div>';
						$portfolio_list .='</div>';
						$portfolio_list .='<div class="row centered"><div class="thumbnails">';
							}
						
						else {
						$portfolio_list .='<div class="portfolio-content large-3 hide-for-small thumbnail columns">';
						$portfolio_list .='<a href="/portfolio-groups?group='.$group_slug.'" title="View Portfolio" target="_blank">';
							
						$portfolio_list .= '<div class="portfolio_bg"><img src="'.$img_src[0].'" width="100%" height="auto" alt=" '.get_the_title().'"/></div>';

						$portfolio_list .='</a>';
						$portfolio_list .='</div>';
					
							}	
							
						


					}
					
					
				
				elseif(!has_post_thumbnail()){ //must be a plain text post here
					
						$portfolio_list .='<div class="portfolio_bg">';
						$portfolio_list .='<img src="'.get_bloginfo('stylesheet_directory').'/images/paper_bg2.png" width="100%" height="auto" alt=" '.get_the_title().'"/>';
						$portfolio_list .='<div class="portfolio-content centered">'.wpautop(get_the_content()).'</div>';
						$portfolio_list .='</div>';
					
				}
				
				$count++;

				endwhile; 
				$portfolio_list .='</div>';	
				$portfolio_list .='</div>';	
				$portfolio_list .='</div>';			
				else : 
				$portfolio_list .='<p> No Items to display </p>';	

				endif;

			// Reset Post Data
			wp_reset_postdata();
				}//end loop through portfolio groups

				//set_transient('portfolio_items', $portfolio_list, 60*60*24*7);
				}
				
				echo $portfolio_list;
	}

 ?>
	</div>
	<script>
	<?php 
	//save the image src array for the javascripts.
	global $portfolio_image_srcs;
	if(is_array($portfolio_image_srcs)){
	foreach($portfolio_image_srcs as $src) {
			echo 'portfolioItems.push("'.$src.'");';
		}
	}
	?>
	</script>
	
	<div id="portfolio-control" class="instructions-modal">
<!-- 		<div id="portfolio-title" > <span class="hh_text">One Hat One Hand</span> <span class="fredericka" >Portfolio</span></div>
 -->	
		<div id="slider"></div>	
		<div class="hand-navigation">
			<div class="next arrow"></div>
			<h2 class="fredericka"><?php echo (!is_front_page() ? $group_name : 'Portfolio');?></h2>
			<div class="prev arrow"></div>
		</div>
	</div>
	
	
</div>