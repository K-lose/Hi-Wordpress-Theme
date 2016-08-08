<?php
// 注册导航
register_nav_menus();

//wordpress标题
function Bing_add_theme_support_title(){
        add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'Bing_add_theme_support_title' );

//替换Gavatar头像地址
function get_ssl_avatar($avatar) {
    if (preg_match_all(
        '/(src|srcset)=["\']https?.*?\/avatar\/([^?]*)\?s=([\d]+)&([^"\']*)?["\']/i',
        $avatar,
        $matches
    ) > 0) {
        $url = 'https://secure.gravatar.com';
        $size = $matches[3][0];
        $vargs = array_pad(array(), count($matches[0]), array());
        for ($i = 1; $i < count($matches); $i++) {
            for ($j = 0; $j < count($matches[$i]); $j++) {
                $tmp = strtolower($matches[$i][$j]);
                $vargs[$j][] = $tmp;
                if ($tmp == 'src') {
                    $size = $matches[3][$j];
                }
            }
        }
        $buffers = array();
        foreach ($vargs as $varg) {
            $buffers[] = vsprintf(
            '%s="%s/avatar/%s?s=%s&%s"',
            array($varg[0], $url, $varg[1], $varg[2], $varg[3])
           );
        }
        return sprintf(
                '<img alt="avatar" %s class="avatar avatar-%s" height="%s" width="%s" />',
                implode(' ', $buffers), $size, $size, $size
            );
    } else {
        return false;
    }
}
add_filter('get_avatar', 'get_ssl_avatar');
// 优化代码
remove_action( 'wp_head', 'feed_links_extra', 3 ); // 额外的feed,例如category, tag页
remove_action( 'wp_head', 'wp_generator' ); //隐藏wordpress版本
remove_filter('the_content', 'wptexturize'); //取消标点符号转义
remove_action( 'admin_print_scripts',	'print_emoji_detection_script'); // 禁用Emoji表情
remove_action( 'admin_print_styles',	'print_emoji_styles');
remove_action( 'wp_head',		'print_emoji_detection_script',	7);
remove_action( 'wp_print_styles',	'print_emoji_styles');
remove_filter( 'the_content_feed',	'wp_staticize_emoji');
remove_filter( 'comment_text_rss',	'wp_staticize_emoji');
remove_filter( 'wp_mail',		'wp_staticize_emoji_for_email');
add_filter('login_errors', create_function('$a', "return null;")); //取消登录错误提示
add_filter( 'show_admin_bar', '__return_false' ); //删除AdminBar
if ( function_exists('add_theme_support') )add_theme_support('post-thumbnails'); //添加特色缩略图支持
// 禁止wp-embed.min.js
function disable_embeds_init() {
    global $wp;
    $wp->public_query_vars = array_diff( $wp->public_query_vars, array(
        'embed',
    ) );
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );
    add_filter( 'embed_oembed_discover', '__return_false' );
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
}
add_action( 'init', 'disable_embeds_init', 9999 );
function disable_embeds_tiny_mce_plugin( $plugins ) {
    return array_diff( $plugins, array( 'wpembed' ) );
}
function disable_embeds_rewrites( $rules ) {
    foreach ( $rules as $rule => $rewrite ) {
        if ( false !== strpos( $rewrite, 'embed=true' ) ) {
            unset( $rules[ $rule ] );
        }
    }
    return $rules;
}
function disable_embeds_remove_rewrite_rules() {
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );
function disable_embeds_flush_rewrite_rules() {
    remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );

// 阻止站内文章互相Pingback 
function theme_noself_ping( &$links ) { 
$home = get_option( 'home' );
foreach ( $links as $l => $link )
if ( 0 === strpos( $link, $home ) )
unset($links[$l]); 
}
add_action('pre_ping','theme_noself_ping');
?>