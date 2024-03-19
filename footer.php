</main>
<!--main end-->
<?php
// カテゴリリスト取得（親カテゴリのみ）
$args = [
  'parent' => 0,
  'orderby' => 'menu_order',
  'order' => 'ASC',
  'hide_empty' => 0,
  'exclude' => '1'
];
$categories = get_categories($args);
?>
<footer class="ec-footerRole">
  <div class="ec-footerRole__cont">
    <!-- ロゴ -->
    <div div class="ec-footerRole__logoArea">
      <div class="ec-footerRole__inner">
        <ul class="ec-footerRole__serviceLogo">
          <li>
            <a href="/"><img src="https://placehold.jp/24/cccccc/ffffff/198x30.png?text=Site Name" width="198" height="30" loading="lazy"></a>
          </li>
          <li>
            <a href="/"><img src="https://placehold.jp/24/cccccc/ffffff/198x30.png?text=Site Name" width="198" height="30" loading="lazy"></a>
          </li>
        </ul>
        <div class="ec-footerRole__snsLogo">
            <p class="official">Instagram</p> 
            <ul class="ec-footerRole__inner-right-area-sns">
                <li><a href="#" target="_blank">
                  <svg xmlns="http://www.w3.org/2000/svg" width="35px" height="35px" viewBox="0 0 48 48" id="Layer_2" data-name="Layer 2"><defs><style>.cls-1{fill:none;stroke:#000000;stroke-linecap:round;stroke-linejoin:round;}</style></defs><path class="cls-1" d="M35.38,10.46a2.19,2.19,0,1,0,2.16,2.22v-.06A2.18,2.18,0,0,0,35.38,10.46Z"/><path class="cls-1" d="M40.55,5.5H7.45a2,2,0,0,0-1.95,2v33.1a2,2,0,0,0,2,2h33.1a2,2,0,0,0,2-2V7.45A2,2,0,0,0,40.55,5.5Z"/><path class="cls-1" d="M24,15.72A8.28,8.28,0,1,0,32.28,24h0A8.28,8.28,0,0,0,24,15.72Z"/></svg>
                </a></li>
            </ul>
        </div>
      </div>
    </div>

    <!-- カテゴリ -->
    <div class="ec-footerRole__categories">
      <div class="ec-footerRole__inner">
        <div class="accordion">
          <?php foreach ($categories as $cate): ?>
            <?php
            $this_category_img = get_field( 'category_img', 'category_' . $cate->term_id );
            $size = 'thumbnail';
            $parent_category_color = get_field( 'font_color', 'category_' . $cate->term_id );

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
                      <a href="<?php echo get_category_link($cate->term_id); ?>" onMouseOver="this.style.color='<?php echo esc_attr( $parent_category_color ) ?>';" onMouseOut="this.style.color='#333';">All</a>
                    </li>
                    <?php foreach ($cate_children as $cate_child): ?>
                      <li class="accordion__childLink">
                        <a href="<?php echo get_category_link($cate_child->term_id); ?>" onMouseOver="this.style.color='<?php echo esc_attr( $parent_category_color ) ?>';" onMouseOut="this.style.color='#333';">
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
    </div>

    <!-- ナビ -->
    <div class="ec-footerRole__navi">
      <div class="ec-footerRole__inner">
        <ul class="ec-footerNavi">
          <li class="ec-footerNavi__link">
            <a href="#">footer navi1</a>
          </li>
          <li class="ec-footerNavi__link">
            <a href="#">footer navi1</a>
          </li>
          <li class="ec-footerNavi__link">
            <a href="#">footer navi3</a>
          </li>
          <li class="ec-footerNavi__link">
            <a href="#">footer navi4</a>
          </li>
          <li class="ec-footerNavi__link">
            <a href="#">footer navi5</a>
          </li>
          <li class="ec-footerNavi__link">
            <a href="#">footer navi6</a>
          </li>
          <li class="ec-footerNavi__link">
            <a href="#">footer navi7</a>
          </li>
        </ul>
        <div class="ec-footerTitle">
          <div class="ec-footerTitle__copyright">
            &copy;<?php bloginfo('name'); ?>. All Rights Reserved.
          </div>
        </div>
      </div>
    </div>
	</div>
</footer>


<?php wp_footer(); ?>


<script src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
<script>

	$(function() {
     $('[name="checkbox"]').click(function() {
     $('.header_category_menu').toggleClass('active');
     $('header .menu_area .header_menu_under .category').toggleClass('active');
     });
     });

	$(function() {
     $('[name="checkbox2"]').click(function() {
     $('.header_category_menu').toggleClass('active');
     $('header .menu_area .category').toggleClass('active');
     });
     });


//タグでの切り替え処理
$(function() {
  $('[name="tab_item"]:radio').change( function() {
    if($('[id=alone]').prop('checked')){
    $('.tab_content1').toggleClass('active');
	 $('.tab_content2').removeClass('active');
    $('.tab_content3').removeClass('active');
  $('.tab_content4').removeClass('active');
    } else if ($('[id=two_people]').prop('checked')) {
    $('.tab_content2').toggleClass('active');
  	$('.tab_content1').removeClass('active');
    $('.tab_content3').removeClass('active');
    $('.tab_content4').removeClass('active');
    } else if ($('[id=family]').prop('checked')) {
    $('.tab_content3').toggleClass('active');
	  $('.tab_content1').removeClass('active');
    $('.tab_content2').removeClass('active');
    $('.tab_content4').removeClass('active');
	}else if ($('[id=new]').prop('checked')) {
  $('.tab_content4').toggleClass('active');
  $('.tab_content1').removeClass('active');
  $('.tab_content2').removeClass('active');
  $('.tab_content3').removeClass('active');
}
  });
});


$(function() {
  $('[name="tab_item"]:radio').change( function() {
    if($('[id=new]').prop('checked')){
    $('#category .sec_1 .tabs_area .tab_content1').toggleClass('active');
	 $('#category .sec_1 .tabs_area .tab_content2').removeClass('active');
 } else if ($('[id=alone]').prop('checked')) {
    $('#category .sec_1 .tabs_area .tab_content2').toggleClass('active');
  	$('#category .sec_1 .tabs_area .tab_content1').removeClass('active');
    }
  });
});


//スクロールした際の動きを関数でまとめる
function PageTopAnime() {
  var scroll = $(window).scrollTop();
  if (scroll >= 50){//上から100pxスクロールしたら
    $('#top_img').removeClass('DownMove');//#top_imgについているDownMoveというクラス名を除く
    $('#top_img').addClass('UpMove');//#top_imgについているUpMoveというクラス名を付与
  }else{
    if($('#top_img').hasClass('UpMove')){//すでに#top_imgにUpMoveというクラス名がついていたら
      $('#top_img').removeClass('UpMove');//UpMoveというクラス名を除き
      $('#top_img').addClass('DownMove');//DownMoveというクラス名を#top_imgに付与
    }
  }
}

// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function () {
  PageTopAnime();/* スクロールした際の動きの関数を呼ぶ*/
});


