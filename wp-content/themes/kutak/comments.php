
<?php 
  $comments = get_comments(array(
    'post_id' => get_the_ID(),
    'status' => 'approve',
    'order' => 'ASC'
  ));

	$comments_count = count($comments);
?>

<?php if ($comments_count > 0) { ?>
	<!-- pervious-comments -->
	<div class="previous-comments">
		<h2 ><?php echo $comments_count; ?> Replies to <?php the_title(); ?></h2>
		
		<?php foreach ( $comments as $comment) { ?>
			<article data-comment-id="<?php echo $comment->comment_ID; ?>" data-post-id="<?php echo $comment->comment_post_ID; ?>">
				<div class="single-comment">
					<div class="single-author-avatar">
						<?php echo get_avatar( $comment->comment_author_email, '32' ); ?>
					</div>
					<div class="single-comment-body">
						<div class="single-author-name">
							<span><?php echo $comment->comment_author; ?></span>
						</div>
						<div class="single-comment-meta">
							<span><?php echo get_comment_date('F j, Y g:i a'); ?></span>
						</div>
						<div class="single-comment-content">
							<p><?php echo $comment->comment_content; ?></p>
						</div>
						<div class="reply-link">
							<a href="#" class="reply-to-comment" data-comment-id="<?php echo $comment->comment_ID; ?>" data-post-id="<?php echo $comment->comment_post_ID; ?>">Reply</a>
						</div>
					</div>
				</div>
			</article>
		<?php	} ?>
	</div>
<?php	} ?>
          
<div class="comment-form">
  <?php comment_form(); ?>
</div>