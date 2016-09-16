<?php
/* 
Theme: iDevise 1
Name: 设计笔记 Devise 系列主题
Site: http://www.idevs.cn
*/
require get_template_directory() . '/ajax-comment/do.php';//ajax评论
function dopt($e){return stripslashes(get_option($e));}
//---- 主题设置接口 -
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
function extra_user_profile_fields( $user ) { ?>
<h3>主题设置</h3>
<table class="form-table">

<tr>
<th><label for="alipay">支付宝</label></th>
<td><input type="text" name="alipay" id="alipay" value="<?php esc_attr_e( get_the_author_meta( 'alipay', $user->ID ) ); ?>" placeholder="用于收款二维码图片地址" class="regular-text">
</td>
</tr>
<tr>
<th><label for="wechatpay">微信</label></th>
<td><input type="text" name="wechatpay" id="wechatpay" value="<?php esc_attr_e( get_the_author_meta( 'wechatpay', $user->ID ) ); ?>" placeholder="用于收款二维码图片地址" class="regular-text">
</td>
</tr>

<tr>
<th><label for="weibo">新浪微博</label></th>
<td><input type="text" name="weibo" id="weibo" value="<?php esc_attr_e( get_the_author_meta( 'weibo', $user->ID ) ); ?>" class="regular-text"></td>
</tr>
<tr>
<th><label for="tencent">腾讯QQ</label></th>
<td><input type="text" name="tencent" id="tencent" value="<?php esc_attr_e( get_the_author_meta( 'tencent', $user->ID ) ); ?>" class="regular-text"></td>
</tr>
<tr>
<th><label for="douban">豆瓣</label></th>
<td><input type="text" name="douban" id="douban" value="<?php esc_attr_e( get_the_author_meta( 'douban', $user->ID ) ); ?>" class="regular-text"></td>
</tr>
<tr>
<th><label for="zhihu">知乎</label></th>
<td><input type="text" name="zhihu" id="zhihu" value="<?php esc_attr_e( get_the_author_meta( 'zhihu', $user->ID ) ); ?>" class="regular-text"></td>
</tr>
<tr>
<th><label for="github">GitHub</label></th>
<td><input type="text" name="github" id="github" value="<?php esc_attr_e( get_the_author_meta( 'github', $user->ID ) ); ?>" class="regular-text"></td>
</tr>

<tr>
<th><label for="mylinks">友情链接</label></th>
<td>
<textarea name="mylinks" id="mylinks" rows="5" cols="30"><?php esc_attr_e( get_the_author_meta( 'mylinks', $user->ID ) ); ?></textarea>
<p class="description">每行一条，例：<br/><code>&lt;li&gt;&lt;a target="_blank" href="http://idevs.cn/"&gt;设计笔记&lt;/a&gt;&lt;/li&gt;</code></p>
</td>
</tr>
<tr>
<th><label for="ol_code">需要重载的代码</label></th>
<td>
<textarea name="ol_code" id="ol_code" rows="5" cols="30"><?php esc_attr_e( get_the_author_meta( 'ol_code', $user->ID ) ); ?></textarea>
<p class="description">可以使用CNZZ、百度统计、腾讯分析的统计代码，也可以放置需要重载的js代码（页脚隐藏）。</p>
</td>
</tr>
<tr>
<th><label for="my_code">自定义代码或引用</label></th>
<td>
<textarea name="my_code" id="my_code" rows="5" cols="30"><?php esc_attr_e( get_the_author_meta( 'my_code', $user->ID ) ); ?></textarea>
<p class="description">可以放置css、js脚本，也可以引入第三方js或者css样式（此处代码不会被重载且页脚隐藏）。</p>
</td>
</tr>
</table>
<?php }
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
function save_extra_user_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
	//更新
	update_usermeta( $user_id, 'alipay', $_POST['alipay'] );
	update_usermeta( $user_id, 'wechatpay', $_POST['wechatpay'] );
	update_usermeta( $user_id, 'weibo', $_POST['weibo'] );
	update_usermeta( $user_id, 'tencent', $_POST['tencent'] );
	update_usermeta( $user_id, 'douban', $_POST['douban'] );
	update_usermeta( $user_id, 'zhihu', $_POST['zhihu'] );
	update_usermeta( $user_id, 'github', $_POST['github'] );
	update_usermeta( $user_id, 'mylinks', $_POST['mylinks'] );
	update_usermeta( $user_id, 'ol_code', $_POST['ol_code'] );
	update_usermeta( $user_id, 'my_code', $_POST['my_code'] );
}
//---- 主题设置结束 -

