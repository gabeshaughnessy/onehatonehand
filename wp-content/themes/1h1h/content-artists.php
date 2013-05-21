<?php 
//The artists page content
?>
<div id="artists" class="section">
	<div id="artists-wrapper" class="wrapper post-type-wrapper">
			<div id="artists-sidebar" class="sidebar">
				<h2 class="section-title" id="artists-title">artists</h2>
				<p class="section-logo">One Hat One Hand</p>
				<p>filter by:
				<ul id="profile-filter" class="filter-menu button-group nine columns">
				<?php 
				$filter_menu = get_transient('filter_menu_classification');
				if($filter_menu == ''){
				$filter_menu_items = isotope_filter_menu('hh_classification');
				set_transient('filter_menu_classification', $filter_menu_items, 60*60*24*7);//one week
				}
				
				echo $filter_menu; 
				?>
				</ul>
				</div>	
			<div id="artists-posts" class="post-box">
				<div class="primary">
						<div class="content" role="main">
				<?php
				//need to do the first page loop here, getting the content from a page called by id
				
				 $artist_list = get_transient('artist_list');
				 if($artist_list == ''){
					$args = array(
								
										'post_type' => 'hh_artist',
										'posts_per_page' => '-1',
										'orderbyZ' => 'rand'
									
							);
				
				 
				 
				 	$custom_query = new WP_Query( $args );
				 			if ( $custom_query->have_posts() ) :
							$artist_list_items = '';
				 			$artist_list_items .= '<div class="filter-target row">';
				 
				 				/* Start the Loop */ 
				 				
				 				while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
				 				$id = get_the_ID();
				 				
				 				$artist_list_items .= '<div id="post_'. $id .'" class="artist profile listing '.print_the_terms('hh_classification', ' ').'" data-target="'.get_permalink().'">';
				 			
				 				$artist_list_items .= get_the_post_thumbnail($id, 'isotope-grid', array('class' => 'no-texture')).'</div>';
				 				
				 				endwhile;
								
								$artist_list_items .= '</div>';
				 				
				 
				 			 else : 
				 
				 				$artist_list_items .= '<p> nothing for you here</p>';
				 
				 			endif; 
				 			// Reset Post Data
				 			wp_reset_postdata();
				 $artist_list = $artist_list_items;
				 set_transient('artist_list', $artist_list, 60*60*24*7);//one week
				 }
				 
				 echo $artist_list;				 			
				 
				 				?>
				 				<?php get_template_part('post_footer'); ?>
				</div>
				</div>
			</div>
			

	</div><!-- end artists wrapper -->
</div><!-- end artists section -->