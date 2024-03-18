<?php
/**
 * Template Name: 編集部よりページ用テンプレート
 */
?>
<?php get_header(); ?>

<div id="page" class="news">
  <div class="maincontents">
    <div class="contents">
      <?php get_template_part('/breadcrumb/page'); ?>
      <div class="page_contents inner">
        <article class="page_contents_left">
          <div class="page_header">
            <div class="page_header_area">
              <div class="page_media">
                <div class="page_media__imgWrap">
                <img src="<?php echo get_template_directory_uri(); ?>/img/ico_edit.png" alt="編集部より">
                </div>
                <div class="page_media__txtArea">
                  <h1 class=page_media__heading>編集部より</h1>
                  <p class="page_media__text">編集部からのお知らせや編集部スタッフがピックアップするおすすめ情報をお届けします。キャンペーンなどのお役立ち情報も？</p>
                </div>
              </div>
            </div>
          </div>
          <div class="page_contentsarea">
            <div class="page_contentsarea_head">
              <div class="page_contentsarea_info">
                <span class="page_contentsarea_label">編集部より</span>
                <time class="page_contentsarea_timestamp"><?php echo get_the_date('Y/m/d'); ?></time>
              </div>
            </div>
            <?php the_content() ?>
          </div>
        </article>
        <aside class="top_contets_right">
            <?php get_sidebar('common'); ?>
        </aside>
      </div>
      <div id="top_img" class="top_link tb_pc">
        <a href=" "><img src="<?php echo get_template_directory_uri(); ?>/img/ico_pagetop.svg" alt=""></a>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
