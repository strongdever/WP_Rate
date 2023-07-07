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

function theme_custom_setup() {
    add_theme_support( 'post-thumbnails' ); 
    add_image_size( "thumbnail", 150, 100, true );
    add_image_size( "medium", 480, 320, true );
    set_post_thumbnail_size( 480, 320, true );
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

add_shortcode('url', function ( $atts ) {
    if(isset($atts['arg'])) {
        return site_url($atts['arg']);
    }
    return get_theme_file_uri();
} );

?>