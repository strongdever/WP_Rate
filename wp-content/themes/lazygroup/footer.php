        <p class="footer_pagetop">
            <a href="#esbody" id="backtop" class="ui-bg-main" style="display: block;">
            <i class="fas fa-chevron-up icn_arrow"></i><br>TOP
            </a>
        </p>
        
        <div class="l-footer ui-bg-main">
            <div class="footer__wrap">
               <div class="footer__link_wrap">
                  <ul class="footer__link">
                     <li class="footer__item">
                        <a href="<?php echo HOME . 'blog'; ?>" target="_self" class=""> ブログ一覧 </a>
                     </li>
                     <li class="footer__item">
                        <a href="<?php echo HOME . 'bknlist'; ?>" target="_self" class=""> 公開物件一覧 </a>
                     </li>
                  </ul>
                  <ul class="footer__link">
                     <li class="footer__item">
                        <a href="<?php echo HOME . 'sitemap'; ?>" target="_self" class=""> サイトマップ </a>
                     </li>
                     <li class="footer__item">
                        <a href="<?php echo HOME . 'company/accessmap'; ?>" target="_self" class="accessmap_othertab"> アクセスマップ </a>
                     </li>
                  </ul>
                  <ul class="footer__link">
                     <li class="footer__item">
                        <a href="<?php echo HOME . 'contact'; ?>" target="_blank" class=""> 無料相談 </a>
                     </li>
                     <li class="footer__item">
                        <a href="<?php echo HOME . 'news'; ?>" target="_self" class=""> 更新情報 </a>
                     </li>
                  </ul>
                  <ul class="footer__link">
                     <li class="footer__item">
                        <a href="<?php echo HOME . 'company'; ?>" target="_self" class=""> 会社概要 </a>
                     </li>
                     <li class="footer__item">
                        <a href="<?php echo HOME . 'assessment'; ?>" target="_blank" class=""> 無料査定依頼 </a>
                     </li>
                  </ul>
               </div>
               <div class="footCompany">
                  <div class="footCompany__info">
                     <p class="footCompany__name">
                        <a href="<?php echo HOME; ?>"> 草津市・栗東市・守山市での<br>不動産売却のことなら草津不動産売却テラスへ </a>
                     </p>
                     <p class="footCompany__address">
                        〒525-0032<br />
                        滋賀県草津市大路３丁目1-33-2F&nbsp; 
                     </p>
                     <ul class="footCompany__list">
                        <li class="footCompany__item">営業時間： 09:00～18:00 </li>
                        <li class="footCompany__item">定休日： 土曜・日曜・祝日 </li>
                     </ul>
                     <div class="footCompany__contact">
                        <p class="footCompany__bt">
                           <a href="<?php echo HOME . 'assessment'; ?>" class="ui-bg-point hoverDefault" target="_blank" rel="nofollow">
                           <i class="fas fas fa-calculator webicon ui_icon-satei"></i>&nbsp;
                           無料査定を依頼する
                           </a>
                        </p>
                        <p class="footCompany__tel">
                           <span class="footCompany__tel--num">
                           <i class="fas fa-phone-alt ui_icon-phone"></i>
                           &nbsp;077-565-0021 
                           </span>
                        </p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="footer__bottom">
               <div class="footer__bottom_inner">
                  <ul class="footBottomLink">
                     <li class="footBottomLink__item">
                        <a href="<?php echo HOME; ?>"> ホーム </a>
                     </li>
                     <li class="footBottomLink__item">
                        <a href="<?php echo HOME . 'rule'; ?>"> 利用規約 </a>
                     </li>
                     <li class="footBottomLink__item">
                        <a href="<?php echo HOME . 'privacy'; ?>">プライバシーポリシー </a>
                     </li>
                  </ul>
                  <p class="footer__copyright">
                     Copyright© 株式会社トラストレイト All Rights Reserved.
                  </p>
               </div>
            </div>
         </div>
         <div class="right_side_float_menu">
            <p>
               <a href="<?php echo HOME . 'assessment'; ?>" target="_blank" class="hoverDefault" rel="nofollow">
               <img src="<?php echo T_DIRE_URI; ?>/assets/images/bt_float_baikyaku.png" alt="売却査定">
               </a>
            </p>
            <p>
               <a href="<?php echo HOME . 'contact'; ?>" target="_blank" class="hoverDefault" rel="nofollow">
               <img src="<?php echo T_DIRE_URI; ?>/assets/images/bt_float_contact.png" alt="お問い合わせ">
               </a>
            </p>
         </div>
         <script>
            $('.accessmap_othertab').click(function () {
              var accessmapUrl = $(this).attr('href');
              window.open(accessmapUrl, 'accessmap', 'width=850,height=680,status=no,scrollbars=no');
              return false;
            });
         </script>
      </div>

      <?php wp_footer(); ?>
   </body>
</html>