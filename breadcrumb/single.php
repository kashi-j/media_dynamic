<?php $cate  = get_the_category(); ?>

<?php
// パンくずは子カテゴリ有りを優先して表示する
$breadcrumb_cate = [];
foreach($cate as $cat) {
  if ($cat->parent !== 0) {
    $breadcrumb_cate[] = $cat;
    break;
  }
}

if (empty($breadcrumb_cate)) {
  $breadcrumb_cate = $cate;
}
?>

<nav class="breadcrumb inner">
<?php
  foreach($breadcrumb_cate as $cat):
?>

<?php
  $cate_name = $cat->name;                  //カテゴリ取得
  $cate_id   = $cat->term_id;               //カテゴリID取得
  $cate_link = get_category_link($cate_id); //カテゴリurl取得
  $parent    = $cat->category_parent;       //親カテゴリ取得
  if($parent === 0):  //親カテゴリがなかった場合
?>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement":
  [
    {
      "@type": "ListItem",
      "position": 1,
      "item":
      {
        "@id": "<?php echo esc_url( home_url( '/' ) ); ?>",
        "name": "<?php bloginfo('name'); ?>"
      }
    },
    {
      "@type": "ListItem",
      "position": 2,
      "item":
      {
        "@id": "<?php echo $cate_link ?>",
        "name": "<?php echo $cate_name; ?>"
      }
    },
    {
      "@type": "ListItem",
      "position": 3,
      "item":
      {
        "@id": "<?php echo get_the_permalink(); ?>",
        "name": "<?php the_title(); ?>"
      }
    }
  ]
}
</script>

  <ul>
    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><span><?php bloginfo('name'); ?></span></a></li>
    <li><a href="<?php echo $cate_link ?>"><span><?php echo $cate_name; ?></span></a></li>
    <li><a href="<?php echo get_the_permalink(); ?>"><span><?php the_title(); ?></span></a></li>
  </ul>

<?php
  else: //親カテゴリがあった場合

    $parent_cate      = get_category($parent);              //親カテゴリ情報取得
    $parent_cate_name = $parent_cate->name;                 //親カテゴリ名取得
    $parent_cate_id   = $parent_cate->term_id;              //親カテゴリID取得
    $parent_cate_link = get_category_link($parent_cate_id); //カテゴリurl取得
    $parent_id[] = $cate_id;

    while( $parent > 0){
      $parent_id[] = $parent;
      $parent_cate = get_category($parent);
      $parent      = $parent_cate->category_parent;
    }
    $parent_id = array_reverse($parent_id);

    foreach($parent_id as $p){
      $parent_cate = get_category($p);
      $parent_cate_link = get_category_link($p);
      $parents[] = $parent_cate;
    }
?>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement":
  [
    {
      "@type": "ListItem",
      "position": 1,
      "item":
      {
        "@id": "<?php echo esc_url( home_url( '/' ) ); ?>",
        "name": "<?php bloginfo('name'); ?>"
      }
    },
    <?php
      $count = 2;
      foreach($parents as $p):
    ?>
      {
        "@type": "ListItem",
        "position": <?php echo $count; ?>,
        "item":
        {
          "@id": "<?php echo get_category_link($p); ?>",
          "name": "<?php echo $p->name ?>"
        }
      },
    <?php
      $count ++;
      endforeach;
    ?>
    {
      "@type": "ListItem",
      "position": <?php echo $count; ?>,
      "item":
      {
        "@id": "<?php echo get_the_permalink(); ?>",
        "name": "<?php the_title(); ?>"
      }
    }
  ]
}
</script>

  <ul>
    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><span><?php bloginfo('name'); ?></span></a></li>
    <?php foreach($parents as $p): ?>
      <li><a href="<?php echo get_category_link($p); ?>"><span><?php echo $p->name ?></span></a></li>
    <?php endforeach; ?>
    <li><a href="<?php echo get_the_permalink(); ?>"><span><?php the_title(); ?></span></a></li>
  </ul>

<?php endif ?>

<?php endforeach; ?>
</nav>
