<?php
/*
Template Name: Assessment Confirm Template
*/

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

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

            <div id="baikyakuInput" name="baikyakuInput" method="post">
                <div id="contact-section" class="input-contact">

                    <ul class="contactStatus">
                        <li class="contactStatus__item--1">
                            入力
                        </li>
                        <li class="contactStatus__item--2 ui-bg-sub is-active">
                            確認
                        </li>
                        <li class="contactStatus__item--3">
                            送信
                        </li>
                    </ul>

                    <?php the_content() ?>
                    
                </div>
            </div>

        </div>
        <!-- contentsEnd -->
    </div>    
    
</main>

<?php get_footer();?>