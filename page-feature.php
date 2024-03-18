<?php
/**
 * Template Name: 特集ページ用テンプレート
 */
?>
<?php get_header(); ?>

<div id="page" class="feature">
  <div class="maincontents">
  <div class="contents">
<?php get_template_part('/breadcrumb/page'); ?>
<?php
?>

<div class="page_contens inner">

  <article class="page_contents_left">
    <?php add_filter('the_content', 'wpautop_filter', 9);?>
    <?php the_content(); ?>
  </article>

  <aside class="top_contets_right">
      <?php get_sidebar('common'); ?>
  </aside>

   </div>
    <div id="top_img" class="top_link tb_pc"><a href=" "><img src="<?php echo get_template_directory_uri(); ?>/img/ico_pagetop.svg" alt=""></a></div>
  </div>
 </div>
</div>
<?php get_footer(); ?>
