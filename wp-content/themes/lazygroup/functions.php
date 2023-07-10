<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// サイト情報
define( 'HOME', home_url( '/' ) );
define( 'TITLE', get_option( 'blogname' ) );

// 状態
define( 'IS_ADMIN', is_admin() );
define( 'IS_LOGIN', is_user_logged_in() );
define( 'IS_CUSTOMIZER', is_customize_preview() );

// テーマディレクトリパス
define( 'T_DIRE', get_template_directory() );
define( 'S_DIRE', get_stylesheet_directory() );
define( 'T_DIRE_URI', get_template_directory_uri() );
define( 'S_DIRE_URI', get_stylesheet_directory_uri() );

define( 'THEME_NOTE', 'trustrate' );

error_reporting(0);

flush_rewrite_rules();


// 固定ページとMW WP Formでビジュアルモードを使用しない
function stop_rich_editor($editor) {
    global $typenow;
    global $post;
    if(in_array($typenow, array('page', 'post', 'mw-wp-form'))) {
        $editor = true;
    }
    return $editor;
}

add_filter('user_can_richedit', 'stop_rich_editor');

// エディター独自スタイル追加
//TinyMCE追加用のスタイルを初期化
if(!function_exists('initialize_tinymce_styles')) {
    function initialize_tinymce_styles($init_array) {
        //追加するスタイルの配列を作成
        $style_formats = array(
            array(
                'title' => '注釈',
                'inline' => 'span',
                'classes' => 'cmn_note'
            )
        );
        //JSONに変換
        $init_array['style_formats'] = json_encode($style_formats);
        return $init_array;
    }
}

add_filter('tiny_mce_before_init', 'initialize_tinymce_styles', 10000);

