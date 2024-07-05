<?php
/**
 * Template Name: Contact Page
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container">
		<h1>Contact Us</h1>
		<form id="contact_form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST" onsubmit="onSubmit(event)">
			<input type="hidden" id="recaptcha_token" name="recaptcha_token">
			<input type="text" name="name" placeholder="Your Name" required>
			<input type="email" name="email" placeholder="Your Email" required>
			<textarea name="message" placeholder="Your Message" required></textarea>
			<button type="submit">Send Message</button>
		</form>
	</div>
</main>

<script>
function onSubmit(event) {
    event.preventDefault();
    grecaptcha.enterprise.ready(async () => {
        const token = await grecaptcha.enterprise.execute('6LdyJQkqAAAAAPSWPRNVtfUmjdXfbmp5MKMU-cMa', {action: 'submit'});
        document.getElementById('recaptcha_token').value = token;
        document.getElementById('contact_form').submit();
    });
}
</script>

<?php
get_footer();
?>

