<div class="ranking_contens">

  <div class="headline_area">
    <div class="headline"><h2>Ranking</h2></div>
  </div>

  <div class="post_list_area">
    <ul class="post_list post_list--ranking">
      <?php
      $arg = array(
        'posts_per_page' => 1,
        'post_type' => 'display_setting',
        'name' => 'ranking'
      );
      $posts = get_posts( $arg );
      if( $posts ):
        $relation_posts = get_field('relation_posts', $posts[0]->ID);
      
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
              $tag_name = $tags[0]->name;
              $ranking = get_field('ranking');
      ?>
      <li>
        <a href="<?php the_permalink(); ?>">
          <div class="img_area">
            <?php echo $thumb; ?>
          </div>
          <div class="text_area">
            <div class="post_title"><h3 class="clamp2"><?php echo get_the_title() ?></h3></div>
            <p><?php echo '<span class="entry-label" >' . esc_html( $parent_cate->name ) . '</span>'; ?></p>
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
    </ul>
  </div>
</div>