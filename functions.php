<?php

add_filter( 'wp_sitemaps_enabled', '__return_false' );

// 人気記事出力用関数
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0 View";
    }
    return $count.' Views';
}
// 記事viewカウント用関数
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
    }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
    }
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);



class Toc_Shortcode {
	private $add_script = false;
	private $atts = array();

	public function __construct() {
		add_shortcode( 'toc', array( $this, 'shortcode_content' ) );
		add_action( 'wp_footer', array( $this, 'add_script' ), 999999 );
		add_filter( 'the_content', array( $this, 'change_content' ), 9 );
	}

	function change_content( $content ) {
		return "<div id=\"toc_content\">{$content}</div>";
	}

	public function shortcode_content( $atts ) {
		global $post;

		if ( ! isset( $post ) )
			return '';

		$this->atts = shortcode_atts( array(
			'id' => '',
			'class' => 'toc',
			'title' => '目次',
			'toggle' => true,
			'opentext' => 'OPEN',
			'closetext' => 'CLOSE',
			'close' => false,
			'showcount' => 2,
			'depth' => 0,
			'toplevel' => 2,
			'scroll' => 'smooth',
		), $atts );

		$this->atts['toggle'] = ( false !== $this->atts['toggle'] && 'false' !== $this->atts['toggle'] ) ? true : false;
		$this->atts['close'] = ( false !== $this->atts['close'] && 'false' !== $this->atts['close'] ) ? true : false;

		$content = $post->post_content;

		$headers = array();
		preg_match_all( '/<([hH][1-6]).*?>(.*?)<\/[hH][1-6].*?>/u', $content, $headers );
		$header_count = count( $headers[0] );
		$counter = 0;
		$counters = array( 0, 0, 0, 0, 0, 0 );
		$current_depth = 0;
		$prev_depth = 0;
		$top_level = intval( $this->atts['toplevel'] );
		if ( $top_level < 1 ) $top_level = 1;
		if ( $top_level > 6 ) $top_level = 6;
		$this->atts['toplevel'] = $top_level;

		// 表示する階層数
		$max_depth = ( ( $this->atts['depth'] == 0 ) ? 6 : intval( $this->atts['depth'] ) );

		$toc_list = '';
		for ( $i = 0; $i < $header_count; $i++ ) {
			$depth = 0;
			switch ( strtolower( $headers[1][$i] ) ) {
				case 'h1': $depth = 1 - $top_level + 1; break;
				case 'h2': $depth = 2 - $top_level + 1; break;
				case 'h3': $depth = 3 - $top_level + 1; break;
				case 'h4': $depth = 4 - $top_level + 1; break;
				case 'h5': $depth = 5 - $top_level + 1; break;
				case 'h6': $depth = 6 - $top_level + 1; break;
			}
			if ( $depth >= 1 && $depth <= $max_depth ) {
				if ( $current_depth == $depth ) {
					$toc_list .= '</li>';
				}
				while ( $current_depth > $depth ) {
					$toc_list .= '</li></ul>';
					$current_depth--;
					$counters[$current_depth] = 0;
				}
				if ( $current_depth != $prev_depth ) {
					$toc_list .= '</li>';
				}
				if ( $current_depth < $depth ) {
					$class = $current_depth == 0 ? ' class="toc-list"' : '';
					$style = $current_depth == 0 && $this->atts['close'] ? ' style="display: none;"' : '';
					$toc_list .= "<ul{$class}{$style}>";
					$current_depth++;
				}
				$counters[$current_depth - 1]++;
				$number = $counters[0];
				for ( $j = 1; $j < $current_depth; $j++ ) {
					$number .= '.' . $counters[$j];
				}
				$counter++;
				$toc_list .= '<li><a href="#toc' . ($i + 1) . '"><span class="contentstable-number"></span> ' . $headers[2][$i] . '</a>';
				$prev_depth = $depth;
			}
		}
		while ( $current_depth >= 1 ) {
			$toc_list .= '</li></ul>';
			$current_depth--;
		}

		$html = '';
		if ( $counter >= $this->atts['showcount'] ) {
			$this->add_script = true;

			$toggle = '';
			if ( $this->atts['toggle'] ) {
				$toggle = ' <span class="toc-toggle">[<a class="internal" href="javascript:void(0);">' . ( $this->atts['close'] ? $this->atts['opentext'] : $this->atts['closetext'] ) . '</a>]</span>';
			}

			$html .= '<div' . ( $this->atts['id'] != '' ? ' id="' . $this->atts['id'] . '"' : '' ) . ' class="' . $this->atts['class'] . '">';
			$html .= '<p class="toc-title">' . $this->atts['title'] . $toggle . '</p>';
			$html .= $toc_list;
			$html .= '</div>' . "\n";
		}

		return $html;
	}

