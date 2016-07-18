<?php
	// If message exists, set to global message item
	if($view->checkObject('outputMsg')){
		$message = $view->getObject('outputMsg');
	?>
<div id="message" class="msg <?php echo $message['type']; ?>">
	<span><?php echo $message['msg']; ?></span>
</div>
<?php } ?>