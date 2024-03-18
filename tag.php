<?php get_header(); ?>

<div id="category" class="tag">
<div class="maincontents">
<div class="contents">

<?php get_template_part('/breadcrumb/archive'); ?>


<div class="category_contens inner">
  <article class="category_contents_left">
    <div class="category_header">
      <div class="category_header_area static_paginate_scrolltop">
        <div class="category_header_area_text">
          <h1><?php single_cat_title(); ?></h1>
          <?php
          $tags = get_the_tags();
          $tag = $tags[0]->term_id;
          $this_tag_text = get_field( 'tag_text', 'post_tag_' . $tags[0]->term_id );
          ?>
          <p><?php echo $this_tag_text; ?></p>
        </div>
      </div>
    </div>
    <article class="sec_1">
      <?php $tag = get_queried_object(); ?>
      <?php $tag_slug = $tag->slug; ?>
      <?php
        $arg = array(
          'posts_per_page' => -1,
          'tax_query' => array(
            array(
              'order' => 'DESC', // DESCで最新から表示、ASCで最古から表示
              'taxonomy' => 'post_tag',
              'field' => 'slug',
              'terms' => $tag_slug,
              )
              )
            );
            $posts = get_posts( $arg );
            if( $posts ):
              ?>
      <div class="postArea">
        <ul class="posts posts--col2 static_paginate">
          <?php
          foreach ( $posts as $post ) :
            setup_postdata( $post );
            $thumb = get_the_post_thumbnail();
            if($thumb === ''){
              $thumb = '<img src="'.get_stylesheet_directory_uri().'/img/noimage.png">';
            }
            $cate = get_the_category();
            // 親カテゴリー
            $parent_cate = null;
            foreach ($cate as $row) {
              if ($row->parent === 0) {
                $parent_cate = $row;
                break;
              }
            }
            $parent_category_color = get_field( 'font_color', 'category_' . $parent_cate->term_id );

            // 小カテゴリー
            $children_cate = [];
            foreach ($cate as $row) {
              if ($row->parent === $parent_cate->term_id) {
                $children_cate[] = $row;
              }
            }
            
            // タグ
            $tags = get_the_tags();
            if ($tags) array_splice($tags, 5);// タグは5個まで使用する
            $tag_name = $tags[0]->name;
          ?>
          <li class="post">
            <a href="<?php the_permalink(); ?>">
              <div class="post__imgWrap">
                <?php echo $thumb; ?>
              </div>
              <div class="post__textArea">
                <?php echo '<span class="post__category entry-label sp_only" style="' . esc_attr( 'background:' . $parent_category_color ) . ';">' . esc_html( $parent_cate->name ) . '</span>'; ?>
                <?php if (!empty($children_cate)): ?>
                  <object class="post__childCategories">
                    <?php foreach ($children_cate as $child_cate): ?>
                      <a href="<?php echo get_category_link($child_cate->term_id); ?>" class="post__childCategory"><?php echo $child_cate->name; ?></a>
                    <?php endforeach; ?>
                  </object>
                <?php endif; ?>
                <h3 class="post__heading clamp2">
                  <?php echo get_the_title() ?>
                </h3>
                <div class="post__tagArea">
                  <object class="tags">
                    <?php foreach( $tags as $tag): ?>
                      <a class="tag" href="/tag/<?php echo $tag -> slug; ?>"><p>#<?php  echo $tag -> name; ?></p></a>
                    <?php endforeach; ?>
                  </object>
                </div>
              </div>
              <?php echo '<span class="post__label entry-label tb_pc" style="' . esc_attr( 'background:' . $parent_category_color ) . ';">' . esc_html( $parent_cate->name ) . '</span>'; ?>
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
    <?php get_sidebar('common'); ?>
  </aside>
</div>

<div id="top_img" class="top_link tb_pc"><a href=" "><img src="<?php echo get_template_directory_uri(); ?>/img/ico_pagetop.svg" alt=""></a></div>

</div>
</div>
</div>
<?php get_footer(); ?>
