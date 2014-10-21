<?php
/**
 * @package WordPress
 * @subpackage 1H1H
 */
?><!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />

  <title><?php wp_title(''); ?></title>
  
  <meta name="description" content="<?php echo get_bloginfo('description'); ?>">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
  <meta name="apple-mobile-web-app-capable" content="yes">
  
  <link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/iOs_114px.jpg" />
  <link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('stylesheet_directory'); ?>/images/iOs_75px.jpg" />
  <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('stylesheet_directory'); ?>/images/iOs_114px.jpg" />
  
  <link href="http://fonts.googleapis.com/css?family=Fredericka+the+Great|Muli" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/jquery-ui-1.8.21.custom.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />

  <script type="text/javascript">
    //Creates a global variable with the theme directory for use in js functions
    var templateDir = "<?php bloginfo('template_directory') ?>";
  </script>

  <?php wp_head(); ?>

</head>
<body <?php body_class(); ?> data-spy="scroll" >
<div class="loader"><div class="loading-text"><span class="loading-icon"></span>Loading</div></div>
<div id="header">
</div>
<div id="fixed_bg"></div>
<div id="wrapper">