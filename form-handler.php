<?php
// Add this file in the child theme directory

function verify_recaptcha($token) {
    $url = 'https://recaptchaenterprise.googleapis.com/v1/projects/my-project-33262-1720190929777/assessments?key=YOUR_API_KEY';
    $data = array(
        'event' => array(
            'token' => $token,
            'siteKey' => '6LdyJQkqAAAAAPSWPRNVtfUmjdXfbmp5MKMU-cMa',
            'expectedAction' => 'submit'
        )
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        )
    );

    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        return false;
    }

    $responseData = json_decode($response, true);
    return $responseData['tokenProperties']['valid'] && $responseData['score'] >= 0.5;
}

function handle_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['recaptcha_token'];
        $isHuman = verify_recaptcha($token);

        if ($isHuman) {
            // Process form data here
            wp_redirect(home_url('/thank-you'));
        } else {
            wp_redirect(home_url('/form-error'));
        }
        exit;
    }
}
add_action('admin_post_nopriv_handle_form_submission', 'handle_form_submission');
add_action('admin_post_handle_form_submission', 'handle_form_submission');