	public function add_script() {
		if ( ! $this->add_script ) {
			return false;
		}

		$var = wp_json_encode( array(
			'open_text' => isset( $this->atts['opentext'] ) ? $this->atts['opentext'] : 'OPEN',
			'close_text' => isset( $this->atts['closetext'] ) ? $this->atts['closetext'] : 'CLOSE',
			'scroll' => isset( $this->atts['scroll'] ) ? $this->atts['scroll'] : 'smooth',
		) );

		?>
<script type="text/javascript">
var xo_toc = <?php echo $var; ?>;
let xoToc = () => {
  const entryContent = document.getElementById('toc_content');
  if (!entryContent) {
    return false;
  }

  /**
   * スムーズスクロール関数
   */
  let smoothScroll = (target, offset) => {
    var bufferY = 0;
    if (window.innerWidth < 1024) {
      bufferY = 70;
    }
    const targetRect = target.getBoundingClientRect();
    const targetY = targetRect.top + window.pageYOffset - offset - bufferY;
    window.scrollTo({left: 0, top: targetY, behavior: xo_toc['scroll']});
  };

  /**
   * アンカータグにイベントを登録
   */
  const wpadminbar = document.getElementById('wpadminbar');
  const smoothOffset = (wpadminbar ? wpadminbar.clientHeight : 0) + 2;
  const links = document.querySelectorAll('.toc-list a[href*="#"]');
  for (let i = 0; i < links.length; i++) {
    links[i].addEventListener('click', function (e) {
      const href = e.currentTarget.getAttribute('href');
      const splitHref = href.split('#');
      const targetID = splitHref[1];
      const target = document.getElementById(targetID);

      if (target) {
        e.preventDefault();
        smoothScroll(target, smoothOffset);
      } else {
        return true;
      }
      return false;
    });
  }

  /**
   * ヘッダータグに ID を付与
   */
  const headers = entryContent.querySelectorAll('h1, h2, h3, h4, h5, h6');
  for (let i = 0; i < headers.length; i++) {
    headers[i].setAttribute('id', 'toc' + (i + 1));
  }

  /**
   * 目次項目の開閉
   */
  const tocs = document.getElementsByClassName('toc');
  for (let i = 0; i < tocs.length; i++) {
    const toggle = tocs[i].getElementsByClassName('toc-toggle')[0].getElementsByTagName('a')[0];
    toggle.addEventListener('click', function (e) {
      const target = e.currentTarget;
      const tocList = tocs[i].getElementsByClassName('toc-list')[0];
      if (tocList.hidden) {
        target.innerText = xo_toc['close_text'];
      } else {
        target.innerText = xo_toc['open_text'];
      }
      tocList.hidden = !tocList.hidden;
    });
  }
};
xoToc();
</script>
		<?php
	}

}

new Toc_Shortcode();


/**********************
**    タイトル自動出力    **
**********************/
function setup_theme() {
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'setup_theme' );


