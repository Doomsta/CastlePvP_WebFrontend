<section id="playtime">
	<h2>Spielzeit</h2>
	<p>von {$begin} bis {$end}</p>
	<!--<div class="btn-group">
		<a href="?s=600"><button class="btn">Heute</button></a>
		<a href="?s=1200"><button class="btn">Gestern</button></a>
		<a href="?s=1800"><button class="btn">Diese Woche</button></a>
	</div>-->
	{if count($dataset) > 0}
	<table>
		<tr>
		{foreach $dataset as $faction_id => $faction}
		<!-- 1 Spalte je Fraktion -->
			<td style="vertical-align:top; padding-right:20px;">
			<!-- Fraktionsdaten -->
			<table class="table table-striped table-condensed">
				<!-- Header [name, map-bilder, summe] -->
				<tr>
					<th>Name</th>
					{foreach $maps as $mapid => $mapname}
					<th><img src="./img/battlegrounds/{$mapid}.jpg" title="{$mapname}" width="32" height="32"></th>
					{/foreach}
					<th>Summe</th>
				</tr>
				<tr>
					<th colspan="{2 + count($maps)}" style="background:{$faction_color[$faction_id]};color:#fff;font-variant:small-caps;text-align:center;"><big>{$faction_name[$faction_id]}</big></th>
				</tr>
                                <tr>
                                        <td style="background-color:#D0D0D0;"></td>
                                        {foreach $maps as $mapid => $mapname}
                                        <td style="background-color:#D0D0D0;text-align:center;vertical-align:middle;">{if isset($dataset_summary[$mapid])}<strong>{$dataset_summary[$mapid]/60}</strong><br /><small>Min.</small>{else}-{/if}</td>
                                        {/foreach}
                                        <td style="background-color:#D0D0D0;text-align:center;"><strong>{$dataset_summary['sum']/60}</strong><br />Min.</td>
                                </tr>
				{foreach $faction as $player}
				{if $player['sum'] >= (15*60)}
				<tr>
					<td>
						<a href="http://armory.wow-castle.de/character-sheet.xml?r=WoW-Castle+PvE&#38;cn={$player['identity']['name']}">
						<span style="font-weight:bold;color:{$class_color[$player['identity']['class']]};text-shadow: 1px 1px 1px #000;">
						{$player['identity']['name']}
						</span>
						</a><br />
						{if strlen($player['identity']['guild']) > 0}
						<a href="http://armory.wow-castle.de/guild-info.xml?r=WoW-Castle+PvE&#38;gn={$player['identity']['guild']}"><small style="color:grey;">{$player['identity']['guild_short']}</small></a>
						{/if}
						&nbsp;
					</td>
					{foreach $maps as $mapid => $mapname}
					<td style="text-align:center;vertical-align:middle;"><small>{if isset($player[$mapid])}{$player[$mapid] / 60}<br /><small>Min.</small>{else}-{/if}</small></td>
					{/foreach}
					<td style="text-align:center;"><strong>{$player['sum']/60}</strong><br /><small>Min</small></td>
				</tr>
				{/if}
				{/foreach}
			</table>
			</td>
		{/foreach}
		</tr>
	</table>
	{else}
	Keine Dateien f&uuml;r diesen Zeitraum verf&uuml;gbar.
	{/if}
</section>

