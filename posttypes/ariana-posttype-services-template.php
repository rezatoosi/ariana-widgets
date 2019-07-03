<?php get_header(); ?>

<?php if (have_posts()){ the_post(); ?>
<section class="section">
    <div class="container">
        <div class="row">
          <div class="col-md-7 col-sm-12">
              <?php the_content(); ?>
          </div><!-- end col -->

          <div class="col-md-5 col-sm-12 mobile30">
              <?php if (has_post_thumbnail()) { ?>
                <img src="<?php esc_url(the_post_thumbnail_url()); ?>" alt="<?php esc_html(the_post_thumbnail_caption()); ?>" class="img-responsive">
              <?php } else { ?>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/img/post-default.png'); ?>" alt="<?php esc_html(the_title()); ?>" class="img-responsive">
              <?php } ?>
          </div>
        </div><!-- end row -->
    </div><!-- end container -->
</section>
<?php } ?>

<section class="section lb">
    <div class="container">
        <div class="section-title text-center">
            <?php //<h5>ALL IN ONE SEARCH ENGINE TOOLS</h5> ?>
            <h3>OTHER SERVICES</h3>
            <hr>
        </div><!-- end title -->
        <div class="row services-list">
            <?php echo do_shortcode('[ariana_services]'); ?>
        </div><!-- end row -->
    </div><!-- end container -->
</section>


<?php get_footer(); ?>
