<?php get_header(); ?>
      <section id="body">
        <div class="container">
          <div id="main" class="post-page">
            <div class="res-cons">
              <?php while (have_posts()) : the_post(); ?>
              <article class="post3">
                <header class="post-meta">
                  <h2><?php the_title(); ?></h2>
<span id="time">
<span><?php if (date('Y') != get_the_time('Y')) the_time('Y年');the_time('m月d日') ?></span><!-- 文章发布日期 --!> ·
<span class="comments"><?php comments_number('暂无评论', '1条评论', '%条评论'); ?></span><!-- 输出文章评论数 --!></span>
                </header>
                <section class="post-content"><?php the_content(('')); ?></section>
              </article>
              <?php if (comments_open() || get_comments_number()) comments_template(); ?>
              <?php endwhile; ?>
            </div>
          </div>
        </div>
        <?php if (comments_open() || get_comments_number()) : ?>
        <?php endif; ?>
      </section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>