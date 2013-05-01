<h1>Arena Teams</h1>
<table>
	<tr>
{foreach key=i item=wert from=$ARENA_TEAMS}
		<td style="vertical-align:top; padding-right:20px;">
		<center><h2>{$i}vs{$i}</h2></center>
			<table class="table table-striped table-condensed">
				<tr>
					<th>Platz</th>
					<th>Name</th>
					<th>Spieler</th>
					<th>Rating</th>
				</tr>
{foreach key=j item=wert from=$ARENA_TEAMS.$i}
				<tr>
					<td>{$j+1}</td>
					<td><a href="http://armory.wow-castle.de/team-info.xml?b=WoW-Castle&r=WoW-Castle+PvE&ts=2&select={$wert.name}">{$wert.name}</a> </td>
					<td>
{foreach item=k from=$wert.player}
					<a href="http://armory.wow-castle.de/character-sheet.xml?r=WoW-Castle+PvE&#38;cn={$k.name}"><span style="font-weight:bold;color:{$k.classColor};text-shadow: 1px 1px 1px #000;">{$k.name}</a></span> <small>{$k.wins}/{$k.games}</small><br />
{/foreach}
					</td>
					<td>{$wert.rating}</td>
				</tr>
{foreachelse}
				<tr>
					<td colspan="3">keine Teams vorhanden</td>
				</tr>				
{/foreach}
			</table>
		</td>
{/foreach}
	</tr>
</table>