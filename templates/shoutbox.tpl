<h3>Shoutbox</h3>
	<form id="shout" class="wrapper" method="post">
		<input type="hidden" name="format" value="json" />
		<input type="hidden" name="action" value="write">
			<div class="relative">
				<label for="name" class="left absolute"><b>Name</b></label>
				<input class="right" type="text" name="name" id="name" >
			</div>
		<div class="clear relative">
			<label for="message" class="left absolute"><b>Nachricht</b></label>
			<textarea class="right" name="message" maxlength="155" id="message"></textarea>
		</div>
		<input class="btn btn-success submit" type="submit" value="Senden" name="submit">
	</form>
	<div id="entries">
	{foreach key=key item=wert from=$POSTS}
	{$wert}
	{/foreach}
	</div>

<script>!window.jQuery && document.write('<script src="./bootstrap/js/jquery.js"><\/script>')</script>
<script src="./js/shoutbox.js?v=1"></script>

