  
<?php
/*
Template Name: Accessmap Template
*/

if( ! defined( 'ABSPATH' ) ) exit;
get_header();
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
?>  

<main>
    <div id="contents_outer">
        <ul id="path" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="<?php echo HOME; ?>">
                    <span itemprop="name">草津市・栗東市・守山市の不動産売却｜草津不動産売却テラス</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">アクセスマップ</span>
                <meta itemprop="position" content="2" />
            </li>
        </ul>
        <!-- contentsStart -->
        <div id="contents" class="clearfix">
            <div class="pageHead">
                <h1 class="pageHead__ttl ui-bd-main">
                    アクセスマップ 
                </h1>
            </div>

            <div id="accessMap">
                <div style="text-align: center">
                    <iframe width="100%" height="900" style="border: none;" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBOGZA41ZHhaazkbAY4xCjSsG0rXMiSmXA&q=35.01842608,135.96915305&zoom=16"></iframe>
                </div>
                <div class="companyInfo">
                    <div class="companyInfo__wrap">
                        <dl class="companyInfo__list">
                            <dt class="companyInfo__item">交通</dt>
                            <dd class="companyInfo__cont">
                                東海道・山陽本線 草津駅 10分 
                            </dd>
                        </dl>
                        <dl class="companyInfo__list">
                            <dt class="companyInfo__item">商号</dt>
                            <dd class="companyInfo__cont">
                                株式会社トラストレイト 
                            </dd>
                        </dl>
                        <dl class="companyInfo__list">
                            <dt class="companyInfo__item">所在地</dt>
                            <dd class="companyInfo__cont">
                                〒525-0032<br /> 滋賀県草津市大路３丁目1-33-2F&nbsp; 
                            </dd>
                        </dl>
                        <dl class="companyInfo__list">
                            <dt class="companyInfo__item">TEL</dt>
                            <dd class="companyInfo__cont">
                                077-565-0021 
                            </dd>
                        </dl>
                        <dl class="companyInfo__list">
                            <dt class="companyInfo__item">FAX</dt>
                            <dd class="companyInfo__cont">
                                077-565-0041 
                            </dd>
                        </dl>
                        <dl class="companyInfo__list">
                            <dt class="companyInfo__item">免許番号</dt>
                            <dd class="companyInfo__cont">
                                滋賀県知事 (2) 第3611号 
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="accessmap_conversion">
                    <div class="cont-otherContact">
                        <div class="contInner">
                            <p class="otherContact__catch">
                                まずはご相談ください！
                            </p>
                            <ul class="otherContact__list">
                                <li class="otherContact__item--satei">
                                    <a href="<?php echo HOME . 'assessment'; ?>" class="ui-bg-point hoverDefault" target="_blank" rel="nofollow">
                                        <i class="fas fa-calculator otherContact__icn--satei"></i>無料査定を依頼する
                                    </a>
                                </li>
                                <li class="otherContact__item--mail">
                                    <a href="<?php echo HOME . 'contact'; ?>" class="ui-bg-sub hoverDefault" target="_blank" rel="nofollow">
                                        <i class="far fa-envelope otherContact__icn--mail"></i>まずは無料相談する
                                    </a>
                                </li>
                            </ul>
                            <div class="otherContact__about">
                                <p class="otherContact__tel">
                                    <i class="fas fa-phone-alt ui-tx-sub otherContact__icn--tel"></i>077-565-0021 </p>
                                <div class="otherContact__company">
                                    <dl class="otherContact__info">
                                        <dt class="otherContact__name">営業時間</dt>
                                        <dd class="otherContact__text">
                                            09:00～18:00 </dd>
                                    </dl>
                                    <dl class="otherContact__info">
                                        <dt class="otherContact__name">定休日</dt>
                                        <dd class="otherContact__text">
                                            土曜・日曜・祝日 </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- contentsEnd -->
    </div>

    </main>

    <?php get_footer(); ?>