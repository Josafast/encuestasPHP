<?php 
	use Josafast\Polls\model\Poll;

	$polls = Poll::getPolls();
?>
<h1>List of polls</h1>
<?php if($polls->rowCount() < 1):?>
	<h1>There's no Polls to judge</h1>
<?php else: ?>
	<ul class="polls">
		<?php foreach(Poll::getPolls() as $poll): ?>
			<li><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/view?view='.$poll['uuid'];?>"><?php echo $poll['title'] ?></a></li>
		<?php endforeach;?>	
	</ul>
<?php endif;?>