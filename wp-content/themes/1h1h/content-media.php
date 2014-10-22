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

                <form class="newsletter-form" action="">
                  <input type="email" class="input-email" placeholder="Email">
                  <input type="submit" class="submit" value="Send">
                </form>

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