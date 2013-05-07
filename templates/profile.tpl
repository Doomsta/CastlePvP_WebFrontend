<section id="arena">
	<h1>Profile</h1>
{if !empty($CHAR)}
	{$CHAR.prefix}<a href="http://armory.wow-castle.de/character-sheet.xml?r=WoW-Castle+PvE&#38;cn={$CHAR.name}"> <span style="font-weight:bold;color:{$CHAR.classColor};text-shadow: 1px 1px 1px #000;">{$CHAR.name}</span></a><br />
	<a href="http://armory.wow-castle.de/guild-info.xml?r=WoW-Castle+PvE&#38;gn={$CHAR.guildName}"> &lt;{$CHAR.guildName}&gt;</a> <br />
	Race: {$CHAR.raceName} <br />
	Level: {$CHAR.level} <br />
	AV Points: {$CHAR.points} <br />
	<h3>Arena Teams</h3>
{if isset($CHAR.arena)}
	<div class="row">
{foreach key=ts item=team from=$CHAR.arena}
		<div class="span4">
			<b>{$ts}vs{$ts}</b><br />
			Name: <a href="http://armory.wow-castle.de/team-info.xml?r=WoW-Castle+PvE&#38;t={$team.name}">{$team.name}</a><br />
			Rating: {$team.rating}<br />
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>Won/Played<br />(woche)</th>
						<th>Won/Played<br />(Season)</th>
						<th>PR</th>
					</tr>
				</thead>
				<tbody>
{foreach key=key item=member from=$team.member}
					<tr>
						<td>
							<a href="http://armory.wow-castle.de/character-sheet.xml?r=WoW-Castle+PvE&#38;cn=$member.name"><span style="font-weight:bold;color:{$member.classColor};text-shadow: 1px 1px 1px #000;">{$member.name}</span></a><br />
{if !empty($member.guild)}
							<small>{$member.guild}</small><br />
{/if}
						</td>
						<td>{$member.gamesWon} / {$member.gamesPlayed}</td>
						<td>{$member.seasonGamesWon} /{$member.seasonGamesPlayed}</td>
						<td>{$member.persRating}</td>
					</tr>
{/foreach}
				</tbody>
			</table>
		</div>
{/foreach}
	</div>
{else}
Keine Arena Teams vorhanden
{/if}
{else}
{if !empty($ERROR)}
    <div class="alert alert-error" style="max-width:250px;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Warning!</strong> {$ERROR}
    </div>
{/if}
    <form method="GET" action = "./profile.php" >
		<fieldset>
			<label>CharName</label>
			<label>
				<input type="text" name="cn" placeholder="Type something…">
			</label>

			<button type="submit" class="btn">Submit</button>
		</fieldset>
    </form>
{/if}
</section>