// 注册菜单
if (function_exists('register_nav_menus')){
register_nav_menus( array(
   'header_nav' => __('站点导航')
//,'footer_nav' => __('底部菜单')
) );
}
// 引入AJAX
add_action('wp_ajax_nopriv_load_postlist', 'load_postlist_callback');
add_action('wp_ajax_load_postlist', 'load_postlist_callback');
function load_postlist_callback(){
$postlist = '';
$paged = $_POST["paged"];
$total = $_POST["total"];
$category = $_POST["category"];
$author = $_POST["author"];
$tag = $_POST["tag"];
$search = $_POST["search"];
$year = $_POST["year"];
$month = $_POST["month"];
$day = $_POST["day"];
$query_args = array(
"posts_per_page" => get_option('posts_per_page'),
"cat" => $category,
"tag" => $tag,
"author" => $author,
"post_status" => "publish",
"post_type" => "post",
"paged" => $paged,
"s" => $search,
"year" => $year,
"monthnum" => $month,
"day" => $day
);
$the_query = new WP_Query( $query_args );
while ( $the_query->have_posts() ){
$the_query->the_post();
$postlist .= make_post_section();
}
$code = $postlist ? 200 : 500;
wp_reset_postdata();
$next = ( $total > $paged )? ( $paged + 1 ) : '' ;
echo json_encode(array('code'=>$code,'postlist'=>$postlist,'next'=> $next));
die;
}

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
// 移除菜单冗余代码
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
return is_array($var) ? array_intersect($var, array('current-menu-item','current-post-ancestor','current-menu-ancestor','current-menu-parent')) : '';
}
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
// Gravatar头像使用中国服务器
function gravatar_cn( $url ){ 
$gravatar_url = array('0.gravatar.com','1.gravatar.com','2.gravatar.com');
return str_replace( $gravatar_url, 'cn.gravatar.com', $url );
}
add_filter( 'get_avatar_url', 'gravatar_cn', 4 );
// 阻止站内文章互相Pingback 
function theme_noself_ping( &$links ) { 
$home = get_option( 'home' );
foreach ( $links as $l => $link )
if ( 0 === strpos( $link, $home ) )
unset($links[$l]); 
}
add_action('pre_ping','theme_noself_ping');
// 网页标题
function Bing_add_theme_support_title(){ 
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'Bing_add_theme_support_title' );
// 编辑器增强
 function enable_more_buttons($buttons) { 
 $buttons[] = 'hr'; 
 $buttons[] = 'del'; 
 $buttons[] = 'sub'; 
 $buttons[] = 'sup';
 $buttons[] = 'fontselect';
 $buttons[] = 'fontsizeselect';
 $buttons[] = 'cleanup';
 $buttons[] = 'styleselect';
 $buttons[] = 'wp_page';
 $buttons[] = 'anchor'; 
 $buttons[] = 'backcolor'; 
 return $buttons;
 } 
