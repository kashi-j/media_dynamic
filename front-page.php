<?php get_header(); ?>

<div id="front">
<div class="wrapper">

<article id="mv">
  <div class="mv__inner">
    <div class="mvPosts mvPosts--col2">
      <?php
      $arg = array(
        'posts_per_page' => 1,
        'post_type' => 'display_setting',
        'name' => 'special_feature'
      );
      $posts = get_posts( $arg );
      if( $posts ):
        $relation_posts = get_field('relation_posts', $posts[0]->ID);

        if ($relation_posts) :
          foreach ( $relation_posts as $post ) :
            if ($post->post_status !== 'publish') continue;
              setup_postdata( $post );
              $thumb = get_the_post_thumbnail();
              if($thumb === ''){
                $thumb = '<img src="'.get_stylesheet_directory_uri().'/img/noimage.png" loading="eager" width="560" height="373">';
              }
              $cate = get_the_category();
              $tags = get_the_tags();
              if ($tags) array_splice($tags, 5);// タグは5個まで使用する
              $this_category_color = get_field( 'font_color', 'category_' . $cate[0]->term_id );
              $cate_name = $cate[0]->name;
              $tag_name = $tags[0]->name;
              $ranking = get_field('ranking');
      ?>
      <a href="<?php the_permalink(); ?>" class="mvPosts__link mvPost">
          <div class="mvPost__imgArea">
            <?php echo $thumb; ?>
          </div>
          <div class="mvPost__txtArea">
            <h3 class="mvPost__heading clamp2"><?php echo get_the_title() ?></h3>
            <object class="mvPost__tags tags">
              <?php foreach( $tags as $tag): ?>
                <a class="tag" href="/tag/<?php echo $tag -> slug; ?>">
                  <span>#<?php  echo $tag -> name; ?></span>
                </a>
                <?php endforeach; ?>
            </object>
          </div>
          <?php echo '<span class="mvPost__label entry-label" style="' . esc_attr( 'background:' . $this_category_color ) . ';">' . esc_html($cate_name) . '</span>'; ?>
      </a>
      <?php
      endforeach;
      endif;
      endif;
      wp_reset_postdata();
      ?>
    </div>
  </div>
</article>

<div class="top inner">
  <article class="top_contents_left">
    <article class="sec_1 static_paginate_scrolltop">
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
      <div class="postArea" id="new">
        <h2 class="postArea__heading postArea__heading--new">New arrival</h2>
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
            $tag_slug = $tags[0]->slug;
          ?>
          <li class="post" style="display:none;">
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
                <h3 class="post__heading clamp2"><?php echo get_the_title() ?></h3>
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
    </article>
  </article>

  <aside class="top_contets_right">
    <?php get_sidebar('common'); ?>
  </aside>
</div>

<div id="top_img" class="top_link tb_pc"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/img/ico_pagetop.svg" alt=""></a></div>

</div>
</div>

<?php get_footer(); ?>
