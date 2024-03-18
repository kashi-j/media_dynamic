<nav class="breadcrumb inner">
  <ul>
    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><span><?php bloginfo('name'); ?></span></a></li>
    <li><a href="<?php echo home_url(); ?>/feature"><span>special</span></a></li>
    <li><a href="<?php echo get_the_permalink(); ?>"><span><?php the_title(); ?></span></a></li>
  </ul>
</nav>