/**********************
**    ウィジェット    **
**********************/
add_action( 'widgets_init', function () {
	register_sidebar(
		array(  //「トップページSNS」を登録する
			'name'          => 'トップページSNS',
			'id'            => 'top_sns_widget',
			'before_widget' => '<div class="top_sns_widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="top_sns_title">',
			'after_title'   => '</div>',
		)
	);
	register_sidebar(
    array(  //「サイドバーウィジェット」を登録する
      'name'          => 'サイドバー',
      'id'            => 'sidebar_widget',
      'before_widget' => '<div class="sidebar_widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="sidebar_top_title">',
      'after_title'   => '</div>',
	  )
  );
  register_sidebar(
    array(  //「フッターウィジェット」を登録する
      'name'          => 'フッター',
      'id'            => 'footer_widget',
      'before_widget' => '<div class="footer_widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="footer_top_title">',
      'after_title'   => '</div>',
	  )
  );
  register_sidebar(
    array(  //「記事上ウィジェット」を登録する
      'name'          => '記事上',
      'id'            => 'contents_top_widget',
      'before_widget' => '<div> class="contents_top_widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="contents_top_title">',
      'after_title'   => '</div>',
	  )
  );
  register_sidebar(
    array(  //「記事下ウィジェット」を登録する
      'name'          => '記事下',
      'id'            => 'contents_bottom_widget',
      'before_widget' => '<div class="contents_bottom_widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="contents_bottom_title">',
      'after_title'   => '</div>',
	  )
  );
  register_sidebar(
    array(  //「投稿ページネーション下ウィジェット」を登録する
      'name'          => '投稿ページネーション下',
      'id'            => 'pagenation_bottom_widget',
      'before_widget' => '<div class="pagenation_bottom_widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="pagenation_bottom_title">',
      'after_title'   => '</div>',
	  )
  );
  register_sidebar(
    array(  //「投稿ページネーション下ウィジェット」を登録する
      'name'          => 'スマホメニュー',
      'id'            => 'sp_widget',
      'before_widget' => '<div class="sp_widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="sp_title">',
      'after_title'   => '</div>',
	  )
  );
});



/**********************
**      メニュー      **
**********************/
function menu_setup() {
  register_nav_menus( array(
    'global' => 'グローバルメニュー',
    'side'   => 'サイドメニュー',
    'footer' => 'フッターメニュー',
    'spmenu' => 'スマートフォンメニュー',
  ) );
}
add_action( 'after_setup_theme', 'menu_setup' );



/**********************
**    ヘッダー画像    **
**********************/
$header_image = array(
// デフォルト画像
'default-image' => get_bloginfo('template_url').'/img/header.jpg',
// 文字色や、テキストの表示 falseで無効。
'header-text' => false,
);
add_theme_support( 'custom-header', $header_image );


/**********************
**       ロゴ        **
**********************/
add_theme_support('custom-logo');

/**********************
**  サムネイル表示    **
**********************/
add_theme_support('post-thumbnails');


/**********************
**   モバイル判定     **
**********************/
function is_mobile() {
    $useragents = array(
        'iPhone',          // iPhone
        'iPod',            // iPod touch
        '^(?=.*Android)(?=.*Mobile)', // 1.5+ Android
        'dream',           // Pre 1.5 Android
        'CUPCAKE',         // 1.5+ Android
        'blackberry9500',  // Storm
        'blackberry9530',  // Storm
        'blackberry9520',  // Storm v2
        'blackberry9550',  // Storm v2
        'blackberry9800',  // Torch
        'webOS',           // Palm Pre Experimental
        'incognito',       // Other iPhone browser
        'webmate'          // Other iPhone browser
    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}
add_filter( 'run_wptexturize', '__return_false' );


/**********************
**   管理バー表示     **
**********************/
add_filter( 'show_admin_bar', '__return_false' );


/**********************
**   ページネーション     **
**********************/
function the_pagination() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;
  echo '<nav class="pagination">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '<',
    'next_text'    => '>',
    'type'         => 'list',
    'end_size'     => 3,
    'mid_size'     => 3
  ) );
  echo '</nav>';
}

/*下記コピペでページネーション生成
	<? if( function_exists("the_pagination") ) the_pagination(); ?>
*/



//カテゴリー説明文でhtml記述を可能にする
remove_filter( 'pre_term_description', 'wp_filter_kses' );




//固定ページのみビジュアル削除
function disable_visual_editor_in_page(){
  global $typenow;
  if( $typenow == 'page' ){
    add_filter('user_can_richedit', 'disable_visual_editor_filter');
  }
}
function disable_visual_editor_filter(){
  return false;
}
add_action( 'load-post.php', 'disable_visual_editor_in_page' );
add_action( 'load-post-new.php', 'disable_visual_editor_in_page' );

//固定ページのpタグ削除
// add_filter('the_content', 'wpautop_filter', 9);
function wpautop_filter($content) {
  global $post;
  $remove_filter = false;

  $arr_types = array('page'); //自動整形を無効にする投稿タイプを記述 ＝固定ページ
  $post_type = get_post_type( $post->ID );
  if (in_array($post_type, $arr_types)){
                $remove_filter = true;
        }

  if ( $remove_filter ) {
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
  }

  return $content;
}

//SugarBeats-SEOの実装
//require "SB-SEO/seo_function.php";



