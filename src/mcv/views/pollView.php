<?php

use Josafast\Polls\Model\Poll;

if (isset($_GET['view'])) {
	try {
		$poll = new Poll($_GET['view']);
		$options = $poll->getOptions();
		$total = $options[0]->sum;
	} catch (Exception $e) {
		exit('<script>location.replace("/")</script>');
	}
}

?>

<h1><?php echo $poll->title; ?></h1>
<ul class="votes">
	<?php foreach ($options as $option) : ?>
		<li>
			<h2><?php echo $option->title; ?></h2>
			<h3>Votos: <?php echo $option->votes ?></h3>
			<div>
				<div style="width: <?php echo $option->votes == 0 ? 25 : number_format(($option->votes * 100) / $total, 2); ?>%;"><?php echo $option->votes == 0 && $total == 0 ? 0 : number_format(($option->votes * 100) / $total, 2); ?>%</div>
			</div>
			<form action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/vote'; ?>" method="POST" class="vote_form">
				<label for="uuid">
					<input type="hidden" name="uuid" value="<?php echo $_GET['view'] ?>" />
				</label>
				<label for="vote_option">
					<input type="hidden" name="vote_option" value="<?php echo $option->title; ?>">
				</label>
				<input type="submit" value="Vote">
			</form>

		</li>
	<?php endforeach; ?>
</ul>
<div class="poll_options">
	<form action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/delete' ?>" method="POST">
		<label for="uuid">
			<input type="hidden" name="uuid" value="<?php echo $_GET['view']; ?>" />
		</label>
		<input type="submit" value="Delete poll">
	</form>
	<a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/update?poll=' . $_GET['view'] ?>">
		<button>Modify poll</button>
	</a>
</div>