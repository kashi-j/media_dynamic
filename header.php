<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <meta name="apple-mobile-web-app-title" content="site name">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/common.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/top.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/single.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/page.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/category.css">
  	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/slick/slick.css" type="text/css" >
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/slick/slick-theme.css" type="text/css" >
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/slick.min.js"></script>
  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/paginathing.min.js"></script>
  	<?php wp_head(); ?>
<?php
if (is_category()):
$category = get_queried_object();
$url = get_category_link( get_query_var('cat') );
$url_path = parse_url($url, PHP_URL_PATH);
$og_url = '#';
if ($url_path) {
  $og_url .= $url_path;
}
?>
<meta property="og:locale" content="ja_JP" />
<meta property="og:site_name" content="site name" />
<meta property="og:type" content="article" />
<meta property="og:title" content="site name | <?php echo $category->name; ?>の記事・情報一覧" />
<meta property="og:description" content="sitenameの<?php echo $category->name; ?>に関する新着記事一覧です。" />
<meta property="og:url" content="<?php echo $og_url; ?>" />
<meta property="og:image" content="" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:domain" content="" />
<meta name="twitter:title" content="site name | <?php echo $category->name; ?>の記事・情報一覧" />
<meta name="twitter:description" content="site nameの<?php echo $category->name; ?>に関する新着記事一覧です。" />
<meta name="twitter:image" content="" />
<?php endif; ?>
<?php
if (is_tag()):
$tag = get_queried_object();
?>
  <meta property="og:locale" content="ja_JP" />
  <meta property="og:site_name" content="site name" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="site name | <?php echo $tag->name; ?>の記事・情報一覧" />
  <meta property="og:description" content="site nameの<?php echo $tag->name; ?>に関する新着記事一覧です。" />
  <meta property="og:url" content="<?php echo home_url('tag/'); echo $tag->slug; ?>" />
  <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/img/ogp.png" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:domain" content="<?php echo home_url(); ?>" />
  <meta name="twitter:title" content="site name | <?php echo $tag->name; ?>の記事・情報一覧" />
  <meta name="twitter:description" content="site nameの<?php echo $tag->name; ?>に関する新着記事一覧です。" />
  <meta name="twitter:image" content="#" />
<?php endif; ?>
  <script src="<?php echo get_template_directory_uri(); ?>/js/api.js"></script>
  </head>
  <body>
    <?php
    // カテゴリリスト取得（親カテゴリのみ）z
    $args = [
      'parent' => 0,
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'hide_empty' => 0,
      'exclude' => '1'
    ];
    $categories = get_categories($args);
    ?>
    <!--ロゴ start-->
    <header class="header">
      <div class="menu_area">
        <div class="header_menu fix-header">
          <div class="header_menu_left">
            <div class="logo">
              <a href="/"><img src="https://placehold.jp/ffffff/bababa/163x24.png?text=Site%20Name" alt="サイト名" width="163" height="30"></a>
            </div>
          </div>
          <div class="menu_bg"></div>
          <div class="header_menu_center global_navi">
            <div class="sp_tb">
              <div class="closeArea">
                <div class="close">
                  <span></span><span></span><p>CLOSE</p>
                </div>
              </div>
            </div>
            <div class="dropDownMenu pc_only">
              <ul class="dropDownMenu__parents">
                <?php foreach ($categories as $cate): ?>
                  <li class="dropDownMenu__parent js-dropDown" id="<?php echo $cate->slug; ?>">
                    <a href="<?php echo get_category_link($cate->term_id); ?>"><?php echo $cate->name; ?></a>
                    <?php
                      // 子カテゴリー
                      $args = array(
                        'parent' => $cate->term_id,
                        'hide_empty' => false
                      );
                      $cate_children = get_categories($args);
                      if (!empty($cate_children)):
                    ?>
                    <div class="dropDownMenu__children">
                      <div class="dropDownMenu__inner">
                        <a href="<?php echo get_category_link($cate->term_id); ?>" class="dropDownMenu__head">
                          <span class="dropDownMenu__cateName <?php echo $cate->slug; ?>"><?php echo $cate->name; ?></span>
                          <span class="dropDownMenu__cateSlug"><?php echo $cate->slug; ?></span>
                        </a>
                        <ul class="dropDownMenu__body">
                          <?php foreach($cate_children as $cate_child): ?>
                          <li class="dropDownMenu__childList">
                            <a href="<?php echo get_category_link($cate_child->term_id); ?>"><?php echo $cate_child->name; ?></a>
                          </li>
                          <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>
                <li class="dropDownMenu__parent favorite">
                  <a href="<?php echo home_url(); ?>/feature" data-wpel-link="internal">special</a>
                </li>
              </ul>
            </div>
            <div class="sp_menu sp_tb">
              <p>カテゴリ</p>
              <div class="accordion">
                <?php foreach ($categories as $cate): ?>
                  <?php
                  $this_category_img = get_field( 'category_img', 'category_' . $cate->term_id );
                  $size = 'thumbnail';
                  $this_category_img_url = $this_category_img['sizes'][$size];

                  // 子カテゴリー
                  $args = array(
                    'parent' => $cate->term_id,
                    'hide_empty' => false
                  );
                  $cate_children = get_categories($args);
                  ?>
                  <div class="accordion__category">
                    <div class="accordion__header">
                      <a class="accordion__link js-accordion">
                        <span><?php echo $cate->name; ?></span>
                      </a>
                      <button class="accordion__btn js-accordion" type="button"></button>
                    </div>
                    <?php if (!empty($cate_children)): ?>
                        <div class="accordion__inner">
                          <ul class="accordion__childLinks">
                            <li class="accordion__childLink">
                              <a href="<?php echo get_category_link($cate->term_id); ?>">All</a>
                            </li>
                            <?php foreach ($cate_children as $cate_child): ?>
                              <li class="accordion__childLink">
                                <a href="<?php echo get_category_link($cate_child->term_id); ?>">
                                  <?php echo $cate_child->name; ?>
                                </a>
                              </li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
                <div class="accordion__category">
                  <div class="accordion__header">
                    <a class="accordion__link" href="<?php echo home_url(); ?>/feature"><span>special</span></a>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="sp_tag_menu sp_tb">
              <p>おすすめキーワード</p>
              <?php
              // タグを利用したカテゴリもどきリスト
              $arg = array(
              'posts_per_page' => 1, // 表示する件数
              'post_type' => 'popular_keyword',
              'name' => 'menu_category',
              );

              $posts = get_posts( $arg);
              $popular_tags = get_field('popular_tags', $posts[0]->ID);
              ?>
              <?php if ($popular_tags): ?>
                <div class="tag_list">
                  <ul>
                    <?php foreach ($popular_tags as $tag): ?>
                      <li><a href="/tag/<?php echo $tag->slug; ?>"><p>#<?php echo $tag->name; ?></p></a></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php
              endif;
              wp_reset_postdata();
              ?>
            </div> -->

          </div>
          <div class="header_menu_right">
            <div class="online">
              <a href="#"><span></span></a>
            </div>
            <div class="closeBtn sp_tb">
              <div class="sp_btn"><span></span><span></span><span></span><p>MENU</p></div>
            </div>
          </div>
        </div>
      </div>
    </header>

<!--main start-->
<main>
