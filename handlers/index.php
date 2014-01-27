<?php

$page->title = __ ('Contact');

$form = new Form ('post', $this);

echo $form->handle (function ($form) use ($page, $tpl) {
	try {
		Mailer::send (array (
			'to' => array (conf ('General', 'email_from'), conf ('General', 'site_name')),
			'reply_to' => array ($_POST['email'], $_POST['name']),
			'subject' => 'Contact form submission',
			'text' => $tpl->render ('contact/notice', $_POST)
		));

		$page->title = __ ('Message sent');
		printf ('<p>%s</p>', __ ('Thank you for contacting us. Your message has been sent.'));
	} catch (Exception $e) {
		error_log ('Email failure: ' . $e->getMessage ());
		$page->title = __ ('An error occurred');
		printf ('<p>%s</p>', __ ('We were unable to send your message at this time. Please try again later.'));
		return false;
	}
});

?>