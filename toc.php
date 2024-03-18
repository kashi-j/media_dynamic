<?php
  $id = get_the_id();
  $post = get_post($id);
  $content = $post->post_content;

  $toc = array();
  $ptn = '@<h[2-6]>(.*)</h[2-6]>@';
  preg_match_all( $ptn, $content, $match );
  $toc = $match[1];
?>
<div class="toc_area">
  <div class="toc">
    <div class="top_inner">
      <div class="title">目次</div>
      <ul>
      <?php
        $i = 1;
        foreach($toc as $t):
      ?>
        <li><a href="#id<?php echo $i; ?>"><?php echo $t ?></a></li>
      <?php
        $i++;
        endforeach;
      ?>
      </ul>
    </div>
  </div>
</div>