//#to_topをクリックした際の設定
$('#top_img').click(function () {
  var scroll = $(window).scrollTop(); //スクロール値を取得
  if(scroll > 0){
    $(this).addClass('floatAnime');//クリックしたらfloatAnimeというクラス名が付与
        $('body,html').animate({
            scrollTop: 0
        }, 2000,function(){//スクロールの速さ。数字が大きくなるほど遅くなる
            $('#top_img').removeClass('floatAnime');//上までスクロールしたらfloatAnimeというクラス名を除く
        });
  }
    return false;//リンク自体の無効化
});

  //スマホメニュー
  $('.sp_btn').on('click',function(){
    $('.header_menu').addClass('active');
    $('.global_navi').addClass('active');
    $('.menu_bg').addClass('active');
  });
  $('.menu_bg , .close').on('click',function(){
    $('.header_menu').removeClass('active');
    $('.global_navi').removeClass('active');
    $('.menu_bg').removeClass('active');
  });

  //検索窓
  $(".search_btn").click(function () {
    $(this).toggleClass('active');//.open-btnは、クリックごとにbtnactiveクラスを付与＆除去。1回目のクリック時は付与
    $("#search").toggleClass('active');//#search-wrapへpanelactiveクラスを付与
    $('input[name="search"]').focus();//テキスト入力のinputにフォーカス
  });

  //記事投稿ページモーダル表示

  // モーダルを開く
  $('.shop-link__search-btn').on('click',function () {
    $(this).next().toggleClass('shop-modal_open');
  });
  // モーダルを閉じる
  $('.shop-modal__close-btn').on('click',function () {
    let target = $(this).parent();
    $(target).parent().toggleClass('shop-modal_open');
  });

  // 一覧の静的ページング
  $(function() {
    history.replaceState(null, document.getElementsByTagName('title')[0].innerHTML, null);
    window.addEventListener('popstate', function(e) {
      window.location.reload();
    });
    var postListLength = $('.static_paginate:first li').length;
    var limitPaginationValue = false;
    if (postListLength > 40){
      limitPaginationValue = 5;
    }
    $('.static_paginate').paginathing({
      perPage: 8,
      limitPagination: limitPaginationValue,
      firstText: '最初',
      lastText: '最後',
      prevText:'&lt;',
      nextText:'&gt;',
      activeClass: 'navi-active',
      containerClass: 'pagination-container pagination-static_paginate'
    });
    if ( $('.pagination .prev').hasClass('disabled') && $('.pagination .next').hasClass('disabled') ) {
      $('.pagination-container').css('display', 'none');
    }

    $(document).on('click', '.page, .first, .last, .prev, .next', function(){
      // ヘッダメニューの高さ
      var headerMenuHeight = $('.header .menu_area').height() + 10;
      // スクロール位置調整
      var adjust = ((headerMenuHeight * -1));
      // スクロールの速度
      var speed = 400; // ミリ秒
      // 移動先を取得
      var target = $('.static_paginate_scrolltop');
      // 移動先を調整
      var position = target.offset().top + adjust;
      // スムーススクロール
      $('body,html').animate({scrollTop:position}, speed, 'swing');
    });
  });

</script>


<script type="text/javascript">
  window._mfq = window._mfq || [];
  (function() {
    var mf = document.createElement("script");
    mf.type = "text/javascript"; mf.defer = true;
    mf.src = "//cdn.mouseflow.com/projects/2f5613e5-e5c4-4f4a-923b-1cb6b41b8333.js";
    document.getElementsByTagName("head")[0].appendChild(mf);
  })();
</script>
<script src="<?php echo get_template_directory_uri(); ?>/js/stickyfill.min.js"></script>
</body>
</html>
