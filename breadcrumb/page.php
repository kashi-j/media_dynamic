<?php
$id = get_the_id();
$parent = $post->post_parent;


if($parent){

  $parent_id   = array();
  $parent_id[] = $id;

  while( $parent > 0){
    $parent_id[] = $parent;
    $parent_post = get_post($parent);
    $parent      = $parent_post->post_parent;
  }
  $parent_id = array_reverse($parent_id);

}else{
  $parent_id[] = $id;
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
        $i = 2;
        foreach($parent_id as $p):

      ?>
      {
        "@type": "ListItem",
        "position": <?php echo $i; ?>,
        "item":
        {
          "@id": "<?php echo get_the_permalink($p); ?>",
          "name": "<?php echo get_the_title($p); ?>"
        }
      }
      <?php if($p === end($parent_id)){}else{echo ",";} ?>

      <?php
        $i++;
        endforeach;
      ?>
    ]
  }
  </script>
  <ul>
    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><span><?php bloginfo('name'); ?></span></a></li>
    <?php foreach($parent_id as $key => $p): ?>
      <li><a href="<?php echo get_the_permalink($p); ?>"><span class="breadcrumb-list-item-<?php echo $key; ?>"><?php echo get_the_title($p); ?></span></a></li>
    <?php endforeach; ?>
  </ul>
</nav>
