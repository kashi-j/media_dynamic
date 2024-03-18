<?php
/**
 * Template Name: Single投稿データ取得　全文検索用テンプレート
 */
header("Content-Type: application/json; charset=utf-8");
$postsData = [];

$siteUrl = site_url();
$args = [
    'post_type ' => ['post'],
    'post_status' => 'publish',
    'orderby' => 'date ID',
    'order' => 'DESC DESC',
    'posts_per_page' => -1
];
$postlist = get_posts( $args );
if (!empty($postlist)) {
    foreach ($postlist as $post) {
        // サムネイル画像URL
        $thumbUrl = get_the_post_thumbnail_url($post, 'post-thumbnail');
//        if ($thumbUrl) $thumbUrl = str_replace($siteUrl, '', $thumbUrl);

        // 本文（文字数抜粋）
        $removeArray = ["\r\n", "\r", "\n", " ", "　"];
        $content = wp_trim_words(strip_shortcodes(get_the_content()), 500, '' );
        $content = str_replace($removeArray, ' ', $content);

        // カテゴリ（HTML）
        $cate = get_the_category($post->ID);
        $cateColor = get_field( 'font_color', 'category_' . $cate[0]->term_id );
        $cateName = $cate[0]->name;

        // 親カテゴリー
        $parentCate = null;
        foreach ($cate as $row) {
                if ($row->parent === 0) {
                $parentCate = $row;
                break;
                }
        }
        $parentCategoryColor = get_field( 'font_color', 'category_' . $parentCate->term_id );

        // 小カテゴリー
        $childrenCate = [];
        foreach ($cate as $row) {
                if ($row->parent === $parentCate->term_id) {
                        $childrenCate[] = $row;
                }
        }
        $childCateName = isset($childrenCate[0]) ? $childrenCate[0]->name : '';

        // タグ
        $tags = [];
        $tagStr = '';
        $posttags = get_the_tags($post->ID);
        if ($posttags) {
            foreach ($posttags as $tag) {
                $tags[] = [
                    'slug' => $tag->slug,
                    'name' => $tag->name
                ];
                $tagStr .= $tag->name .' ';
            }
        }

        $postsData['items'][] = [
            'post_id' => $post->ID,
            'title' => get_the_title($post->ID),
            'permalink' => get_permalink($post->ID),
            'thumb_url' => $thumbUrl,
            'cate_color' => esc_attr($parentCategoryColor),
            'cate_name' => esc_html($parentCate->name),
            'cld_cate_name' => esc_html($childCateName),
            'content' => $content,
            'excerpt' => mb_substr($content, 0, 50),
            'tag_str' => $tagStr,
            'tags' => $tags,
            'date' => get_the_date('Y.m.d', $post->ID)
        ];
    }
}

$json = json_encode($postsData, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

$convertJson = mb_convert_encoding($json, 'UTF-8');

echo $convertJson;
exit;