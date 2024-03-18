<div class="tag_area_contents" id="keywords">
  <div class="headline_area">
    <div class="headline"><h2>KEYWORD</h2></div>
  </div>
  <?php
  $arg = array(
    'posts_per_page' => 1, // 表示する件数
    'post_type' => 'popular_keyword',
    'name' => 'toppage'
  );

  $posts = get_posts( $arg);
  $popular_tags = get_field('popular_tags', $posts[0]->ID);
  ?>
  <div class="meta_area">
    <object>
      <?php if ($popular_tags): ?>
        <?php foreach ($popular_tags as $tag): ?>
          <a href="/tag/<?php echo $tag->slug; ?>"><p>#<?php echo $tag->name; ?></p></a>
        <?php endforeach; ?>
      <?php
      endif;
      wp_reset_postdata();
      ?>
    </object>
  </div>

  <?php /* ?>
  <div class="popular_list_area">
    <ul class="popular_list">
      <?php
      $arg = array(
        'posts_per_page' => 1,
        'post_type' => 'display_setting',
        'name' => 'keyword',
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
            <p class="tb_pc"><?php echo mb_substr( get_the_excerpt(), 0, 50 ) . '[...]'; ?></P>
            <div class="meta_area">
              <object>
                <?php foreach( $tags as $tag): ?>
                  <a href="/tag/<?php echo $tag -> slug; ?>"><p>#<?php  echo $tag -> name; ?></p></a>
                <?php endforeach; ?>
              </object>
              <time><?php echo get_the_date('Y.m.d'); ?></time>
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
  <?php */ ?>
</div>