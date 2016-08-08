<?php get_header();?><!--调用header.php文件-->


<section id="posts">
<!--开始Loop文章循环-->
<?php if(have_posts()):;?>
<?php while(have_posts()):the_post(); ?>
<article id="post-<?php the_ID(); ?>" class="post">
<header class="post-title">
<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
<?php the_title(); ?></a></h2>
</header>
<!--上面的代码是显示日志标题-->
<p id="post1"><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 200, '...'); ?></p>
<span id="time">
<span><?php if (date('Y') != get_the_time('Y')) the_time('Y年');the_time('m月d日') ?></span><!-- 文章发布日期 --!> ·
<span class="comments"><?php comments_number('暂无评论', '1条评论', '%条评论'); ?></span><!-- 输出文章评论数 --!></span>
</article>
<?php comments_template(); // 这句代码用来显示日志评论 ?>
<?php endwhile; ?>
 <!--下面代码的意思是，如果找不到日志可以显示，就告诉访客，目前没有日志满足他的要求-->  
<?php else: ?>
<p class="nocontent"><?php _e('Sorry, no posts are found.'); ?></p>
<?php endif; ?>
<!--loop循环结束-->
</section>
</div>
	<nav class="navigator">
        <?php previous_posts_link('<i class="iconfont">&#xe604;</i>') ?><?php next_posts_link('<i class="iconfont">&#xe603;</i>') ?>
	</nav>
<!--下面这两句代码分别调用sidebar.php、footer.php文件-->
<?php get_footer(); ?>