<?php 
//Rebrand the dashboard
//require_once('rebrand.php');

//Add Theme Options


/*
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */
if ( !function_exists( 'of_get_option' ) ) {
function of_get_option($name, $default = false) {
    $optionsframework_settings = get_option('optionsframework');
    // Gets the unique option id
    $option_name = $optionsframework_settings['id'];
    if ( get_option($option_name) ) {
        $options = get_option($option_name);
    }
    if ( isset($options[$name]) ) {
        return $options[$name];
    } else {
        return $default;
    }
}
}
//require_once('hh_options.php');
//End Theme Options

/* DEFINE ENVIRONMENT GLOBAL */
$host = $_SERVER['HTTP_HOST'];
if (stristr($host, 'com') == FALSE){
    define('HH_ENVIRONMENT', "development");
    }
    elseif ((stristr($host, 'staging') !== FALSE)){
        define('HH_ENVIRONMENT', "staging");
        }
        else{
            define('HH_ENVIRONMENT', "production");
            } 
/* Plugins Activiation */
/* ################################################################################# */

    if (HH_ENVIRONMENT != 'development') {
       define('ACF_LITE', true);
    }

    /* Advanced Custome Fields */
    require_once('functions/plugins/advanced-custom-fields/acf.php');
    /* ACF Add-ons */
    //include_once( 'functions/plugins/advanced-custom-fields/add-ons/acf-repeater/acf-repeater.php' );
    //include_once( 'functions/plugins/advanced-custom-fields/add-ons/acf-flexible-content/acf-flexible-content.php' );
    //include_once( 'functions/plugins/advanced-custom-fields/add-ons/acf-options-page/acf-options-page.php' ); 
    //include_once( 'functions/plugins/advanced-custom-fields/add-ons/acf-field-date-time-picker/acf-date_time_picker.php' ); 

    if ( HH_ENVIRONMENT != 'development' ) {
        // If this is staging or production
            // load ACF declarations
            require_once('functions/plugins/advanced-custom-fields/register_fields.php'); 
        }
        else{            
            add_action( 'admin_menu', 'HH_acf_menu', 9 );
            function HH_acf_menu(){
                add_submenu_page( 'edit.php?post_type=acf', __('Custom Fields','acf'), __('Custom Fields','acf'), 'manage_options', 'edit.php?post_type=acf');
                add_submenu_page( 'edit.php?post_type=acf', __('Import ACF','acf'), __('Import ACF','acf'), 'manage_options', 'admin.php?import=wordpress');

                }

    }



//Thumbnail columns
require_once('thumb_column.php');

//add support for featured images and set thumbnail sizes
require_once('image_support.php');

//add POST FORMAT SUPPORT
add_theme_support( 'post-formats', array( 'image', 'link', 'video' ) );

//add excerpts to the pages:
add_action( 'init', 'add_excerpts_to_pages' );
function add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

//Register a Main Menu
register_nav_menu( "homepage", "The fixed menu at the top of pages, uses relative links to scroll through the page." );
register_nav_menu( "global", "The menu that shows up by default, with links to other pages" );

//add javascript to frontend

