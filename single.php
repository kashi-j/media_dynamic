<?php get_header(); ?>

<?php setPostViews(get_the_ID()); ?>

<div id="single">

<?php get_template_part('/breadcrumb/single'); ?>

<div class="single inner">
  <div class="single_contents">
      <div class="single_mv">
        <div class="single_mv_area">
          <div class="img_area single_mv_left">
            <?php if(has_post_thumbnail()) : echo the_post_thumbnail('full'); ?>
            <?php else : ?>
              <img src="<?php echo esc_url(get_theme_file_uri('img/noimage.png')); ?>">
            <?php endif; ?>
          </div>
          <div class="single_mv_right">
            <time datetime="<?php echo get_the_date('Y-m-d'); ?> <?php echo get_the_time('H:i:s'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
            <div class="text_area">
              <?php
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
                  break;
                }
              }
    
              // タグ
              $tags = get_the_tags();
              // if ($tags) array_splice($tags, 15);// タグは15個まで使用する
              $tag_name = $tags[0]->name;
              ?>
              <div class="text_category">
                <?php echo '<span class="text_category_parent entry-label" style="' . esc_attr( 'background:' . $parent_category_color ) . ';">' . esc_html( $parent_cate->name ) . '</span>'; ?>
                <?php if (!empty($children_cate)): ?>
                  <div class="text_category_child">
                    <?php foreach ($children_cate as $cate): ?>
                      <?php echo '<span>' . esc_html($cate->name) . '</span>'; ?>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
              <div class="post_title"><h1><?php echo the_title() ?></h1></div>
              <div class="meta_area">
                <object>
                  <svg xmlns="http://www.w3.org/2000/svg" width="22.004" height="21.999" viewBox="0 0 22.004 21.999">
                    <path id="ico_tag" d="M-21903,2719a11,11,0,0,1,11-11,11,11,0,0,1,11,11,11,11,0,0,1-11,11A11,11,0,0,1-21903,2719Zm10.334-5.167a1.5,1.5,0,0,0-.918.55l-4.348,5.557-.061.077a1.506,1.506,0,0,0-.307,1.1,1.473,1.473,0,0,0,.561.995l3.979,3.117a1.474,1.474,0,0,0,1.1.3,1.457,1.457,0,0,0,.99-.561l4.414-5.634a1.467,1.467,0,0,0,.313-1.022l-.264-3.76a.339.339,0,0,1-.006-.077,1.522,1.522,0,0,0-.561-.995,1.494,1.494,0,0,0-1.1-.3h-.016l-.01,0-.043.007Zm1.775,3.628a1.32,1.32,0,0,1-.225-1.847,1.32,1.32,0,0,1,1.848-.225,1.319,1.319,0,0,1,.225,1.847,1.309,1.309,0,0,1-1.037.5A1.317,1.317,0,0,1-21890.893,2717.462Zm1.949-4.273.043-.007h0l-.053.01Z" transform="translate(21903.002 -2708.001)" fill="#b0b0b0"/>
                  </svg>
                  <?php foreach( $tags as $tag): ?>
                    <a href="/tag/<?php echo $tag -> slug; ?>"><p>#<?php  echo $tag -> name; ?></p></a>
                  <?php endforeach; ?>
                </object>
              </div>
            </div>
            <!-- <div class="favorite_btn add-favorite" data-post-id="<?php the_ID(); ?>">
              <div class="favorite_btn_img"></div><p>後で読む・お気に入りに保存する</p>
            </div> -->
          </div>
        </div>
      </div>

      <div class="single_contentsarea">
        <?php the_content() ?>
      </div>

      <div class="meta_area">
        <object>
          <svg xmlns="http://www.w3.org/2000/svg" width="22.004" height="21.999" viewBox="0 0 22.004 21.999">
            <path id="ico_tag" d="M-21903,2719a11,11,0,0,1,11-11,11,11,0,0,1,11,11,11,11,0,0,1-11,11A11,11,0,0,1-21903,2719Zm10.334-5.167a1.5,1.5,0,0,0-.918.55l-4.348,5.557-.061.077a1.506,1.506,0,0,0-.307,1.1,1.473,1.473,0,0,0,.561.995l3.979,3.117a1.474,1.474,0,0,0,1.1.3,1.457,1.457,0,0,0,.99-.561l4.414-5.634a1.467,1.467,0,0,0,.313-1.022l-.264-3.76a.339.339,0,0,1-.006-.077,1.522,1.522,0,0,0-.561-.995,1.494,1.494,0,0,0-1.1-.3h-.016l-.01,0-.043.007Zm1.775,3.628a1.32,1.32,0,0,1-.225-1.847,1.32,1.32,0,0,1,1.848-.225,1.319,1.319,0,0,1,.225,1.847,1.309,1.309,0,0,1-1.037.5A1.317,1.317,0,0,1-21890.893,2717.462Zm1.949-4.273.043-.007h0l-.053.01Z" transform="translate(21903.002 -2708.001)" fill="#b0b0b0"/>
          </svg>
          <?php foreach( $tags as $tag): ?>
            <a href="/tag/<?php echo $tag -> slug; ?>"><p>#<?php  echo $tag -> name; ?></p></a>
          <?php endforeach; ?>
        </object>
      </div>

      <?php
      $url_encode = urlencode( get_permalink() );
      $title_encode = urlencode( get_the_title() );
      ?>

      <div class="sns_fv_area">
        <div class="sns_menu_area">
          <div class="sns_menu">
            <div class="fb">
            <a href="<?php echo 'https://www.facebook.com/sharer/sharer.php?u=' . $url_encode . '&t=' . $title_encode; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/single-facebook.png" alt=""></a>
            </div>
            <div class="line">
            <a href="<?php echo 'https://line.me/R/msg/text/?' . $title_encode . '%0D%0A' . $url_encode; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/single-line.png" alt=""></a>
            </div>
            <div class="twitter">
            <a href="<?php echo 'https://twitter.com/share?url=' . $url_encode . '&text=' . $title_encode; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/single-twitter.png" alt=""></a>
            </div>
          </div>
          <!-- <div class="favorite_btn add-favorite" data-post-id="<?php the_ID(); ?>">
            <div class="favorite_btn_img"></div><p>後で読む・お気に入りに保存する</p>
          </div> -->
        </div>
      </div>

      <div class="tag_area_contents">
        <div class="headline_area">
          <div class="headline"><h2>KEYWORD</h2></div>
          <div class="hashtag"><p><span>#</span>人気のキーワード</p></div>
        </div>
        <?php
        $arg = array(
          'orderby' => 'date',
          'order' => 'DESC',
        );

        $posts = get_posts( $arg);
        if( $posts):
        ?>
          <div class="meta_area">
            <object>
              <svg xmlns="http://www.w3.org/2000/svg" width="22.004" height="21.999" viewBox="0 0 22.004 21.999">
                <path id="ico_tag" d="M-21903,2719a11,11,0,0,1,11-11,11,11,0,0,1,11,11,11,11,0,0,1-11,11A11,11,0,0,1-21903,2719Zm10.334-5.167a1.5,1.5,0,0,0-.918.55l-4.348,5.557-.061.077a1.506,1.506,0,0,0-.307,1.1,1.473,1.473,0,0,0,.561.995l3.979,3.117a1.474,1.474,0,0,0,1.1.3,1.457,1.457,0,0,0,.99-.561l4.414-5.634a1.467,1.467,0,0,0,.313-1.022l-.264-3.76a.339.339,0,0,1-.006-.077,1.522,1.522,0,0,0-.561-.995,1.494,1.494,0,0,0-1.1-.3h-.016l-.01,0-.043.007Zm1.775,3.628a1.32,1.32,0,0,1-.225-1.847,1.32,1.32,0,0,1,1.848-.225,1.319,1.319,0,0,1,.225,1.847,1.309,1.309,0,0,1-1.037.5A1.317,1.317,0,0,1-21890.893,2717.462Zm1.949-4.273.043-.007h0l-.053.01Z" transform="translate(21903.002 -2708.001)" fill="#b0b0b0"></path>
              </svg>
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
              arsort($tag_count2);
              $i = 0;
              ?>

              <?php foreach($tag_count2 as $key => $value)://keyをforeach
                $tag_link = get_tags(array('name' => $key));
                $tag_slug_link = $tag_link[0]->slug;
                $i++;
                if($i >= 6){
                  break;
                }
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

      <div class="popular_list_area">
        <div class="headline_area">
          <div class="headline"><h2>RECOMMENDED</h2></div>
          <div class="hashtag"><p><span>#</span>この記事を読んだ人におすすめの記事</p></div>
        </div>
        <ul class="popular_list random_sort_contents">
          <?php $cate = get_the_category(); ?>
          <?php $cate_name = $cate[0]->slug; ?>
          <?php
          $currentPostId = get_the_ID();
          $arg = array(
            'posts_per_page' => '20',
            'category_name' => $cate_name,
            'exclude' => [$currentPostId],
            'orderby' => 'date',
            'order' => 'DESC',
          );
          $posts = get_posts( $arg );
          if( $posts ):
          ?>
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
            ?>
            <li>
              <a href="<?php the_permalink(); ?>">
                <div class="img_area">
                  <?php echo $thumb; ?>
                </div>
                <div class="text_area">
                  <div class="post_title"><h3><?php echo get_the_title() ?></h3></div>
                  <div class="meta_area">
                    <object>
                      <?php foreach( $tags as $tag): ?>
                        <a href="/tag/<?php echo $tag -> slug; ?>"><p>#<?php  echo $tag -> name; ?></p></a>
                      <?php endforeach; ?>
                    </object>
                  </div>
                </div>
              </a>
            </li>
            <?php endforeach; ?>
          <?php
          endif;
          wp_reset_postdata();
          ?>
        </ul>
      </div>

      <?php if(have_rows('recommend')): ?>
        <div class="recommend_area">
          <div class="headline_area">
            <div class="headline"><h2>RECOMMEND</h2></div>
            <div class="hashtag"><p><span>#</span>おすすめ商品</p></div>
          </div>
          <ol class="recommend_list">
            <?php while(have_rows('recommend')): the_row(); ?>
            <?php if (!empty(get_sub_field('recommend_text'))): ?>
              <li>
                <a href="<?php the_sub_field('recommend_url'); ?>">
                  <figure><img src="<?php the_sub_field('recommend_img_url'); ?>"></figure>
                  <p><?php the_sub_field('recommend_text'); ?></p>
                  <p>￥<?php echo number_format(get_sub_field('recommend_price')); ?><span>(税込)</span></p>
                </a>
              </li>
            <?php endif; ?>
            <?php endwhile; ?>
          </ol>
        </div>
      <?php endif; ?>
    </div>

    <aside class="top_contets_right">
      <?php get_sidebar('common'); ?>
    </aside>

  </div>

  <div id="top_img" class="top_link tb_pc"><a href=" "><img src="<?php echo get_template_directory_uri(); ?>/img/ico_pagetop.svg" alt=""></a></div>

</div>
</div>
</div>
<script>
// コンテンツ並び替え（ランダム）
function shuffleContents(container) {
  var content = container.find("> *");
  var total = content.length;
  content.each(function() {
    content.eq(Math.floor(Math.random() * total)).prependTo(container);
  });
}

$(function() {
  // レコメンド記事のランダム表示
  $('.random_sort_contents').hide();
  shuffleContents($('.random_sort_contents'));

  $('.random_sort_contents li').each(function(idx){
    if (idx >= 5) {//表示する件素
      $(this).remove();
    }
  });
  $('.random_sort_contents').show();
});
</script>

<?php get_footer(); ?>
