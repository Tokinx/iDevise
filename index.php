<?php if($_GET["link"]) header("location:".base64_decode($_GET["link"]));?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php wp_head();?>
<link type="image/vnd.microsoft.icon" href="<?php bloginfo('template_url'); ?>/images/favicon.png" rel="shortcut icon">
<link href="<?php bloginfo('template_url'); ?>/style.css" type="text/css" rel="stylesheet"/>
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div id="main" class="container">
<div class="pjax">
<header id="header">
<div class="container">
<h1 class="logo">
<i class="iconfont">&#xe60d;</i><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
</h1>
<nav id="topMenu" class="menu_click">
<?php wp_nav_menu(array('theme_location' => 'header_nav', 'echo' => true)); ?>
<i class="i_1"></i>
<i class="i_2"></i>
</nav>
</div>
</header>

	<section class="blockGroup">
		<?php if (is_single()||is_page()) { ?>
			<h2 itemprop="name headline" class="s_title"><?php the_title();?></h2>
			<article class="post single" itemscope itemtype="http://schema.org/BlogPosting">
				<?php if (have_posts()) { while (have_posts()) {
					the_post();
					the_content();
				} }; ?>
			</article>
            <section class="ending">
                <?php if(get_theme_mod('biji_other_weibo')||get_theme_mod('biji_other_qq')||get_theme_mod('biji_other_douban')||get_theme_mod('biji_other_zhihu')||get_theme_mod('biji_other_github')){ ?>
                <ul class="sns">
                    <?php if(get_theme_mod('biji_other_weibo')){ ?>
                    <li class="weibo"><a href="<?php echo get_theme_mod('biji_other_weibo');?>" target="_blank"><i class="iconfont">&#xe600;</i></a></li>
                    <?php }; if(get_theme_mod('biji_other_qq')){ ?>
                    <li class="tencent"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo get_theme_mod('biji_other_qq');?>&site=qq&menu=yes" target="_blank"><i class="iconfont">&#xe601;</i></a></li>
                    <?php }; if(get_theme_mod('biji_other_douban')){ ?>
                    <li class="douban"><a href="<?php echo get_theme_mod('biji_other_douban');?>" target="_blank"><i class="iconfont">&#xe602;</i></a></li>
                    <?php }; if(get_theme_mod('biji_other_zhihu')){ ?>
                    <li class="zhihu"><a href="<?php echo get_theme_mod('biji_other_zhihu');?>" target="_blank"><i class="iconfont">&#xe603;</i></a></li>
                    <?php }; if(get_theme_mod('biji_other_github')){ ?>
                    <li class="github"><a href="<?php echo get_theme_mod('biji_other_github');?>" target="_blank"><i class="iconfont">&#xe611;</i></a></li>
                    <?php };?>
                </ul>
                <?php };?>
                    
                <?php if(get_option('biji_other_pay_wexpay') || get_option('biji_other_pay_wexpay')){ ?>
                <div class="reward">
                打
                <ul>
                    <?php if(get_option('biji_other_pay_wexpay')){ ?>
                    <li><img src="<?php echo get_option('biji_other_pay_wexpay');?>">用支付宝打我</li>
                    <?php }; if(get_option('biji_other_pay_wexpay')){ ?>
                    <li><img src="<?php echo get_option('biji_other_pay_wexpay');?>">用微信打我</li>
                    <?php };?>
                </ul>
                </div>
                <?php }?>

                <div class="about">
                    <?php echo get_avatar(get_the_author_email(),'80');?>
                    <p><?php the_author_meta('description');?></p>
                </div>
            </section>
        
		<?php comments_template(); }
		else {if (have_posts()):while (have_posts()): the_post() ?>
            <article class="post post-list" itemscope="" itemtype="http://schema.org/BlogPosting">
                <div class="icon">
                <?php if (post_thumbnail(110, 110)){ ?>
                    <img src="<?php echo post_thumbnail(110, 110); ?>" srcset="<?php echo post_thumbnail(220, 220); ?> 2x"/>
                <?php }else{
                    echo '<i class="iconfont">&#xe605;</i>';
                }?>
                    
                </div>
                <h2 itemprop="name headline" class="title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                <div class="p_time"><?php the_time('Y-m-d') ?></div>
                <p><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 220,"...");?></p>
            </article>
            <div class="clearer"></div>
		<?php endwhile;endif; };?>
	</section>
	<div class="clearer"></div>
	<nav class="navigator">
        <?php previous_posts_link('<i class="iconfont">&#xe60a;</i>') ?><?php next_posts_link('<i class="iconfont">&#xe60b;</i>') ?>
	</nav>
</div>
</div>

<div class="clearer"></div>
<div class="search">
<form method="get" action="<?php bloginfo('url'); ?>">
<input class="search_key" name="s" autocomplete="off" placeholder="Enter search keywords..." type="text" value="" required="required">
<button alt="Search" type="submit">Search</button>
</form>
</div>
<footer id="footer">
<section class="links_adlink">
<ul class="container">
<?php error_reporting(0);
    $tip = str_replace("\r", "", get_theme_mod('biji_config_links'));
    $tips = explode("\n", $tip);
    if (is_array($tips)) {
        foreach($tips as $tip) $str .= $tip."\n";
        echo $str;
}?>
</ul>
</section>
Theme is iDevise by <a target="_blank" href="https://biji.io/">Tokin</a><br/>
&copy; <?php echo date('Y'); ?> <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
<?php if(get_option( 'zh_cn_l10n_icp_num' )){?> . <?php echo get_option( 'zh_cn_l10n_icp_num' );}?>
<a class="back2top"></a>
</footer>
<?php wp_footer();
echo "<script style=\"display:none\">\nfunction index_overloaded(){\n".get_theme_mod('biji_config_overcode')."\n}\n</script>\n"?>
<script src='//cdn.bootcss.com/jquery/3.1.1/jquery.min.js'></script>
<script src="<?php bloginfo('template_directory'); ?>/functions.js"></script>
<script>
<?php
if(get_theme_mod('biji_config_pjax')){
echo "//页面ajax
    $('body').on('click',pjax_a,
    function() {
        ajax($(this).attr('href'), 'pagelink');
        return false;
    });\n";
}
if(get_theme_mod('biji_config_pjax_search')){
echo "//搜索ajax
    $('body').on('submit',pjax_form, 
    function() {
        ajax(this.action + '?s=' + $(this).find(pjax_key).val(), 'search'); 
        return false;
    });";
}
?>
</script>
</body>
</html>