function my_scripts_method() {
if( !is_admin()){
wp_deregister_script('jquery');
	wp_enqueue_script('jquery',
		get_template_directory_uri() . '/js/jquery-1.7.2.min.js',
		array() );
		}
    wp_enqueue_script('cycle',
		get_template_directory_uri() . '/js/cycle.js',
		array('jquery') );
	wp_enqueue_script('jquery-ui',
		get_template_directory_uri() . '/js/jquery-ui-1.8.21.custom.min.js',
		array('jquery') );
	wp_enqueue_script('isotope',
		get_template_directory_uri() . '/js/isotope.min.js',
		array('jquery') );
		/*wp_enqueue_script('jquery_ui', "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js", array('jquery'));	  
		
	wp_enqueue_script('swipe',
		get_template_directory_uri() . '/js/jquery.swipe.js',
		array('jquery', 'jquery_ui') );	//swipe events
		*/
	wp_enqueue_script('scrollspy',
		get_template_directory_uri() . '/js/scrollspy.js',
		array('jquery') ); 	
	wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.js', array('jquery') );
	
	wp_enqueue_script('touch-punch',
		get_template_directory_uri() . '/js/jQuery.touchPunch.min.js',
		array('jquery'), false);	

	wp_enqueue_script('touchwipe',get_template_directory_uri() . '/js/jquery.touchwipe.min.js',array('jquery'));	
	//mousewheel detection
	wp_enqueue_script('mousewheel',
		get_template_directory_uri() . '/js/jquery.mousewheel.js',
		array('jquery') ); 
	wp_enqueue_script('scroll-to',
		get_template_directory_uri() . '/js/jquery.scrollTo-1.4.2-min.js',
		array('jquery') ); 
	wp_enqueue_script('local-scroll',
		get_template_directory_uri() . '/js/jquery.localscroll-1.2.7-min.js',
		array('jquery', 'scroll-to') );
	wp_enqueue_script('inview',
		get_template_directory_uri() . '/js/inview.js',
		array('jquery'));
	if(is_home()){
	wp_enqueue_script('home_scripts',
		get_template_directory_uri() . '/js/home-scripts.js',
		array('jquery', 'mousewheel', 'isotope') );
	}
	else{
	wp_enqueue_script('custom_scripts',
		get_template_directory_uri() . '/js/home-scripts.js',
		array('jquery', 'mousewheel') );
	}

		
	//FOUNDATION REVEAL
	wp_enqueue_script('reveal', get_template_directory_uri() . '/js/jquery.foundation.reveal.js',
		array('jquery') );
	//enqueue styles for foundation reveal
	wp_register_style('foundation-reveal', get_bloginfo('stylesheet_directory').'/foundation.css');
	wp_register_style('foundation-app', get_bloginfo('stylesheet_directory').'/app.css');
	wp_enqueue_style('foundation-reveal');
	wp_enqueue_style('foundation-app');
	
		         
}    
 
add_action('wp_enqueue_scripts', 'my_scripts_method'); // For use on the Front end (ie. Theme)
//___________________ CACHING _______________
//Clear Transients 
add_action('save_post', 'clear_transients');
function clear_transients(){
delete_transient('filter_menu_classification');
delete_transient('artist_list');
delete_transient('section-items-'.of_get_option('case_studies_intro_page', ''));
delete_transient('section-items-'.of_get_option('services_intro_page', ''));
delete_transient('section-items-'.of_get_option('clients_intro_page', ''));
delete_transient('section-items-'.of_get_option('artists_intro_page', ''));
delete_transient('post-list-hh_service');
delete_transient('post-list-hh_case_study');



}
// ------------------ GET THUMBNAILS --------------------------- 
// this function will return a thumbnail image from a the current post (it must be used inside the loop)
//the image size is set in the file image_support.php
//the width and height are pulled from the array $img_src, which gets the src and dimensions from an attachment image.

	function hh_get_the_thumbnails($thumbnail_size, $echo){
			$thumbnail = '';
			if (has_post_thumbnail()) { 
							
				$img = get_the_post_thumbnail();
				$img_id = get_post_thumbnail_id();
				$img_src = wp_get_attachment_image_src($img_id, $thumbnail_size );
			$thumbnail .= '<div class="feature_postimage">';
			
			$thumbnail .=  '<img src="'.$img_src[0].'" width="'.$img_src[1].'" height="'.$img_src[2].'" alt="'.get_the_title().'"/></div>';
							}
					if($echo == 'true'){
					echo $thumbnail;
					}	
					else{
					return $thumbnail;
					}
							} //end of post thumbnail function
	function hh_get_portfolio_backgrounds($thumbnail_size, $echo){
			$thumbnail = '';
			if (has_post_thumbnail()) { 
							
				$img = get_the_post_thumbnail();
				$img_id = get_post_thumbnail_id();
				$img_src = wp_get_attachment_image_src($img_id, $thumbnail_size );
				$thumbnail .= '<div class="portfolio_bg"><img src="'.$img_src[0].'" width="100%" height="auto" alt=" '.get_the_title().'"/>
							</div>';
							
							 }
					 if($echo == 'true'){
					 echo $thumbnail;
					 }	
					 else{
					 return $thumbnail;
					 }
							} //end of portfolio background function


