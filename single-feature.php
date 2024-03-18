<?php get_header(); ?>

<?php setPostViews(get_the_ID()); ?>

<div id="single" class="feature">

<?php get_template_part('/breadcrumb/single-feature'); ?>

  <div class="single inner">
    <div class="single_contents">
      <div class="single_mv">
        <div class="single_mv_area">
          <div class="img_area single_mv_left">
            <?php echo the_post_thumbnail('full');  ?>
          </div>
          <div class="single_mv_right">
            <div class="post_title"><h1><?php echo the_title() ?></h1></div>
              <?php the_content() ?>
          </div>
        </div>
      </div>
      <div class="single_contentsarea static_paginate_scrolltop">
        <div class="postArea">
          <ul class="posts posts--col2 static_paginate">
            <?php
            $relation_posts = get_field('feature_published_posts', get_the_ID());
            
            if ($relation_posts) :
              foreach ( $relation_posts as $post ) :
                if ($post->post_status !== 'publish') continue;
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
                  <div class="post__categoryArea">
                    <?php echo '<span class="post__category entry-label sp_only" style="' . esc_attr( 'background:' . $parent_category_color ) . ';">' . esc_html( $parent_cate->name ) . '</span>'; ?>
                    <?php if (!empty($children_cate)): ?>
                      <object class="post__childCategories">
                        <?php foreach ($children_cate as $child_cate): ?>
                          <a href="<?php echo get_category_link($child_cate->term_id); ?>" class="post__childCategory"><?php echo $child_cate->name; ?></a>
                        <?php endforeach; ?>
                      </object>
                    <?php endif; ?>
                  </div>
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
            <?php
            endforeach;
            endif;
            wp_reset_postdata();
            ?>
          </ul>
        </div>
      </div>
    </div>

    <aside class="top_contets_right">
      <?php get_sidebar('common'); ?>
    </aside>

  </div>

  <div id="top_img" class="top_link tb_pc"><a href=" "><img src="<?php echo get_template_directory_uri(); ?>/img/ico_pagetop.svg" alt=""></a></div>

</div>
</div>
</div>

<?php get_footer(); ?>
