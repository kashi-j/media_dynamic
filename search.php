<?php get_header(); ?>

<div id="archive">
  <?php if(have_posts()) : ?>
    <?php get_template_part('/breadcrumb/archive'); ?>
    <div class="maincontents">
      <div class="contents">
        <h1 class="archive_title"><?php the_search_query(); ?>の検索結果 : <?php echo $wp_query->found_posts; ?>件</h1>

        <div class="looplist">
          <ol>
            <?php while(have_posts()):the_post() ?>
              <li>
                <a href="<?php the_permalink(); ?>">
                  <time><?php the_time( 'Y/m/d' ); ?></time>
                  <div class="title"><?php the_title(); ?></div>
                </a>
              </li>
            <?php endwhile; ?>
          </ol>
          <?php if( function_exists("the_pagination") ) the_pagination(); ?>
        </div>
      </div>
      <?php get_sidebar(); ?>
    </div>
  <?php else: ?>
    <div class="maincontents">
      <div class="contents">
      <p>申し訳ございません。<br />該当する記事がございません。</p>
      </div>
      <?php get_sidebar(); ?>
    </div>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
