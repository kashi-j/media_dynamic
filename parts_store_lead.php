<div class="lead_contens">

  <div class="headline_area">
    <div class="headline"><h2>Pick Up</h2></div>
  </div>

  <div class="post_list_area">
    <?php
    $arg = array(
      'posts_per_page' => 4,
      'post_type' => 'store_lead',
      'orderby' => 'menu_order',
      'order' => 'DESC'
    );
    $posts = get_posts( $arg );
    if ($posts) :
      $defaultShowListLength = 2;// 初期表示数
    ?>
    <ul class="post_list post_list--col2 store_lead_list">
      <?php
      $loop_count = 0;
      foreach ( $posts as $post ) :
        setup_postdata( $post );
        $link_url = get_field('link_url');
        $image1 = get_field('store_lead_img_1');
        $image1_url = null;
        if (!empty($image1)) {
          $image1_url = $image1['url'];
        }

        $list_class = '';
        if ($loop_count < $defaultShowListLength) {
          $list_class = 'is-show';
        }
      ?>
      <li class="<?php echo $list_class; ?>">
        <a href="<?php echo $link_url; ?>" target="_blank">
          <div class="img_area">
            <?php if (!is_null($image1_url)): ?>
              <img alt="<?php echo get_the_title() ?>" src="<?php echo $image1_url; ?>">
            <?php endif; ?>
          </div>
          <div class="text_area">
            <div class="post_title"><h3 class="clamp2"><?php echo get_the_title() ?></h3></div>
          </div>
        </a>
      </li>
      <?php
        $loop_count++;
      endforeach;
      ?>
    </ul>
    <!-- <?php if (count($posts) > $defaultShowListLength): ?>
      <div class="post_list_btn"><a href="javascript:void(0)" class="btn-more-store_lead"><span>もっと見る</span></a></div>
    <?php endif; ?> -->
    <?php
    endif;
    wp_reset_postdata();
    ?>
  </div>
</div>
