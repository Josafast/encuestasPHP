<?php

use Josafast\Polls\model\Poll;

if (isset($_POST['title'])) {
	$poll = new Poll($_POST['uuid']);
	$poll->title = $_POST['title'];
	$poll->save();
	$poll->setOptions($_POST['options']);
	exit(json_encode(['message' => 'Objeto creado', 'status' => 200]));
}

if (isset($_POST['vote_option'])) {
	try {
		$poll = new Poll($_POST['uuid']);
		$poll->voteInOption($_POST['vote_option']);
		exit("<script>location.replace('/view?view=" . $_POST['uuid'] . "')</script>");
	} catch (Exception $e) {
		exit("<script>location.replace('/')</script>");
	}
}

if (isset($_POST['uuid'])) {
	try {
		Poll::delete($_POST['uuid']);
	} finally {
		exit("<script>location.replace('/')</script>");
	}
}