add_filter("mce_buttons_3", "enable_more_buttons");
// 拦截机器评论
class anti_spam { 
function anti_spam() {
if ( !current_user_can('level_0') ) {
add_action('template_redirect', array($this, 'w_tb'), 1);
add_action('init', array($this, 'gate'), 1);
add_action('preprocess_comment', array($this, 'sink'), 1);
}
}
function w_tb() {
if ( is_singular() ) {
ob_start(create_function('$input','return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#",
"textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>",$input);') );
}
}
function gate() {
if ( !empty($_POST['w']) && empty($_POST['comment']) ) {
$_POST['comment'] = $_POST['w'];
} else {
$request = $_SERVER['REQUEST_URI'];
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '隐瞒';
$IP= isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] . ' (透过代理)' : $_SERVER["REMOTE_ADDR"];
$way = isset($_POST['w'])? '手动操作' : '未经评论表格';
$spamcom = isset($_POST['comment'])? $_POST['comment']: null;
$_POST['spam_confirmed'] = "请求: ". $request. "\n来路: ". $referer. "\nIP: ". $IP. "\n方式: ". $way. "\n內容: ". $spamcom. "\n -- 已备案 --";
}
}
function sink( $comment ) {
if ( !empty($_POST['spam_confirmed']) ) {
if ( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment;
// 方法一: 直接挡掉, 將 die();
die();
// 方法二: 标记为 spam, 留在资料库检查是否误判.
// add_filter('pre_comment_approved', create_function('', 'return "spam";'));
// $comment['comment_content'] = "[ 防火墙提示：此条评论疑似Spam! ]\n". $_POST['spam_confirmed'];
}
return $comment;
	}
	}
	$anti_spam = new anti_spam();

function scp_comment_post( $incoming_comment ) { // 纯英文评论拦截
if(!preg_match('/[一-龥]/u', $incoming_comment['comment_content'])) exit('<p><span style="color:#f55;">提交失败：</span>评论必须包含中文（Chinese），请再次尝试！</p>');
//die(); // 直接挡掉，无提示
return( $incoming_comment );
}
add_filter('preprocess_comment', 'scp_comment_post');
// 评论@回复
function idevs_comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }

  return $comment_text;
}
add_filter( 'comment_text' , 'idevs_comment_add_at', 20, 2);
// 评论邮件延迟
add_action('comment_post', 'comment_mail_schedule');
function comment_mail_schedule($comment_id){
    wp_schedule_single_event( time()+60, 'comment_mail_event',array($comment_id));
}
add_action('comment_mail_event','comment_mail_notify');
// 评论邮件通知
function comment_mail_notify($comment_id) { 
$comment = get_comment($comment_id);
$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
$spam_confirmed = $comment->comment_approved;
if (($parent_id != '') && ($spam_confirmed != 'spam') && (!get_comment_meta($parent_id,'_deny_email',true)) && (get_option('admin_email') != get_comment($parent_id)->comment_author_email)) {
$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); //可以修改为你自己的邮箱地址
$to = trim(get_comment($parent_id)->comment_author_email);
$subject = '你在 [' . get_option("blogname") . '] 的留言有了新回复';
$message = '<table class="email" style="width:720px;margin:auto;font-size: 16px;line-height: 1.4;font-family:黑体;border: 1px solid #eee;border-radius: 5px;">
<tbody>
<tr>
<td style="padding:5%;color: #666;">
<div class="email-header">
<div class="email-logo-wrapper" style="font-size: 30px;padding: 0 0 10px 0;color: #f55;border-bottom: 1px solid #eee;text-align: left;">
' . get_option("blogname") . '
</div>
</div>
<div>
<p>' . trim(get_comment($parent_id)->comment_author) . '，您在文章<strong style="font-weight:bold"> 《' . get_the_title($comment->comment_post_ID) . '》 </strong>中的评论：</p>
<p style="line-height: 36px;padding: 10px;background: #f6f6f6;text-indent: 2em;">' . trim(get_comment($parent_id)->comment_content) . '</p>
<p>'. $comment->comment_author .' 给您的回复如下:</p>
<p style="line-height: 36px;padding: 10px;background: #f6f6f6;text-indent: 2em;">' . trim($comment->comment_content) . '</p>
<a target="_blank" style="color: #fff;background: #f55;width: 200px;padding: 10px 0;border-radius: 5px;margin: 30px 0 0;text-align:center;display:block;" href="' . htmlspecialchars(get_comment_link($parent_id)) . '">立即回复</a>
</div>
</td>
</tr>
<tr>
<td style="font-size:12px;text-align:center;color:#b3b3b1">
<div style="padding:16px;border-top:1px solid #eee">本邮件由 <a target="_blank" style="color:#b3b3b1" href="' . home_url() . '">' . get_option("blogname") . '</a> 后台自动发送，请勿直接回复！</div>
</td>
</tr>
</tbody>
</table>';
$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
wp_mail( $to, $subject, $message, $headers );
}
};
// 缩略图技术 by：http://www.bgbk.org
if( !defined( 'THEME_THUMBNAIL_PATH' ) ) define( 'THEME_THUMBNAIL_PATH', '/cache/theme-thumbnail' );
function Bing_build_empty_index( $path ){
	$index = $path . '/index.php';
	if( is_file( $index ) ) return;
	wp_mkdir_p( $path );
	file_put_contents( $index, "<?php\n// Silence is golden.\n" );
}
function Bing_crop_thumbnail( $url, $width, $height = null ){
	$width = (int) $width;
	$height = empty( $height ) ? $width : (int) $height;
	$hash = md5( $url );
	$file_path = WP_CONTENT_DIR . THEME_THUMBNAIL_PATH . "/$hash-$width-$height.jpg";
	$file_url = content_url( THEME_THUMBNAIL_PATH . "/$hash-$width-$height.jpg" );
	if( is_file( $file_path ) ) return $file_url;
	$editor = wp_get_image_editor( $url );
	if( is_wp_error( $editor ) ) return $url;
	$size = $editor->get_size();
	if( !$dims = image_resize_dimensions( $size['width'], $size['height'], $width, $height, true ) ) return $url;
	$cmp_x = $size['width'] / $width;
	$cmp_y = $size['height'] / $height;
	$cmp = min( $cmp_x, $cmp_y );
	$min_width = round( $width * $cmp );
	$min_height = round( $height * $cmp );
	$crop = $editor->crop( $dims[2], $dims[3], $min_width, $min_height, $width, $height );
	if( is_wp_error( $crop ) ) return $url;
	Bing_build_empty_index( WP_CONTENT_DIR . THEME_THUMBNAIL_PATH );
	$save = $editor->save( $file_path, 'image/jpg' );
	return is_wp_error( $save ) ? $url : $file_url;
}
function Bing_add_support_post_thumbnails(){
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'Bing_add_support_post_thumbnails' );
// 获取文章第一张图片
function get_content_first_image($content){
	if ( $content === false ) $content = get_the_content(); 
	preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $images);
	if($images){
		return $images[1][0];
	}else{
		return false;
	}
}
// 读者墙
if(!function_exists("deep_in_array")) {
    function deep_in_array($value, $array) {
        $i = -1;
        foreach($array as $item => $v) {
            $i++;
            if($v["email"] == $value) return $i;
        }
        return -1;
    }
}

