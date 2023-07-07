<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja" style="margin-top: 0 !important;">
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
   <meta property="og:locale" content="ja_JP">
   <!-- SEO Meta Tags -->
   <meta name="keywords" content="新豊不動産,賃貸マンション,高級賃貸,高級住宅,賃貸,売買,管理,分譲賃貸,不動産,不動産投資,投資物件" />
   <meta name="description"
      content="草津不動産売却テラスでは、草津市・栗東市・守山市で不動産売却・買取を承っています。住宅ローン滞納に伴う任意売却、遺産分割協議を伴う相続問題、相続した空き家問題、離婚によるペアローン問題など是非お問い合わせください。" />
   <title>草津市・栗東市・守山市の不動産売却｜草津不動産売却テラス</title>
   <!-- Webpage Title -->
   <link rel="shortcut icon" href="favicon.png">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link rel="stylesheet" href="<?php echo T_DIRE_URI; ?>/assets/css/footer.css">

   <?php wp_head(); ?>

   <script type="text/javascript">
      (function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', 'GTM-P23JBD7');
   </script>
   </head>

   <?php 
    global $post;
    
    if( $post->post_type != "page" ) {
        $post_slug = $post->post_type;
    } else {
        $post_slug = $post->post_name;
    }
    if( is_single() ) {
        $category_arr = get_the_category( $post->ID );
        $post_slug = $category_arr[0]->slug;
    } 
  ?>

   <body id="esbody">
      <div id="container">
         <meta http-equiv="content-script-Type" content="text/javascript">
         <div class="l-header ui-bd-mian">
            <div class="header__inner">
               <h1 class="headLogo">
                  <a href="<?php echo HOME; ?>">
                  <img src="<?php echo T_DIRE_URI; ?>/assets/images/logo.png" alt="草津市・栗東市・守山市の不動産売却｜草津不動産売却テラス">
                  </a>
               </h1>
               <div class="headInfo">
                  <div class="headInfo__box">
                     <div class="tel_company_info">
                        <p class="headInfo__tel--main">
                           <i class="fas fa-phone-alt ui-tx-sub ui_icon-phone"></i>
                           077-565-0021
                        </p>
                        <div class="headInfo__time">
                           <dl class="headInfo__list">
                              <dt class="headInfo__list--title"> 営業時間： </dt>
                              <dd class="headInfo__list--data"> 09:00～18:00 </dd>
                           </dl>
                           <dl class="headInfo__list">
                              <dt class="headInfo__list--title"> 定休日： </dt>
                              <dd class="headInfo__list--data"> 土曜・日曜・祝日 </dd>
                           </dl>
                        </div>
                     </div>
                     <div class="header_contact_wrap">
                        <a href="<?php echo HOME . 'contact'; ?>" target="_blank" class="header_contact ui-bg-sub hoverDefault" rel="nofollow">
                        <i class="far fa-envelope otherContact__icn--mail"></i>
                        無料相談する
                        </a>
                     </div>
                  </div>
                  <div class="headNav">
                     <ul class="headNav__list">
                        <li class="headNav__item">
                           <a href="<?php echo HOME; ?>" class="hoverDefault top" target="_self">ホーム </a>
                        </li>
                        <li class="headNav__item">
                           <a href="<?php echo HOME . 'company/accessmap'; ?>" class="hoverDefault accessmap" target="_self">アクセスマップ</a>
                        </li>
                        <li class="headNav__item">
                           <a href="<?php echo HOME . 'company'; ?>" class="hoverDefault company" target="_self">会社概要</a>
                        </li>
                        <li class="headNav__item">
                           <a href="<?php echo HOME . 'bknlist'; ?>" class="hoverDefault publicBknList" target="_self">売り物件一覧 </a>
                        </li>
                        <li class="headNav__item">
                           <a href="<?php echo HOME . 'blog'; ?>" class="hoverDefault blog" target="_self">ブログ一覧 </a>
                        </li>
                        <li class="headNav__item">
                           <a href="<?php echo HOME . 'assessment'; ?>" class="hoverDefault assessment" target="_blank rel=" nofollow>無料査定依頼</a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div style="display: none;" class="header_contact_fixed_wrap">
                  <a href="<?php echo HOME . 'contact'; ?>" target="_blank" class="header_contact_fixed ui-bg-sub hoverDefault" rel="nofollow">
                  <i class="far fa-envelope otherContact__icn--mail"></i>
                  無料相談する
                  </a>
               </div>
            </div>
         </div>
         <script type="text/javascript">
            $(function() {
                var headHeight = $('.l-header').outerHeight();
                $(window).scroll(function() {
                    if ($(this).scrollTop() > 0) {
                        $('.l-header').addClass('is-fixed');
                        $('.headLogo').css('width', '250px');
                        $('.headLogo').find('img').css('width', '100%');
                        $('#container').css({
                            "padding-top": headHeight
                        });
                        $('.headInfo__box').hide();
                    } else {
                        $('.l-header').removeClass('is-fixed');
                        $('.headLogo').css('width', '');
                        $('.headLogo').find('img').css('width', '');
                        $('#container').css({
                            "padding-top": ""
                        });
                        $('.headInfo__box').show();
                    }
                });
            });
            
            $('.accessmap').click(function() {
                var accessmapUrl = $(this).attr('href');
                window.open(accessmapUrl, 'accessmap', 'width=850,height=680,status=no,scrollbars=no');
                return false;
            });
         </script>