<!-- Sticky Share -->
<?php
/**
 * This will return the current page
 */
$link = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<ul>
	<li class="fb">
		<a href="http://www.facebook.com/sharer.php?u=<?php echo $link; ?>&t=<?php wp_title(''); ?>" title="Share on Facebook" target="_blank">
			<i class="fab fa-facebook-square"></i>
		</a>
	</li><!-- ./fb -->
	<li class="tw">
		<a href="http://twitter.com/share?url=<?php echo $link; ?>" title="Tweet This Post" target="_blank">
			<i class="fab fa-twitter-square"></i>
		</a>
	</li><!-- ./tw -->
	<li class="lin">
		<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $link; ?>" target="_blank">
      <i class="fab fa-linkedin"></i>
		</a>
	</li><!-- ./lin -->
	<li class="env">
	  <a href="mailto:?subject=Information you may be interested in&body=I thought you might be interested in this information: <?php echo $link; ?>">
		  <i class="fas fa-envelope-square"></i>
	  </a>
	</li><!-- ./env -->
</ul>
