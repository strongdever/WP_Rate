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
    // wp_enqueue_style('c-footer', T_DIRE_URI.'/assets/css/footer.css', [], '1.0', 'all');
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
    add_theme_support( 'automatic-feed-links' );
}

add_action( 'after_setup_theme', 'theme_custom_setup' );

function replaceImagePath( $arg ) {
    $content = str_replace('"images/', '"' . T_DIRE_URI . '/assets/img/', $arg);
    $content = str_replace('"/images/', '"' . T_DIRE_URI . '/assets/img/', $content);
    $content = str_replace(', images/', ', ' . T_DIRE_URI . '/assets/img/', $content);
    $content = str_replace("('images/", "('". T_DIRE_URI . '/assets/img/', $content);
    return $content;
}

add_action('the_content', 'replaceImagePath');

function disable_wp_auto_p( $content ) {
    if ( is_singular( 'page' ) ) {
      remove_filter( 'the_content', 'wpautop' );
    }
    remove_filter( 'the_excerpt', 'wpautop' );
    return $content;
}

add_filter( 'the_content', 'disable_wp_auto_p', 0 );

add_filter('wpcf7_autop_or_not', '__return_false');

add_filter('query_vars', function($vars) {
	$vars[] = 'news_category';
	return $vars;
});

add_filter( 'wpcf7_validate_email*', 'custom_email_confirmation_validation_filter', 20, 2 );
  
function custom_email_confirmation_validation_filter( $result, $tag ) {
  if ( 'your-email-confirm' == $tag->name ) {
    $your_email = isset( $_POST['your-email'] ) ? trim( $_POST['your-email'] ) : '';
    $your_email_confirm = isset( $_POST['your-email-confirm'] ) ? trim( $_POST['your-email-confirm'] ) : '';
  
    if ( $your_email != $your_email_confirm ) {
      $result->invalidate( $tag, "これが正しいメールアドレスですか？" );
    }
  }
  
  return $result;
}

function catch_that_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $post->post_content, $matches);
    $first_img = $matches[1][0];
  
    if(empty($first_img)) {
      $first_img = T_DIRE_URI . "/assets/img/common/no_image.jpg";
    }
    return $first_img;
  }

//add SVG to allowed file uploads
function add_file_types_to_uploads($file_types){

    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );

    return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');

function taxonomy_checklist_checked_ontop_filter ($args) {
    $args['checked_ontop'] = false;
    return $args;
}

add_filter('wp_terms_checklist_args','taxonomy_checklist_checked_ontop_filter');

function new_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {
    return '...';
}

add_filter('excerpt_more', 'new_excerpt_more');

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

function wp_set_post_views( $postID ) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta( $postID, $count_key, true );

    if( $count == '' ) {
        $count = 0;
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
    } else {
        $count++;
        update_post_meta( $postID, $count_key, $count );
    }
}

function wp_get_post_views( $content ) {
    if ( is_single() ) {
        wp_set_post_views(get_the_ID());
    }
    return $content;
}
add_filter( 'the_content', 'wp_get_post_views' );

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

function bkn_table_data( $attr ) {

    $args = shortcode_atts( array(
        'id' => 1,
    ), $attr );
    
    ob_start();
    $bkn_id = $args['id'];

    $custom_args = array(
        'post_type' => 'bknlist',
        'post_status' => 'publish',
        'post__in' => [$bkn_id],
    );
    $custom_query = new WP_Query( $custom_args );
    if( $custom_query->have_posts() ) :
        while ( $custom_query->have_posts() ) : $custom_query->the_post();
    ?>
        <div class="contactBkn">
            <p class="contactBkn__image">
                <?php if( has_post_thumbnail() ): ?>
                    <?php the_post_thumbnail("bknlist-thumbnail"); ?>
                <?php else: ?>
                    <img src="<?php echo catch_that_image(); ?>" alt="<?php the_title(); ?>">
                <?php endif; 
                get_post_thumb
                ?>
            </p>
            <table class="contactBkn__information">
                <tbody>
                    <tr>
                        <th>価格</th>
                        <th>間取り</th>
                        <th>建物面積</th>
                        <th>土地面積</th>
                    </tr>
                    <tr>
                        <td class="contactBkn__information--price">
                        <span class="basicInfo__price"><?php echo number_format( get_field('property_price') ); ?>万円</span> </td>
                        <td><?php echo get_field('property_floorplan') ? get_field('property_floorplan') : '-'; ?></td>
                        <td><?php echo get_field('property_buildingarea') ? get_field('property_buildingarea') : '-'; ?></td>
                        <td><?php echo get_field('property_landarea') ? get_field('property_landarea') : '-'; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

add_shortcode('bkn-simple-data', 'bkn_table_data');

function custom_post_news( $attr ) {

    $args = shortcode_atts( array(
        'count' => 5,

    ), $attr );
    
    ob_start();

    $news_args = [
        'post_type' => 'news',
        'post_status' => 'publish',
        'posts_per_page' => $args['count'],
    ];

    $news_query = new WP_Query( $news_args );

    ?>
    <?php if( $news_query->have_posts() ) : ?>
        <div class="p_news_list_container content_in">
            <div class="p_news_list">
                <?php while( $news_query->have_posts() ) : $news_query->the_post(); ?>
                    <div class="p_news_item" data-aos="fade-up" data-aos-delay="150">
                        <p class="news_date"><?php the_time("Y.m.d"); ?></p>
                        <h4 class="news_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            <div class="p_link_btn_wrap" data-aos="fade-up" data-aos-delay="300">
                <a href="<?php echo HOME . 'news'; ?>" class="link_btn ml_auto">
                    <span>すベての記事を見る</span>
                    <picture class="icon_arrow">
                        <source media="(min-width:769px)" srcset="<?php echo T_DIRE_URI; ?>/assets/img/common/arrow-right-pc.png">
                        <source media="(max-width:768px)" srcset="<?php echo T_DIRE_URI; ?>/assets/img/common/arrow-right-sp.png">
                        <img src="<?php echo T_DIRE_URI; ?>/assets/img/common/arrow-right-pc.png" alt="">
                    </picture>
                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

add_shortcode('post-news', 'custom_post_news');

?>