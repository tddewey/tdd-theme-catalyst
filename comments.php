<?php if ( post_password_required() ): ?>
<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
<?php return; endif; ?>

<?php if ( have_comments() ) : ?>
<h3 id="comments"><?php comments_number( 'No Comments', 'One Comment', '% Comments' );?></h3>
<ul class="commentlist">
	<?php wp_list_comments(); ?></ul>
<nav>
	<?php paginate_comments_links(); ?>
</nav>
<?php else : // this is displayed if there are no comments so far ?>
<?php if ( comments_open() ) : ?>
	<p>There are no comments at this time</p>
	<?php else : ?>
	<p>Comments are closed</p>
	<?php
	endif;
endif;

if ( 'open' == $post->comment_status ) :
	comment_form();
endif;
?>