// オプションページを追加
if(function_exists('acf_add_options_page')) {
    $option_page = acf_add_options_page(array(
        'page_title' => 'テーマオプション', // 設定ページで表示される名前
        'menu_title' => 'テーマオプション', // ナビに表示される名前
        'menu_slug' => 'top_setting',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

function my_script_constants() {
?>
    <script type="text/javascript">
        var templateUrl = '<?php echo S_DIRE_URI; ?>';
        var baseSiteUrl = '<?php echo HOME; ?>';
        var themeAjaxUrl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
    </script>
<?php
}

add_action('wp_head', 'my_script_constants');

function remove_default_post_type() { 
   remove_menu_page('edit.php');
}

add_action('admin_menu', 'remove_default_post_type'); 

// CSS・スクリプトの読み込み
function theme_add_files() {
    global $post;

    wp_enqueue_style('c-all', 'https://use.fontawesome.com/releases/v5.15.1/css/all.css', [], '1.0', 'all');
    wp_enqueue_style('c-font', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&amp;display=swap', [], '1.0', 'all');
    wp_enqueue_style('c-common', T_DIRE_URI.'/assets/css/common/common.css', [], '1.0', 'all');

    wp_enqueue_style('c-header', T_DIRE_URI.'/assets/css/header.css', [], '1.0', 'all');
    wp_enqueue_style('c-footer', T_DIRE_URI.'/assets/css/footer.css', [], '1.0', 'all');
    wp_enqueue_style('c-jquery-jscrollpane', T_DIRE_URI.'/assets/css/jquery.jscrollpane.css', [], '1.0', 'all');

    wp_enqueue_style('c-slick', T_DIRE_URI.'/assets/css/slick.css', [], '1.0', 'all');
    wp_enqueue_style('c-jquery-mCustomScrollbar', T_DIRE_URI.'/assets/css/jquery.mCustomScrollbar.css', [], '1.0', 'all');
    if ( is_front_page() ) {
        wp_enqueue_style('c-firstPage', T_DIRE_URI.'/assets/css/firstPage.css', [], '1.0', 'all');
        wp_enqueue_style('c-top', T_DIRE_URI.'/assets/css/top.css', [], '1.0', 'all');
    }
    if (get_page_template_slug() =='page-news.php') {
        wp_enqueue_style('c-news', T_DIRE_URI.'/assets/css/topics.css', [], '1.0', 'all');
    }
    
    if (get_page_template_slug() =='page-accessmap.php' )  {
        wp_enqueue_style('c-firstPage', T_DIRE_URI.'/assets/css/accessmap.css', [], '1.0', 'all');
    }

    if (get_page_template_slug() =='page-company.php' )  {
        wp_enqueue_style('c-fancybox', T_DIRE_URI.'/assets/css/jquery.fancybox.css', [], '1.0', 'all');
        wp_enqueue_style('c-company', T_DIRE_URI.'/assets/css/company.css', [], '1.0', 'all');
    }
    
    if (get_page_template_slug() =='page-bknlist.php' )  {
        wp_enqueue_style('c-bknlist', T_DIRE_URI.'/assets/css/bknlist.css', [], '1.0', 'all');
    }

    if( $post->post_type == "bknlist" && is_archive() || is_tax() ) {
        wp_enqueue_style('c-bknlist', T_DIRE_URI.'/assets/css/bknlist.css', [], '1.0', 'all');
    }

    if ($post->post_type == "bknlist" && is_single() )  {
        wp_enqueue_style('c-bkn-movie-contents', T_DIRE_URI.'/assets/css/bkn/detail/movie-contents.css', [], '1.0', 'all');
        wp_enqueue_style('c-bkn-colorbox', T_DIRE_URI.'/assets/css/bkn/detail/colorbox.css', [], '1.0', 'all');
        wp_enqueue_style('c-bkn-common', T_DIRE_URI.'/assets/css/bkn/common.css', [], '1.0', 'all');
        wp_enqueue_style('c-bkn-roominfo', T_DIRE_URI.'/assets/css/bkn/detail/roominfo.css', [], '1.0', 'all');
        wp_enqueue_style('c-bkn-fullscreen', T_DIRE_URI.'/assets/css/bkn/detail/fullscreen.css', [], '1.0', 'all');
        wp_enqueue_style('c-bkn-photo', T_DIRE_URI.'/assets/css/bkn/photo.css', [], '1.0', 'all');
        wp_enqueue_style('c-bkn-detailinfo', T_DIRE_URI.'/assets/css/bkn/detailinfo.css', [], '1.0', 'all');
        wp_enqueue_style('c-bkn-facility', T_DIRE_URI.'/assets/css/bkn/facility.css', [], '1.0', 'all');
        wp_enqueue_style('c-bkn-company', T_DIRE_URI.'/assets/css/bkn/company.css', [], '1.0', 'all');
        wp_enqueue_style('c-bkn-simulation', T_DIRE_URI.'/assets/css/bkn/detail/simulation.css', [], '1.0', 'all');
    }
    

    if( $post->post_type == "blog" && is_archive() || is_tax() ) {
        wp_enqueue_style('c-cms', T_DIRE_URI.'/assets/css/cms.css', [], '1.0', 'all');
        wp_enqueue_style('c-categorytaglist', T_DIRE_URI.'/assets/css/categorytaglist.css', [], '1.0', 'all');
    }

    if ($post->post_type == "news" && is_archive() || is_tax()) {
        wp_enqueue_style('c-news', T_DIRE_URI.'/assets/css/topics.css', [], '1.0', 'all');
    }
    
    if (get_page_template_slug() =='page-blog.php' )  {
        wp_enqueue_style('c-cms', T_DIRE_URI.'/assets/css/cms.css', [], '1.0', 'all');
        wp_enqueue_style('c-categorytaglist', T_DIRE_URI.'/assets/css/categorytaglist.css', [], '1.0', 'all');
    }

    if ($post->post_type == "blog" && is_single() )  {
        wp_enqueue_style('c-cms-1', T_DIRE_URI.'/assets/css/cms1.css', [], '1.0', 'all');
        wp_enqueue_style('c-cms', T_DIRE_URI.'/assets/css/cms.css', [], '1.0', 'all');
    }
    
    if (get_page_template_slug() =='page-assessment.php')  {
        wp_enqueue_style('c-validationEngine', T_DIRE_URI.'/assets/css/validationEngine.jquery.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-common', T_DIRE_URI.'/assets/css/contact_common.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-footer', T_DIRE_URI.'/assets/css/contact-footer.css', [], '1.0', 'all');
        wp_enqueue_style('c-assessment', T_DIRE_URI.'/assets/css/assessment.css', [], '1.0', 'all');
    }

    if (get_page_template_slug() =='page-assessment-confirm.php')  {
        wp_enqueue_style('c-validationEngine', T_DIRE_URI.'/assets/css/validationEngine.jquery.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-common', T_DIRE_URI.'/assets/css/contact_common.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-footer', T_DIRE_URI.'/assets/css/contact-footer.css', [], '1.0', 'all');
        wp_enqueue_style('c-assessment', T_DIRE_URI.'/assets/css/assessment.css', [], '1.0', 'all');
        wp_enqueue_style('c-assessment_confirm', T_DIRE_URI.'/assets/css/assessment_confirm.css', [], '1.0', 'all');
    }

    if ( get_page_template_slug() =='page-assessment-thankyou.php' ) {
        wp_enqueue_style('c-validationEngine', T_DIRE_URI.'/assets/css/validationEngine.jquery.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact', T_DIRE_URI.'/assets/css/contact.css', [], '1.0', 'all');
        wp_enqueue_style('c-thankyou', T_DIRE_URI.'/assets/css/thankyou.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-common', T_DIRE_URI.'/assets/css/contact_common.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-footer', T_DIRE_URI.'/assets/css/contact-footer.css', [], '1.0', 'all');
    }
    
    if (get_page_template_slug() =='page-contact.php' || get_page_template_slug() =='page-contact-confirm.php')  {
        wp_enqueue_style('c-validationEngine', T_DIRE_URI.'/assets/css/validationEngine.jquery.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact', T_DIRE_URI.'/assets/css/contact.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-common', T_DIRE_URI.'/assets/css/contact_common.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-footer', T_DIRE_URI.'/assets/css/contact-footer.css', [], '1.0', 'all');
    }

    if ( get_page_template_slug() =='page-contact-thankyou.php' ) {
        wp_enqueue_style('c-validationEngine', T_DIRE_URI.'/assets/css/validationEngine.jquery.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact', T_DIRE_URI.'/assets/css/contact.css', [], '1.0', 'all');
        wp_enqueue_style('c-thankyou', T_DIRE_URI.'/assets/css/thankyou.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-common', T_DIRE_URI.'/assets/css/contact_common.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-footer', T_DIRE_URI.'/assets/css/contact-footer.css', [], '1.0', 'all');
    }

    if (get_page_template_slug() =='page-bkncontact.php' || get_page_template_slug() =='page-bkncontact-confirm.php' )  {
        wp_enqueue_style('c-validationEngine', T_DIRE_URI.'/assets/css/validationEngine.jquery.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact_bkn', T_DIRE_URI.'/assets/css/contact_bkn.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-common', T_DIRE_URI.'/assets/css/contact_common.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-footer', T_DIRE_URI.'/assets/css/contact-footer.css', [], '1.0', 'all');
    }

    if ( get_page_template_slug() =='page-bkncontact-thankyou.php' ) {
        wp_enqueue_style('c-validationEngine', T_DIRE_URI.'/assets/css/validationEngine.jquery.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact_bkn', T_DIRE_URI.'/assets/css/contact_bkn.css', [], '1.0', 'all');
        wp_enqueue_style('c-thankyou', T_DIRE_URI.'/assets/css/thankyou.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-common', T_DIRE_URI.'/assets/css/contact_common.css', [], '1.0', 'all');
        wp_enqueue_style('c-contact-footer', T_DIRE_URI.'/assets/css/contact-footer.css', [], '1.0', 'all');
    }

    if (get_page_template_slug() =='page-sitemap.php' )  {
        wp_enqueue_style('c-sitemap', T_DIRE_URI.'/assets/css/sitemap.css', [], '1.0', 'all');
    }
    if (get_page_template_slug() =='page-rule.php' )  {
        wp_enqueue_style('c-rule', T_DIRE_URI.'/assets/css/rule.css', [], '1.0', 'all');
    }
    if (get_page_template_slug() =='page-privacy.php' )  {
        wp_enqueue_style('c-privacy', T_DIRE_URI.'/assets/css/privacy.css', [], '1.0', 'all');
    }

    wp_enqueue_style('c-theme', T_DIRE_URI.'/style.css', [], '1.0', 'all');

    // WordPress本体のjquery.jsを読み込まない
    if(!is_admin()) {
        wp_deregister_script('jquery');
    }

    wp_enqueue_script('s-jquery', T_DIRE_URI.'/assets/js/jquery-1.8.2.min.js', [], '1.0', false);
    wp_enqueue_script('s-imgLiquid', T_DIRE_URI.'/assets/js/imgLiquid-min.js', [], '1.0', true);
    wp_enqueue_script('s-common_library', T_DIRE_URI.'/assets/js/common_library.js', [], '1.0', true);
    wp_enqueue_script('s-jquerypngfix', T_DIRE_URI.'/assets/js/jquerypngfix.js', [], '1.0', true);
    wp_enqueue_script('s-jquery-ui', T_DIRE_URI.'/assets/js/jquery-ui.min.js', [], '1.0', true);
    wp_enqueue_script('s-mCustomScrollbar', T_DIRE_URI.'/assets/js/jquery.mCustomScrollbar.js', [], '1.0', true);
    wp_enqueue_script('s-page-scroller-306', T_DIRE_URI.'/assets/js/jquery.page-scroller-306.js', [], '1.0', true);
    wp_enqueue_script('s-mousewheel', T_DIRE_URI.'/assets/js/jquery.mousewheel.js', [], '1.0', true);
    wp_enqueue_script('s-jscrollpane', T_DIRE_URI.'/assets/js/jquery.jscrollpane.min.js', [], '1.0', true);
    wp_enqueue_script('s-slick', T_DIRE_URI.'/assets/js/slick.min.js', [], '1.0', true);
    wp_enqueue_script('s-common', T_DIRE_URI.'/assets/js/common.js', [], '1.0', true);
    if ( is_front_page() ) {
        wp_enqueue_script('s-top_custom', T_DIRE_URI.'/assets/js/top_custom.js', [], '1.0', true);
    }

    if ($post->post_type == "bknlist" && is_single() )  {
        wp_enqueue_script('s-bkn-room2', T_DIRE_URI.'/assets/js/bkn/room2.js', [], '1.0', true);
        wp_enqueue_script('s-bkn-change', T_DIRE_URI.'/assets/js/bkn/change.js', [], '1.0', true);
        wp_enqueue_script('s-bkn-fullscreen', T_DIRE_URI.'/assets/js/jquery.fullscreen.js', [], '1.0', true);
        wp_enqueue_script('s-bkn-colorbox', T_DIRE_URI.'/assets/js/jquery.colorbox.js', [], '1.0', true);
        wp_enqueue_script('s-bkn-simulation', T_DIRE_URI.'/assets/js/simulation.js', [], '1.0', true);
    }
}

add_action('wp_enqueue_scripts', 'theme_add_files');

/**
 * Use radio inputs instead of checkboxes for term checklists in specified taxonomies.
 *
 * @param   array   $args
 * @return  array
 */
function custom_term_radio_checklist( $args ) {
    if ( ! empty( $args['taxonomy'] ) && $args['taxonomy'] === 'product' || $args['taxonomy'] === 'category' ) {
        if ( empty( $args['walker'] ) || is_a( $args['walker'], 'Walker' ) ) { 
            if ( ! class_exists( 'WPSE_139269_Walker_Category_Radio_Checklist' ) ) {
                class WPSE_139269_Walker_Category_Radio_Checklist extends Walker_Category_Checklist {
                    function walk( $elements, $max_depth, ...$args ) {
                        $output = parent::walk( $elements, $max_depth, ...$args );
                        $output = str_replace(
                            array( 'type="checkbox"', "type='checkbox'" ),
                            array( 'type="radio"', "type='radio'" ),
                            $output
                        );

                        return $output;
                    }
                }
            }

            $args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist;
        }
    }

    return $args;
}

add_filter( 'wp_terms_checklist_args', 'custom_term_radio_checklist' );

function theme_custom_setup() {
    add_theme_support( 'post-thumbnails' ); 
    add_image_size( "blog-thumbnail", 255, 200, true );
    add_image_size( "blog-medium", 332, 230, true );
    add_image_size( "bknlist-thumbnail", 288, 216, true );
    add_image_size( "news-thumbnail", 100, 75, true );
    set_post_thumbnail_size( 255, 200, true );
    add_editor_style('https://use.fontawesome.com/releases/v5.15.1/css/all.css');
    add_editor_style('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&amp;display=swap');
    add_editor_style('assets/css/all.css');
    add_editor_style('assets/css/common.css');
    add_editor_style('assets/css/slick.css');
    add_editor_style('assets/css/jquery.jscrollpane.css');
    add_editor_style('assets/css/jquery.mCustomScrollbar.css');
    add_editor_style('assets/css/firstPage.css');
    add_editor_style('assets/css/top.css');

    add_editor_style('assets/css/fancybox.css');
    add_editor_style('assets/css/company.css');

    add_theme_support( 'automatic-feed-links' );
}

add_action( 'after_setup_theme', 'theme_custom_setup' );

function catch_that_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];

    if(empty($first_img)){ //Defines a default image
        $first_img = "/assets/img/common/no_image.jpg";
    }
    return $first_img;
}

function custom_pagination($total_pages, $current_page = 1, $total_counts = 0) {
    global $wp_query;

    $big = 99999999; // set a big number for the links

    $paginate_links = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, $current_page),
        'total' => $total_pages,
        'type' => 'array',
        'prev_text' => __('&lt; 前へ'),
        'next_text' => __('次へ &gt;'),
        'show_all' => true,
        'end_size' => 3,
        'mid_size' => 3
    ));

    $first_number = $total_counts == 0 ? 0 : ($current_page - 1) * 20 + 1;
    $secode_number = ($current_page * 20) > $total_counts ? $total_counts : ($current_page * 20);
