<section id="arena">
	<h1>Arena Teams {$TS}vs{$TS}</h1>
	<table class="table table-striped table-condensed">
		<tr>
			<th>Platz</th>
			<th>Name</th>
			<th>Spieler</th>
			<th>Won/Played</th>
			<th>Rating</th>
		</tr>
{foreach key=i item=wert from=$ARENA_TEAMS}
		<tr>
			<td>{$i+1}</td>
			<td><a href="http://armory.wow-castle.de/team-info.xml?b=WoW-Castle&r=WoW-Castle+PvE&ts=2&select={$wert.name}">{$wert.name}</a> </td>
			<td>
{foreach item=j from=$wert.player}
			<a href="http://armory.wow-castle.de/character-sheet.xml?r=WoW-Castle+PvE&#38;cn={$j.name}">
				<span style="font-weight:bold;color:{$j.classColor};text-shadow: 1px 1px 1px #000;">
					{$j.name}
				</span>
			</a>
				<small>{$j.wins}/{$j.games}</small>
				<br />
{/foreach}
			</td>
			<td>
				<big>{$wert.gamesWon}/{$wert.gamesPlayed}<big>
			</td>
			<td>{$wert.rating}</td>
		</tr>
{foreachelse}
		<tr>
			<td colspan="4"><font color="#FF0000"><center><big>keine Teams vorhanden</big></center></font></td>
		</tr>				
{/foreach}
	</table>
<section
		