function get_active_friends($num = null,$size = null,$days = null) {
    $num = $num ? $num : 15;
    $size = $size ? $size : 34;
    $days = $days ? $days : 30;
    $array = array();
    $comments = get_comments( array('status' => 'approve','author__not_in'=>1,'date_query'=>array('after' => $days . ' days ago')) );
    if(!empty($comments))    {
        foreach($comments as $comment){
            $email = $comment->comment_author_email;
            $author = $comment->comment_author;
            $url = $comment->comment_author_url;
            $data = human_time_diff(strtotime($comment->comment_date));
            if($email!=""){
                $index = deep_in_array($email, $array);
                if( $index > -1){
                    $array[$index]["number"] +=1;
                }else{
                    array_push($array, array(
                        "email" => $email,
                        "author" => $author,
                        "url" => $url,
                        "date" => $data,
                        "number" => 1
                    ));
                }
            }
        }
        foreach ($array as $k => $v) {
            $edition[] = $v['number'];
        }
        array_multisort($edition, SORT_DESC, $array); // 数组倒序排列
    }
    $output = '<ul class="active-items">';
    if(empty($array)) {
        $output = '<li>none data.</li>';
    } else {
        $max = ( count($array) > $num ) ? $num : count($array);
        for($o=0;$o < $max;$o++) {
            $v = $array[$o];
            $active_avatar = get_avatar($v["email"],$size);
            $active_url = $v["url"] ? $v["url"] : "#";
            $active_alt = $v["author"] . ' - 共'. $v["number"]. ' 条评论，最后评论于'. $v["date"].'前。';
            $output .= '<li class="active-item"><a target="_blank" href="'.$active_url.'" title="'.$active_alt.'">'.$active_avatar.'</a></li>';
        }
    }
    $output .= '</ul>';
    return  $output;
}
function active_shortcode( $atts, $content = null ) {

    extract( shortcode_atts( array(
            'num' => '',
            'size' => '',
            'days' => '',
        ),
        $atts ) );
    return get_active_friends($num,$size,$days);
}
add_shortcode('active', 'active_shortcode');

/*
//链接重定向跳转
add_filter('get_comment_author_link', 'add_redirect_comment_link', 5);
add_filter('comment_text', 'add_redirect_comment_link', 99);
function add_redirect_comment_link($text = ''){
$text=str_replace(get_comment_author_url(),get_option('home')."/index.php?link=".base64_encode(get_comment_author_url()),$text);
return $text;
}
*/

/**
 * Theme Update Checker Library 1.2 ／ 主题更新推送
 * http://w-shadow.com/
 * Copyright 2012 Janis Elsts
 * Licensed under the GNU GPL license.
 * http://www.gnu.org/licenses/gpl.html
 */
