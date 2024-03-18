<?php
/**
 * Template Name: 投稿検索結果ページ用テンプレート
 */
?>
<?php get_header(); ?>

<div id="category" class="tag">
<div class="maincontents">
<div class="contents">

<?php get_template_part('/breadcrumb/page'); ?>


<div class="category_contens inner">
  <article class="category_contents_left">
    <div class="category_header">
      <div class="category_header_area static_paginate_scrolltop">
        <div class="category_header_area_text">
          <h1 id="search-page-title"></h1>
        </div>
      </div>
    </div>


    <article class="sec_1">
      <div id="fs-result" class="postArea">
      </div>
    </article>
  </article>

  <aside class="top_contets_right">
    <?php get_sidebar('common'); ?>
  </aside>
</div>

<div id="top_img" class="top_link tb_pc"><a href=" "><img src="<?php echo get_template_directory_uri(); ?>/img/ico_pagetop.svg" alt=""></a></div>

</div>
</div>
</div>
<style type="text/css">
#fs-result .tags a.tag:nth-child(n + 6) {
  display: none;
}
.fs-loading {
  display: none;
}
</style>
<?php get_footer(); ?>