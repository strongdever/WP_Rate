<?php
/*
Template Name: Assessment Thankyou Template
*/

if ( ! defined( 'ABSPATH' ) ) exit;
get_header('contact');

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

?>
<main>

    <div id="contents_outer">

        <!-- contentsStart -->
        <div id="contents" class="clearfix">
            <div class="pageHead">
                <h1 class="pageHead__ttl ui-bd-main">
                    不動産査定 
                </h1>
            </div>

            <div class="input-contact">

                <ul class="contactStatus">
                    <li class="contactStatus__item--1">
                        入力
                    </li>
                    <li class="contactStatus__item--2">
                        確認
                    </li>
                    <li class="contactStatus__item--3 ui-bg-sub is-active">
                        送信
                    </li>
                </ul>

                <div class="contactForm__wrap">
                    <div class="contactText">
                        <p class="sendtext">送信完了いたしました。お問い合わせありがとうございます。</p>
                        <p class="contactText__detail">後ほど弊社スタッフよりご連絡差し上げますので、今しばらくお待ちください。<br>しばらくたっても弊社より返信、返答がない場合は、ご入力いただいたメールアドレスに誤りがある場合がございます。<br>その際は、お手数ですが再度送信いただくか、お電話(077-565-0021)までご連絡いただけますと幸いです。</p>
                        <div class="contactText__topLink">
                            <p class="contactForm__bt">
                                <a href="<?php echo HOME; ?>" class="contactForm__link ui-bg-main hoverDefault">トップへ戻る</a>
                            </p>
                        </div>
                        <div class="notes">
                            <p>※以下の場合は確認メールが届かない場合がありますのでご注意ください。</p>
                            <p>■フリーメールで登録する場合</p>
                            <p>■携帯メールで迷惑メール対策をされている場合</p>
                            <p>■ご登録いただいたメールアドレスが間違っている場合</p>
                            <p>■メールボックスの容量が一杯になっている場合</p>
                            <br>
                            <p>※ドメイン指定受信を設定されている方は「support@trustrate.co.jp」からのメールを受信できるように設定してください。</p>
                            <br>
                            <p>※携帯電話やフリーメールのメールアドレスでのご登録で、PCメールの受信拒否設定やURL付きメールの受信拒否設定をしている場合に、<br>受信フォルダでなく迷惑メールフォルダやゴミ箱にメールが振り分けられてしまい、確認メールの受信ができない可能性がございます。</p>
                            <br>
                            <p>お手数ですが、メールが届かない場合にはメール設定をご確認ください。</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- contentsEnd -->
    </div>
    <p class="footer_pagetop">
        <a href="#esbody" id="backtop" class="ui-bg-main" style="display: block;">
            <i class="fas fa-chevron-up icn_arrow"></i>
            <br>TOP
        </a>
    </p>
    <div class="l-footer ui-bg-main">
        <div class="footer__wrap">
            <div class="footCompany">
                <div class="footCompany__info">
                    <p class="footCompany__name">
                        草津市・栗東市・守山市での<br>不動産売却のことなら草津不動産売却テラスへ </p>
                    <p class="footCompany__address">
                        〒525-0032<br /> 滋賀県草津市大路３丁目1-33-2F&nbsp; </p>
                    <ul class="footCompany__list">
                        <li class="footCompany__item">
                            営業時間： 09:00～18:00 </li>
                        <li class="footCompany__item">
                            定休日： 土曜・日曜・祝日 </li>
                    </ul>
                </div>
            </div>
            <p class="oc-footer__copyright">
                Copyright(c) 株式会社トラストレイト All Rights Reserved.
            </p>
        </div>
    </div>   
</main>

<?php get_footer("contact");?>