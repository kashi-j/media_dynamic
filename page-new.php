<?php get_header(); ?>



<div id="page" class="new">
  <div class="maincontents">
  <div class="contents">
<?php get_template_part('/breadcrumb/page'); ?>
<?php
?>
<div class="page_header">
  <div class="page_header_area">
   <div class="page_header_area_text">
    <h1>新着記事</h1>
    </div>
  </div>
 </div>

 <div class="background_area"></div>

 <div class="page_contens">

  <article class="page_contents_left">

  <article class="sec_1">
   <div class="new_post_area">
     <?php
     $arg = array(
      'posts_per_page' => -1,
      'orderby' => 'date', // 日付でソート
      'order' => 'DESC', // DESCで最新から表示、ASCで最古から表示
      'post_type' => 'post',
      'paged' => $paged
     );
     $posts = get_posts( $arg );
     if( $posts ):
     ?>
     <ul class="post_list static_paginate">
       <?php
       foreach ( $posts as $post ) :
       setup_postdata( $post );
       $thumb = get_the_post_thumbnail();
       if($thumb === ''){
       $thumb = '<img src="'.get_stylesheet_directory_uri().'/img/noimage.png">';
       }
       $cate = get_the_category();
       $tags = get_the_tags();
       $this_category_color = get_field( 'font_color', 'category_' . $cate[0]->term_id );
       $cate_name = $cate[0]->name;
       $tag_name = $tags[0]->name;
       $tag_slug = $tags[0]->slug;
       ?>
      <li>
       <a href="<?php the_permalink(); ?>">
        <div class="img_area">
         <?php echo $thumb; ?>
         <div class="new_tag">
          <p>NEW</p>
         </div>
         </div>
        <div class="text_area">
         <p><?php echo '<span class="entry-label" style="' . esc_attr( 'color:' . $this_category_color ) . ';">' . esc_html( $cate_name ) . '</span>'; ?></p>
         <div class="post_title"><h3><?php echo get_the_title() ?></h3></div>
         <p class="tb_pc"><?php echo mb_substr( get_the_excerpt(), 0, 50 ) . '[...]'; ?></P>
         <div class="meta_area">
          <object>
          <?php
          foreach( $tags as $tag) {
          ?>
            <a href="/tag/<?php echo $tag -> slug; ?>"><p>#<?php  echo $tag -> name; ?></p></a>
          <?php
          }
          ?>
          </object>
          <time><?php echo get_the_date('Y.m.d'); ?></time>
         </div>
        </div>
       </a>
      </li>
      <?php endforeach; ?>
      <?php if ( !is_paged() ) :?>
      <?php endif; ?>
     </ul>
    <?php
    endif;
    wp_reset_postdata();
    ?>

   </div>
  </article>

  </article>

  <aside class="top_contets_right">
    <div class="side_contents">
      <div class="headline_area">
       <div class="headline"><h2>PICK UP</h2></div>
       <div class="hashtag"><p><span>#</span>おすすめ記事</p></div>
      </div>
      <div class="side_list_area">
        <ul class="side_list">
          <?php
          $arg = array(
            'posts_per_page' => 1,
            'post_type' => 'display_setting',
            'name' => 'pickup',
          );
          $posts = get_posts( $arg );
          if( $posts ):
            $relation_posts = get_field('relation_posts', $posts[0]->ID);
          ?>
          <?php
          if ($relation_posts) :
          foreach ( $relation_posts as $post ) :
            if ($post->post_status !== 'publish') continue;
          setup_postdata( $post );
          $thumb = get_the_post_thumbnail();
          if($thumb === ''){
          $thumb = '<img src="'.get_stylesheet_directory_uri().'/img/noimage.png">';
          }
          $cate = get_the_category();
          $tags = get_the_tags();
          $this_category_color = get_field( 'font_color', 'category_' . $cate[0]->term_id );
          $cate_name = $cate[0]->name;
          $tag_name = $tags[0]->name;
          $ranking = get_field('ranking');
          ?>
        <li>
        <a href="<?php the_permalink(); ?>">
        <div class="img_area">
          <?php echo $thumb; ?>
        </div>
        <div class="text_area">
          <p><?php echo '<span class="entry-label" style="' . esc_attr( 'color:' . $this_category_color ) . ';">' . esc_html( $cate_name ) . '</span>'; ?></p>
          <div class="post_title"><h3><?php echo get_the_title() ?></h3></div>
          <div class="meta_area">
            <object>
            <?php
            foreach( $tags as $tag) {
                ?>
              <a href="/tag/<?php echo $tag -> slug; ?>"><p>#<?php  echo $tag -> name; ?></p></a>
              <?php
              }
              ?>
              </object>
        </div>
        </div>
        </a>
        </li>
        <?php
          endforeach;
          endif;
          endif;
          wp_reset_postdata();
        ?>
        </ul>
      </div>
     </div>
  </aside>

   </div>
    <div id="top_img" class="top_link tb_pc"><a href=" "><img src="<?php echo get_template_directory_uri(); ?>/img/ico_pagetop.svg" alt=""></a></div>
  </div>
 </div>
</div>
<?php get_footer(); ?>
