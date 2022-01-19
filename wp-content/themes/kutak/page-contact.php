<?php get_header(); ?>

<main class="contact-section">
  <!-- get page title -->
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="contact-title"><?php echo get_the_title(); ?></h1>
        <p class="contact-description">
          Looks like you’d like to get in touch. We’re all busy people, so here are few things to know before:
        </p>
        <ul class="few-things-content">
          <li>To take a trivial example</li>
          <li>Which of us ever undertakes laborious physical exercise</li>
          <li>Except to obtain some advantage from it</li>
        </ul>
        <form class="contact-form" action="/" method="post">
          <p>
            <label> Your Name (required)<br>
              <span class="your-name">
              	<input type="text" name="your-name" size="40">
              </span> 
            </label>
          </p>
          <p>
            <label> Your Email (required)<br>
              <span class="your-email">
                <input type="email" name="your-email" size="40" >
              </span>
            </label>
          </p>
          <p>
            <label> Subject<br>
              <span class="your-subject">
                <input type="text" name="your-subject" size="40" aria-invalid="false">
              </span>
            </label>
          </p>
					<p>
						<label> Your Message<br>
							<span class="your-message">
								<textarea name="your-message"></textarea>
							</span>
						</label>
					</p>
					<p>
						<input type="submit" value="Send">
						<span class="spinner"></span>
					</p>
					<div class="message-info" aria-hidden="true">Test Response</div>
				</form>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