?>
    
    <div class="pager">
        <p class="pager__num"<?php echo $paginate_links ? '' : ' style="margin-right: 0;"'; ?>>該当公開件数<span class="pager__num--point ui-tx-point"><?php echo $total_counts; ?>件</span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $first_number; ?>～<?php echo $secode_number; ?>件表示</p>
        <?php if ($paginate_links) : ?>
            <ul class="pager__wrap">
                <?php foreach ($paginate_links as $link) : ?>
                    <li class="pager__bt"><?php echo $link; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php
}

add_filter( 'previous_post_link', 'filter_single_post_pagination', 10, 4 );
add_filter( 'next_post_link',     'filter_single_post_pagination', 10, 4 );

function filter_single_post_pagination( $output, $format, $link, $post )
{
    if( $post ) {
        $title = get_the_title( $post );
        $url   = get_permalink( $post->ID );
        ob_start();
        if ( 'next_post_link' === current_filter() ) :
        ?>
        <p class="blogPager__item--next">
            <a href="<?php echo $url; ?>" class="hoverDefault">
                <span class="blogPager__ttl"><?php echo $title; ?></span>
                <i class="fas fa-chevron-right blogPager__arw"></i>
            </a>
        </p>
        <?php else : ?>
            <p class="blogPager__item--prev">
                <a href="<?php echo $url; ?>" class="hoverDefault">
                    <i class="fas fa-chevron-left blogPager__arw"></i>
                    <span class="blogPager__ttl"><?php echo $title; ?></span>
                </a>
            </p>
        <?php endif; ?>
        <?php

        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    return false;
}

// // Set the excerpt from the post content
// function set_custom_excerpt($excerpt) {
//     if (has_excerpt()) {
//         return $excerpt;
//     }
//     $content = get_the_content();
//     $excerpt_length = apply_filters('excerpt_length', 55); // Set the desired excerpt length
//     $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]'); // Set the desired excerpt more indicator
//     $excerpt = wp_trim_words($content, $excerpt_length, $excerpt_more);
//     return $excerpt;
// }
// add_filter('the_excerpt', 'set_custom_excerpt');

// function disable_wp_auto_p( $content ) {
//     if ( is_singular( 'page' ) ) {
//       remove_filter( 'the_content', 'wpautop' );
//     }
//     remove_filter( 'the_excerpt', 'wpautop' );
//     return $content;
// }

// add_filter( 'the_content', 'disable_wp_auto_p', 0 );

function new_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {
    return '...';
}

add_filter('excerpt_more', 'new_excerpt_more');

?>