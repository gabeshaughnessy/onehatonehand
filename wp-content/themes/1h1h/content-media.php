<?php 
  $mediaArgs = array (
    'pagename' => 'media',
  );
  $mediaQuery = new WP_Query( $mediaArgs );

  if ( $mediaQuery->have_posts() ) : while ( $mediaQuery->have_posts() ) : $mediaQuery->the_post();
?>

  <div id="media" class="section">
    <div id="media-wrapper" class="wrapper post-type-wrapper">
        <h2 class="fredericka centered"><?php the_title(); ?></h2>
        <div id="media-posts" class="">
          <div class="primary">
            <div class="content" role="main">

              <div class="small-4 columns">
                
                <h3 class="subtitle fredericka centered"><?php the_field('newsletter_title'); ?></h3>

                <?php the_field('newsletter_copy'); ?>
                
                <link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
                <div id="mc_embed_signup">
                  <form action="//onehatonehand.us6.list-manage.com/subscribe/post?u=0584c4635ebc579c83f7cad10&amp;id=4ba2aed7b9" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="newsletter-form validate" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                      <div style="position: absolute; left: -5000px;">
                        <input type="text" name="b_0584c4635ebc579c83f7cad10_4ba2aed7b9" tabindex="-1" value="">
                      </div>
                      <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                      <input type="submit" value="Signup" name="subscribe" id="mc-embedded-subscribe" class="submit">
                      <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                      </div>
                    </div>
                  </form>
                </div>
                <script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js"></script>
                <script type="text/javascript">
                  (function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[3]='MMERGE3';ftypes[3]='text';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);
              </script>

              </div>
              
              <div class="small-4 columns">
                
                <h3 class="subtitle fredericka centered"><?php the_field('social_media_title'); ?></h3>

                <div class="social-link">
                  <a class="facebook" target="_blank" href="<?php the_field('facebook_link'); ?>">Facebook</a>
                  <a class="instagram" target="_blank" href="<?php the_field('instagram_link'); ?>">Instagram</a>
                  <a class="vimeo" target="_blank" href="<?php the_field('vimeo_link'); ?>">Vimeo</a>
                </div>

              </div>

              <div class="small-4 columns">
                
                <h3 class="subtitle fredericka centered"><?php the_field('lookbook_title'); ?></h3>

                <?php the_field('lookbook_copy'); ?>

              </div>

            </div>
            
          <?php get_template_part('post_footer'); ?>
          </div>
        </div>
    </div>
  </div>
  
<?php endwhile; endif; wp_reset_postdata(); ?>