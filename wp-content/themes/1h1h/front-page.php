<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage 1H1H
 */

get_header(); 

wp_nav_menu("homepage");

get_template_part('content', 'landing');

get_template_part('content', 'portfolio');

get_template_part('content', 'services');

get_template_part('content', 'media');

get_template_part('content', 'tour');

get_template_part('content', 'clients');

get_template_part('content', 'contact');

get_footer(); ?>