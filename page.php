<?php get_header(); ?>
      <section id="body">
        <div class="container">
          <div id="main" class="post-page">
            <div class="res-cons">
              <?php while (have_posts()) : the_post(); ?>
              <article class="post3">
                <header class="post-meta">
                  <h2 class="post-title"><?php the_title(); ?></h2>
                </header>
                <section class="post-content"><?php the_content(('')); ?></section>
              </article>
              <?php endwhile; ?>
            </div>
          </div>
        </div>
      </section>
<?php get_footer(); ?>