if ( !class_exists('ThemeUpdateChecker') ):
class ThemeUpdateChecker {
	public $theme = '';
	public $metadataUrl = '';
	public $enableAutomaticChecking = true;
	protected $optionName = '';
	protected $automaticCheckDone = false;
	protected static $filterPrefix = 'tuc_request_update_';
	public function __construct($theme, $metadataUrl, $enableAutomaticChecking = true){
		$this->metadataUrl = $metadataUrl;
		$this->enableAutomaticChecking = $enableAutomaticChecking;
		$this->theme = $theme;
		$this->optionName = 'external_theme_updates-'.$this->theme;
		$this->installHooks();		
	}
	public function installHooks(){
		if ( $this->enableAutomaticChecking ){
			add_filter('pre_set_site_transient_update_themes', array($this, 'onTransientUpdate'));
		}
		add_filter('site_transient_update_themes', array($this,'injectUpdate'));
		add_action('delete_site_transient_update_themes', array($this, 'deleteStoredData'));
	}
	public function requestUpdate($queryArgs = array()){
		$queryArgs['installed_version'] = $this->getInstalledVersion(); 
		$queryArgs = apply_filters(self::$filterPrefix.'query_args-'.$this->theme, $queryArgs);
		$options = array(
			'timeout' => 10,
		);
		$options = apply_filters(self::$filterPrefix.'options-'.$this->theme, $options);
		$url = $this->metadataUrl; 
		if ( !empty($queryArgs) ){
			$url = add_query_arg($queryArgs, $url);
		}
		$result = wp_remote_get($url, $options);
		$themeUpdate = null;
		$code = wp_remote_retrieve_response_code($result);
		$body = wp_remote_retrieve_body($result);
		if ( ($code == 200) && !empty($body) ){
			$themeUpdate = ThemeUpdate::fromJson($body);
			if ( ($themeUpdate != null) && version_compare($themeUpdate->version, $this->getInstalledVersion(), '<=') ){
				$themeUpdate = null;
			}
		}
		$themeUpdate = apply_filters(self::$filterPrefix.'result-'.$this->theme, $themeUpdate, $result);
		return $themeUpdate;
	}
	public function getInstalledVersion(){
		if ( function_exists('wp_get_theme') ) {
			$theme = wp_get_theme($this->theme);
			return $theme->get('Version');
		}
		foreach(get_themes() as $theme){
			if ( $theme['Stylesheet'] === $this->theme ){
				return $theme['Version'];
			}
		}
		return '';
	}
	public function checkForUpdates(){
		$state = get_option($this->optionName);
		if ( empty($state) ){
			$state = new StdClass;
			$state->lastCheck = 0;
			$state->checkedVersion = '';
			$state->update = null;
		}
		$state->lastCheck = time();
		$state->checkedVersion = $this->getInstalledVersion();
		update_option($this->optionName, $state);
		$state->update = $this->requestUpdate();
		update_option($this->optionName, $state);
	}
	public function onTransientUpdate($value){
		if ( !$this->automaticCheckDone ){
			$this->checkForUpdates();
			$this->automaticCheckDone = true;
		}
		return $value;
	}
	public function injectUpdate($updates){
		$state = get_option($this->optionName);
		if ( !empty($state) && isset($state->update) && !empty($state->update) ){
			$updates->response[$this->theme] = $state->update->toWpFormat();
		}
		return $updates;
	}
	public function deleteStoredData(){
		delete_option($this->optionName);
	}
	public function addQueryArgFilter($callback){
		add_filter(self::$filterPrefix.'query_args-'.$this->theme, $callback);
	}
	public function addHttpRequestArgFilter($callback){
		add_filter(self::$filterPrefix.'options-'.$this->theme, $callback);
	}
	public function addResultFilter($callback){
		add_filter(self::$filterPrefix.'result-'.$this->theme, $callback, 10, 2);
	}
}
endif;
if ( !class_exists('ThemeUpdate') ):
class ThemeUpdate {
	public $version;
	public $details_url;
	public $download_url;
	public static function fromJson($json){
		$apiResponse = json_decode($json);
		if ( empty($apiResponse) || !is_object($apiResponse) ){
			return null;
		}
		$valid = isset($apiResponse->version) && !empty($apiResponse->version) && isset($apiResponse->details_url) && !empty($apiResponse->details_url);
		if ( !$valid ){
			return null;
		}
		$update = new self();
		foreach(get_object_vars($apiResponse) as $key => $value){
			$update->$key = $value;
		}
		return $update;
	}
	public function toWpFormat(){
		$update = array(
			'new_version' => $this->version,
			'url' => $this->details_url,
		);
		if ( !empty($this->download_url) ){
			$update['package'] = $this->download_url;
		}
		return $update;
	}
}
endif;
$mytheme_update_checker = new ThemeUpdateChecker(
	'iDevise',
	'http://www.idevs.cn/idevise/update.json'
);
// 全部配置完毕
?>