//The Main Loop:
function main_loop(){ ?>
	<div id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

			

				<?php /* Start the Loop */ ?>
				
				<?php while ( have_posts() ) : the_post(); ?>
				
				<?php endwhile; ?>

				

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p>Oops! Couldn't find what you were looking for! Maybe try searching?</p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->
<?php }


/* +++++ T H E   P O S T - T Y P E  L O O P ++++++ */
//////////////////////////////////////////////////////

/*--- post types to draw from:
	hh_artist
	hh_case_study
	hh_client
	hh_event
	hh_hhpress
	hh_project
	hh_portfolio
	hh_proposal
	hh_rental
	hh_service
	hh_testimonials
*/

function modal_more_link( $more_link, $more_link_text ) {
	return str_replace( 'more-link','more-link modal-link', $more_link );
}

/* +++++ T H E   P O R T F O L I O   L O O P ++++++ */
//////////////////////////////////////////////////////
function hh_portfolio_loop($hhpost_type, $hhcount){ 
$portfolio_list = get_transient('portfolio_items');
global $portfolio_image_srcs;

if($portfolio_list == ''){

$args = array(
	
			'post_type' => $hhpost_type,
			'post_count' => $hhcount
);
$custom_query = new WP_Query( $args );
$posts_to_show = 3;
$current_post_index = 1;
if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 


if (has_post_thumbnail()) {
	//save the image markup to a global javascript variable.
			
	$img = get_the_post_thumbnail();
	$img_id = get_post_thumbnail_id();
	$img_src = wp_get_attachment_image_src($img_id, $thumbnail_size );
	$thumbnail = htmlentities('<div class="portfolio_bg"><img src="'.urlencode($img_src[0]).'" width="100%" height="auto" alt=" '.get_the_title().'"/></div>');

	
	if($current_post_index <= $posts_to_show){
		$portfolio_list .='<div class="portfolio-entry post" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'">'.hh_get_portfolio_backgrounds("full-bg", false).'</div>';
	}
	else {
		$portfolio_image_srcs[] = $img_src[0];

	}
}
elseif(!has_post_thumbnail()){
	if($current_post_index <= $posts_to_show){
		$portfolio_list .='<div class="portfolio-entry post" data-target="'.get_permalink(get_the_ID()).'" id="portfolio_post_'.get_the_ID().'"><div class="portfolio_bg"><img src="'.get_bloginfo('stylesheet_directory').'/images/paper_bg2.png" width="100%" height="auto" alt=" '.get_the_title().'"/><div class="portfolio-content centered">'.wpautop(get_the_content()).'</div></div></div>';
	}
}
				$current_post_index++;
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

function hh_post_type_loop($hhpost_type, $hhcount){ 

add_filter( 'the_content_more_link', 'modal_more_link', 10, 2 );//filter the more link to have a modal class

$post_list = get_transient('post-list-'.$hhpost_type);
if($post_list == false){
$args = array(
				
						'post_type' => $hhpost_type,
						'post_count' => $hhcount,
						'orderby' => 'menu_order  parent',
						'order' => 'ASC'
					
			);
			$custom_query = new WP_Query( $args );
			if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
				
				$meta_values = hh_get_meta_values(get_the_ID());
				
				$post_list .= '<div id="post_'.get_the_ID().'" class="post '.$hhpost_type.'_post">';
				
				if($meta_values['vimeo_link']){
				$post_list .=  apply_filters('the_content', $meta_values['vimeo_link']); 
				}
				else if($meta_values['youtube_link']){
				$post_list .= apply_filters('the_content', $meta_values['youtube_link']); 
				}
				else {
				 $post_list .= '<a href="'.get_permalink().'" class="modal-link">'.hh_get_the_thumbnails('feature_slide', false).'</a>';
				}
				global $post;
				$post->post_parent ? $has_parent = 'has-parent' : $has_parent = '';
				
				$post_list.= '<h2 class="post-title '.$has_parent.'">'.get_the_title().'</h2>'.wpautop(get_the_content());
				if(is_user_logged_in() && current_user_can('edit_post', $post->ID)){
					$post_list .= '<p class=""><a href="'.get_edit_post_link($post->ID).'" title="edit post">Edit Post</a></div>';
				}
				else{
					$post_list .= '</div>';
				}
				endwhile; 		
				else : 

				$post_list .= '<p> nothing for you here</p>';

			endif; 
			// Reset Post Data
			wp_reset_postdata();

	set_transient('post-list-'.$hhpost_type, $post_list, 60*60*24*7);
}
echo $post_list;
}

function hh_section_page_loop($hh_pageID){ 

	$section = get_transient('section-items-'.$hh_pageID);
	if($section == ''){
	$section_items = '';
	$args = array(
		
				'page_id' => $hh_pageID
				
			
	);
	$custom_query = new WP_Query( $args );
	if ( $custom_query->have_posts() ) :
	
	while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
	
	$meta_values = hh_get_meta_values(get_the_ID());
	
	$section_items .= '<div id="post_'.get_the_ID().'" class="post section_page"><div class="post-intro">';
	if($meta_values['vimeo_id']){
	$section_items .= apply_filters('the_content', $meta_values['vimeo_id']); 
	}
	else if($meta_values['youtube_id']){
	$section_items .= apply_filters('the_content', $meta_values['youtube_id']); 
	}
	else {
	$section_items .= hh_get_the_thumbnails('feature_slide', false);
	}
	
	$section_items .= '</div>';
	
	$section_items .= get_the_content();
	$section_items .= get_template_part('post_footer'); 
	$section_items .= '</div>';
	endwhile;
	else : 
	$section_items .= '<p> nothing for you here</p>';
	endif;
	wp_reset_postdata();
	
	set_transient('section-items-'.$hh_pageID, $section_items, 60*60*24*7);
	$section = $section_items;
	}
	echo $section;
			 
		
			?>
		
<?php }

//prints out a list of taxonomy terms for use in front-end filters, among other things
function print_the_terms($taxonomy, $separator){
global $terms;
global $post;
$terms = get_the_terms($post->ID, $taxonomy); 
if ( $terms && ! is_wp_error( $terms ) ) : 
	
	foreach ( $terms as $term ) {
	if(!empty($term)){
	
		$tax_items[] = $term->slug;
	}
	}
						
	$the_terms = join($tax_items, $separator);
	return $the_terms;
	endif;
}

function isotope_filter_menu($taxonomy){
global $terms;
global $post;
$terms = get_terms($taxonomy); 
if ( $terms && ! is_wp_error( $terms ) ) { 
	
	foreach ( $terms as $term ) {
		if( $term->count != ''){
		$tax_items[] = "<li><a href='#' class='tiny button secondary' data-filter='.".$term->slug."'>".$term->name." </a></li>";
		
		$the_terms = join($tax_items, ' ');
		}
	}
	$tax_items[] = "<li><a href='#' class='tiny button' data-filter='*'>show all</a></li>";
	$the_terms = join($tax_items, ' ');
	return $the_terms;
}
else {
return "no terms";
}

}

/** CACHE BUSTER **/
add_action( 'save_post', 'bust_the_transients' );
function bust_the_transients(){
   global $wpdb;
   $wpdb->query( 
       "DELETE FROM `wp_options` WHERE `option_name` LIKE ('_transient_%')"
       );
}

?>