<?php

use Josafast\Polls\model\Poll;

if (isset($_GET['poll'])) {
	try {
		$poll = new Poll($_GET['poll']);
		$options = $poll->getOptions();
	} catch (Exception $e) {
		exit('<script>location.replace("/create")</script>');
	}
}

?>
<h1>Create your poll</h1>
<form action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/create'; ?>" method="POST" class="create_poll_form">
	<label for="uuid">
		<input type="hidden" name="uuid" value="<?php if (isset($_GET['poll'])) echo $_GET['poll'] ?>">
	</label>
	<label for="title">
		<h2 style="margin-bottom: 10px;">Title</h2>
		<input type="text" name="title" <?php if (isset($_GET['poll'])) echo 'value="' . $poll->title . '"' ?> placeholder="Write your title here" />
	</label>
	<label for="options[]" class="options">
		<h2 style="margin: auto 0;">Options</h2>
		<button class="addOption">+</button>
	</label>
	<input type="submit" name="create" id="submit" value="Send"/>
</form>
<script>
	let optionsLabel = document.querySelector('.options');
	let addOption = document.querySelector('.addOption');
	let form = document.forms[0];

	function createOption(optionContent = "") {
		let div = document.createElement('div');
		let input = document.createElement('input');
		input.type = "text";
		input.setAttribute("value", optionContent);
		input.placeholder = "Ingrese la nueva opción aquí";
		input.name = "options[]";

		let close = document.createElement('button');
		close.textContent = "X";
		close.addEventListener('click', (e) => {
			optionsLabel.removeChild(e.target.parentElement);
		});

		div.appendChild(input);
		div.appendChild(close);
		optionsLabel.appendChild(div);
	}

	<?php if (isset($_GET['poll'])) : ?>
		<?php foreach ($options as $option) : ?>
			createOption("<?php echo $option->title; ?>");
		<?php endforeach; ?>
	<?php endif; ?>

	addOption.addEventListener('click', () => createOption());

	form.addEventListener('submit', (e) => {
		e.preventDefault();

		if (e.submitter.id == "submit") {
			let pollData = new FormData(e.target);
			if (pollData.get('title') == "") {
				console.log("Escribe un título");
				return;
			}

			if (pollData.getAll('options[]').length == 0 || pollData.getAll('options[]')[0] == '') {
				console.log("Agrega opciones a tu encuesta");
				return;
			}

			fetch(e.target.action.contain, {
				method: 'POST',
				body: pollData
			}).then(res => res.json()).then(res => {
				console.log(res);
				if (res.status == 200) {
					location.replace('/')
				}
			});
		}
	});
</script>