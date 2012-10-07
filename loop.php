<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article <?php post_class( 'clearfix' ); ?> id="article-<?php the_ID(); ?>">
	<hgroup>
		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	</hgroup>
	<div class="entry">
		<div class="alignleft"><?php the_post_thumbnail(); ?></div>
		<blockquote cite="<?php the_permalink(); ?>">
			<?php the_excerpt(); ?>
		</blockquote>
	</div>
	published <?php the_date(); ?> by <?php the_author(); ?><br>
	<?php the_tags(); ?>

</article>
<?php wp_link_pages( ); ?>
<?php endwhile; else : ?>

<div <?php post_class(); ?>>

	<h2>Page Not Found</h2>

	<p>Looks like the page you're looking for isn't here anymore. Try browsing the <a href="">categories</a>,
		<a href="">archives</a>, or using the search box below.</p>

	<?php get_search_form() ?>

</div>

<?php endif; ?>

<nav class="clearfix">
	<div class=left><?php next_posts_link( '&laquo; Older Entries' ) ?></div>
	<div class=right><?php previous_posts_link( 'Newer Entries &raquo;' ) ?></div>
</nav>