//予約投稿機能を無効化
add_action('save_post', 'futuretopublish', 99);
add_action('edit_post', 'futuretopublish', 99);
function futuretopublish()
{
global $wpdb;
$sql = 'UPDATE `'.$wpdb->prefix.'posts` ';
$sql .= 'SET post_status = "publish" ';
$sql .= 'WHERE post_status = "future"';
$wpdb->get_results($sql);
}

// 投稿タイプ追加
function create_post_type()
{
    register_post_type(
        'popular_keyword',
        array(
            'labels' => array(
                'name' => '人気キーワード管理',
                'singular_name' => '人気キーワード管理',
                'add_new_item' => '人気キーワード管理を新規追加',
                'edit_item' => '人気キーワード管理を編集'
            ),
            'rewrite' => array( 'with_front' => false ),
            'public' => true,
            'has_archive' => false,
            'hierarchical' => false,
            'supports' => array('title'),
            'taxonomies' => array(),
        )
    );

    register_post_type(
      'display_setting',
      array(
          'labels' => array(
              'name' => '表示設定管理',
              'singular_name' => '表示設定管理',
              'add_new_item' => '表示設定管理を新規追加',
              'edit_item' => '表示設定管理を編集'
          ),
          'rewrite' => array( 'with_front' => false ),
          'public' => true,
          'has_archive' => false,
          'hierarchical' => false,
          'supports' => array('title'),
          'taxonomies' => array(),
      )
    );

    register_post_type(
      'store_lead',
      array(
          'labels' => array(
              'name' => 'Store導線管理',
              'singular_name' => 'Store導線管理',
              'add_new_item' => 'Store導線管理を新規追加',
              'edit_item' => 'Store導線管理を編集'
          ),
          'rewrite' => array( 'with_front' => false ),
          'public' => true,
          'has_archive' => false,
          'hierarchical' => false,
          'supports' => array('title'),
          'taxonomies' => array(),
      )
    );

    register_post_type(
      'feature',
      array(
          'labels' => array(
              'name' => '特集',
              'singular_name' => '特集',
              'menu_name' => '特集管理',
              'add_new_item' => '特集を新規追加',
              'edit_item' => '特集を編集'
          ),
          'rewrite' => array( 'with_front' => true ),
          'public' => true,
          'has_archive' => false,
          'hierarchical' => false,
          'supports' => array('title', 'editor', 'thumbnail'),
          'taxonomies' => array(),
      )
    );
  }
  add_action( 'init', 'create_post_type' );

// 管理画面用CSS読み込み
function mytheme_admin_enqueue() {
  wp_enqueue_style( 'my_admin_css', get_template_directory_uri() . '/admin-style.css' );
}
add_action( 'admin_enqueue_scripts', 'mytheme_admin_enqueue' );


//// wp_head内ソースを出力前に置換
// wp_head 出力フィルタリング・ハンドラ追加
add_action( 'wp_head', 'wp_head_buffer_start', 0 );
add_action( 'wp_head', 'wp_head_buffer_end', 100 );
/*
 * wp_head 出力フィルタリング
 */
function wp_head_filter($buffer) {
  // meta twitter:domainの変更
  $buffer = preg_replace( '/<meta name="twitter:domain" content="(.*)" \/>/', '<meta name="twitter:domain" content="#" />', $buffer );
  return $buffer;
}
/*
 * wp_head バッファリング開始
 */
function wp_head_buffer_start() {
  // 出力バッファリング開始
  ob_start( 'wp_head_filter' );
}
/*
 * wp_head バッファリング終了
 */
function wp_head_buffer_end() {
  // 出力バッファリング終了
  ob_end_flush();
}


/**
 * 投稿画面にタグ一覧を表示しチェックボックス選択式にする
 */
function re_register_post_tag_taxonomy() {
  $tag_slug_args = get_taxonomy('post_tag');
  $tag_slug_args->hierarchical = true;
  $tag_slug_args->meta_box_cb = 'post_categories_meta_box';
  register_taxonomy('post_tag', 'post', (array) $tag_slug_args);
}
add_action( 'init', 're_register_post_tag_taxonomy', 1 );

/**
 * ログ出力
 */
function my_wp_log($message) {
  $log_message = sprintf("%s:%s\n", date_i18n('Y-m-d H:i:s'), $message);
  $file_name = dirname(ABSPATH) . '/logs/my_wp_' . date_i18n('Y-m-d')  . '.log';
  error_log($log_message, 3, $file_name);
}

