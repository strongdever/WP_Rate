<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja" style="margin-top: 0 !important;">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta property="og:locale" content="ja_JP">
  <!-- SEO Meta Tags -->
  <meta name="keywords" content="新豊不動産,賃貸マンション,高級賃貸,高級住宅,賃貸,売買,管理,分譲賃貸,不動産,不動産投資,投資物件" />
  <meta name="description" content="草津不動産売却テラスでは、草津市・栗東市・守山市で不動産売却・買取を承っています。住宅ローン滞納に伴う任意売却、遺産分割協議を伴う相続問題、相続した空き家問題、離婚によるペアローン問題など是非お問い合わせください。" />
  <title>草津市・栗東市・守山市の不動産売却｜草津不動産売却テラス</title>

  <!-- Webpage Title -->

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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
        <div class="l-header ui-bd-main">
            <div class="header__inner">
                <p class="headLogo">
                    <img src="<?php echo T_DIRE_URI; ?>/assets/images/logo.png" alt="草津市・栗東市・守山市の不動産売却｜草津不動産売却テラス">
                </p>
                <div class="headInfo">
                    <div class="headInfo__box" style="display:block!important;">
                        <p class="headInfo__tel--main">
                            <i class="fas fa-phone-alt ui-tx-sub ui_icon-phone"></i> 077-565-0021 </p>
                        <div class="headInfo__time">
                            <dl class="headInfo__list">
                                <dt class="headInfo__list--title">
                            営業時間：                    </dt>
                                <dd class="headInfo__list--data">
                                    09:00～18:00 </dd>
                            </dl>
                            <dl class="headInfo__list">
                                <dt class="headInfo__list--title">
                            定休日：                    </dt>
                                <dd class="headInfo__list--data">
                                    土曜・日曜・祝日 </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>