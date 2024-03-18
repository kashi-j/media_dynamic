<?php
/**
 * Template Name: Single投稿データ取得用テンプレート
 */
header("Content-Type: application/json; charset=utf-8");
$postsData = [];

$siteUrl = site_url();
$args = [
    'post_type ' => ['post'],
    'post_status' => 'publish',
    'orderby' => 'ID',
    'posts_per_page' => -1
];
$postlist = get_posts( $args );
if (!empty($postlist)) {
    foreach ($postlist as $post) {
        $thumbUrl = get_the_post_thumbnail_url($post, 'post-thumbnail');
//        if ($thumbUrl) $thumbUrl = str_replace($siteUrl, '', $thumbUrl);
        $postsData[] = [
            'post_id' => $post->ID,
            'title' => get_the_title($post->ID),
            'permalink' => get_permalink($post->ID),
            'thumb_url' => $thumbUrl
        ];
    }
}

$json = json_encode($postsData, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

$convertJson = mb_convert_encoding($json, 'UTF-8');

echo $convertJson;
exit;