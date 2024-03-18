<?php get_header(); ?>

<div id="category">
  <div class="maincontents">
    <div class="contents">

      <?php get_template_part('/breadcrumb/archive'); ?>

      <?php
      $cate = get_category(get_query_var('cat'));
      $this_category_img = get_field( 'category_img', 'category_' . $cate->term_id );
      $size = 'thumbnail';
      $this_category_img_url = isset($this_category_img['sizes'][$size]) ? $this_category_img['sizes'][$size] : '';
      $this_category_text = get_field( 'category_text', 'category_' . $cate->term_id );
      $this_category_ranking = get_field( 'category_ranking', 'category_' . $cate->term_id );

      // 子カテゴリー
      $args = array(
        'parent' => $cate->term_id,
        'hide_empty' => false
      );
      $cate_children = get_categories($args);
      $cate_children_ids = [];
      if (!empty($cate_children)) {
        foreach ($cate_children as $cate_child) {
          $cate_children_ids[] = $cate_child->cat_ID;
        }
      }
      ?>

      <div class="category_header">
        <div class="category_header_area">
          <div class="category_header_area_img"><?php if (!is_null($this_category_img)): ?><img src="<?php echo $this_category_img_url; ?>" alt=""><?php endif; ?>
            <h1 class="sp_tb"><?php echo $cate->name; ?></h1>
          </div>
          <div class="category_header_area_text">
            <h1 class=""><?php echo $cate->name; ?></h1>
            <p><?php echo $this_category_text; ?></p>
            <?php if (!empty($cate_children)): ?>
            <div class="category_header_area_cate_children">
              <ul>
                <?php foreach ($cate_children as $cate_child): ?>
                  <?php $child_category_color = get_field( 'font_color', 'category_' . $cate_child->term_id ); ?>
                <li>
                  <a
                    href="<?php echo get_category_link($cate_child->term_id); ?>"
                    >
                    <?php echo $cate_child->name; ?>
                  </a>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endif; ?>
          </div>
        </div>

        <?php
        $cond_category_ids = [];
        $cond_category_ids[] = $cate->cat_ID;
        $cond_category_ids = array_merge($cond_category_ids, $cate_children_ids);
        $arg = array(
          'posts_per_page' => 3, // 表示する件数
          'category' => implode(',', $cond_category_ids),
          'orderby' => 'date',
          'order' => 'DESC',
        );
        $posts = get_posts( $arg);
        if( $posts):
        ?>
        <div class="tag_list">
          <p><?php echo $cate->name; ?>の新着キーワード</p>
          <div class="meta_area">
            <object>
              <?php
              $tag_slug = array(); //slugの空配列作成
              $tag_name = array(); //nameの空配列作成

              foreach ( $posts as $post ){
                setup_postdata( $post ); //postを回す
                $tags = get_the_tags(); //postのtag取得

                foreach($tags as $tag){ //tagを回す
                  array_push($tag_slug,$tag->slug); //slugだけを一次配列に
                  array_push($tag_name,$tag->name); //nameだけを一次配列に
                }
              }
              $tag_count1 = array_count_values($tag_slug); //重複してるvalueをカウント
              $tag_count2 = array_count_values($tag_name); //重複してるvalueをカウント
              ksort($tag_count2);
              array_splice($tag_count2, 10);// タグは10個まで使用する
              ?>

              <?php foreach($tag_count2 as $key => $value)://keyをforeach
                $tag_link = get_tags(array('hide_empty' => false, 'name' => $key));
                $tag_slug_link = $tag_link[0]->slug;
              ?>

              <a href="/tag/<?php echo $tag_slug_link ?>"><p>#<?php echo $key; ?></p></a>
              <?php endforeach ?>
            </object>
          </div>
          <?php
          endif;
          wp_reset_postdata();
          ?>
        </div>
      </div>
      <div class="category_contens inner">
        <article class="category_contents_left">
          <article class="sec_1 static_paginate_scrolltop">
            <div class="tabs_area tb_pc">
              <div class="tabs">
                <div class="tab_three">
                  <input id="new" type="radio" name="tab_item" checked>
                  <label class="tab_item" for="new">新着記事</label>
                  <input id="alone" type="radio" name="tab_item">
                  <label class="tab_item" for="alone">ランキング</label>
                </div>
                <div class="tab_content1 active" id="content1">
                  <div class="tab_contents">
                    <?php
                    $arg = array(
                      'posts_per_page' => -1,
                      'category_name' => $cate->slug,
                      'orderby' => 'date', // 日付でソート
                      'order' => 'DESC', // DESCで最新から表示、ASCで最古から表示
                      'post_type' => 'post',
                      'paged' => $paged
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
                        $tag_slug = $tags[0]->slug;
                        ?>
                        <li class="post">
                          <a href="<?php the_permalink(); ?>">
                            <div class="post__imgWrap">
                              <?php echo $thumb; ?>
                            </div>
                            <div class="post__textArea">
                              <div class="post__categoryArea">
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
                </div>
              </div>

              <div class="tab_content2" id="content2">
                <div class="tab_contents">
                  <div class="postArea">
                    <ul class="posts posts--col2 posts--ranking">
                      <?php if ($this_category_ranking): ?>
                        <?php
                        $arg = array(
                          'posts_per_page' => 1,
                          'post_type' => 'display_setting',
                          'name' => $this_category_ranking->post_name,
                          'post_status' => 'any',
                        );
                        $posts = get_posts( $arg );
                        if( $posts ):
                          $relation_posts = get_field('relation_posts', $posts[0]->ID);
                        ?>
                        <?php
                          if ($relation_posts) :
                            $rank = 1;
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
                                $ranking = get_field('ranking');
                        ?>
                        <li class="post">
                          <a href="<?php the_permalink(); ?>">
                            <div class="post__imgWrap">
                              <?php echo $thumb; ?>
                            </div>
                            <div class="post__textArea">
                              <div class="post__categoryArea">
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
                                    <a class="tag" href="/tag/<?php echo $tag -> slug; ?>"><p>#<?php echo $tag->name; ?></p></a>
                                  <?php endforeach; ?>
                                </object>
                              </div>
                            </div>
                          </a>
                        </li>
                        <?php
                        $rank++;
                        endforeach;
                        endif;
                        endif;
                        wp_reset_postdata();
                        ?>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php
            $cate = get_category(get_query_var('cat'));
            $arg = array(
              'posts_per_page' => -1,
              'category_name' => $cate->slug,
              'orderby' => 'date', // 日付でソート
              'order' => 'DESC', // DESCで最新から表示、ASCで最古から表示
              'post_type' => 'post',
              'paged' => $paged
            );
            $posts = get_posts( $arg );
            if( $posts ):
            ?>
            <div class="postArea sp_only">
              <h2 class="postArea__heading">新着記事</h2>
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
                  <li class="post">
                    <a href="<?php the_permalink(); ?>">
                      <div class="post__imgWrap">
                        <?php echo $thumb; ?>
                      </div>
                      <div class="post__textArea">
                        <div class="post__categoryArea">
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

            <?php
            $cate = get_category(get_query_var('cat'));

            $arg = array(
              'posts_per_page' => -1,
              'category_name' => $cate->slug,
              'orderby' => 'date', // 日付でソート
              'order' => 'DESC', // DESCで最新から表示、ASCで最古から表示
              'post_type' => 'post',
              'paged' => $paged
            );
            $posts = get_posts( $arg );
            if( $posts ):
            ?>

            <div class="postArea sp_only">
              <h2 class="postArea__heading"><?php echo $cate->name; ?>のランキング</h2>
              <ul class="posts posts--col2 posts--ranking">
                <?php if ($this_category_ranking): ?>
                  <?php
                  $arg = array(
                    'posts_per_page' => 1,
                    'post_type' => 'display_setting',
                    'name' => $this_category_ranking->post_name,
                    'post_status' => 'any',
                  );
                  $posts = get_posts( $arg );
                  if( $posts ):
                    $relation_posts = get_field('relation_posts', $posts[0]->ID);
                  ?>
                  <?php
                    if ($relation_posts) :
                      $rank = 1;
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
                          $ranking = get_field('ranking');
                  ?>
                  <li class="post">
                    <a href="<?php the_permalink(); ?>">
                      <div class="post__imgWrap">
                        <?php echo $thumb; ?>
                      </div>
                      <div class="post__textArea">
                        <h3 class="post__heading clamp2"><?php echo get_the_title() ?></h3>
                        <div class="post__categoryArea">
                          <?php if (!empty($children_cate)): ?>
                            <object class="post__childCategories">
                              <?php foreach ($children_cate as $child_cate): ?>
                                <a href="<?php echo get_category_link($child_cate->term_id); ?>" class="post__childCategory"><?php echo $child_cate->name; ?></a>
                              <?php endforeach; ?>
                            </object>
                          <?php endif; ?>
                        </div>
                      </div>
                    </a>
                  </li>
                  <?php
                  $rank++;
                  endforeach;
                  endif;
                  endif;
                  wp_reset_postdata();
                  ?>
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
