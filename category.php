<?php
$cate = get_category(get_query_var('cat'));

if ($cate->slug === 'uncategorized') {
	$wp_query->set_404();
	header('HTTP/1.0 404 Not Found');
	include(TEMPLATEPATH.'/404.php');
	exit;
}

if ($cate->parent === 0) {
  get_template_part('category_parent');
	return;
}
else {
  get_template_part('category_child');
	return;
}
?>