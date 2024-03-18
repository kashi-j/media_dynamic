<?php
  $cat_id = get_query_var('cat');
  $cate   = get_category($cat_id);

  $parent = isset($cate->parent) ? $cate->parent : 0;
  if($parent == 0):
    //親カテゴリがなかった場合
?>

<nav class="breadcrumb inner">
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
          "@id": "<?php echo get_category_link($cat_id); ?>",
          "name": "<?php single_cat_title(); ?>"
        }
      }
    ]
  }
  </script>
  <ul>
    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><span><?php bloginfo('name'); ?></span></a></li>
    <li><a href="<?php echo get_category_link($cat_id); ?>"><span><?php single_cat_title(); ?></span></a></li>
  </ul>
</nav>

<?php
  else:
    //親カテゴリがあった場合

    $parent_cate = get_category($parent);
    $parent_id   = array();
    $parent_id[] = $cat_id;

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

<nav class="breadcrumb inner">
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
      }
      <?php if($p !== end($parents)){}else{echo ",";} ?>
    <?php
      $count ++;
      endforeach;
    ?>
    ]
  }
  </script>
  <ul>
    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><span><?php bloginfo('name'); ?></span></a></li>
    <?php foreach($parents as $p): ?>
      <li><a href="<?php echo get_category_link($p); ?>"><span><?php echo $p->name ?></span></a></li>
    <?php endforeach; ?>
  </ul>
</nav>

<?php endif; ?>
