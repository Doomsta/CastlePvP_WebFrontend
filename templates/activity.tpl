<section id="playtime">
	<h2>Aktivit&auml;t</h2>
{include file='timemanager.tpl'}
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
						<th>
							<img src="./img/battlegrounds/{$mapid}.jpg" title="{$mapname}" width="32" height="32">
						</th>
{/foreach}
						<th>Summe</th>
					</tr>
					<tr>
						<th colspan="{2 + count($maps)}" style="background:{$faction_color[$faction_id]};color:#fff;font-variant:small-caps;text-align:center;"><big>{$faction_name[$faction_id]}</big></th>
					</tr>
				<!-- Summary -->
					<tr>
						<td style="background-color:#D0D0D0;"></td>
{foreach $maps as $mapid => $mapname}
                        <td style="background-color:#D0D0D0;text-align:center;vertical-align:middle;">
{if isset($dataset_summary[$mapid])}
							<span title="{$dataset_summary[$mapid]['long']}">
							<strong>{$dataset_summary[$mapid]['short']}</strong>
							<br />
							<small>{$dataset_summary[$mapid]['unit']}</small>
							</span>
{else}
							-
{/if}
						</td>
{/foreach}
                        <td style="background-color:#D0D0D0;text-align:center;"><span title="{$dataset_summary[0]['long']}"><strong>{$dataset_summary[0]['short']}</strong><br />{$dataset_summary[0]['unit']}</span></td>
					</tr>
				<!-- Players -->
{foreach $faction as $player}
{if $player[0]['value'] >= (15*60)}
					<tr>
						<td>
							<a href="http://armory.wow-castle.de/character-sheet.xml?r=WoW-Castle+PvE&#38;cn={$player['identity']['name']}">
								<span style="font-weight:bold;color:{$class_color[$player['identity']['class']]};text-shadow: 1px 1px 1px #000;">
									{$player['identity']['name']}
								</span>
							</a>
							<br />
{if strlen($player['identity']['guild']) > 0}
							<a href="http://armory.wow-castle.de/guild-info.xml?r=WoW-Castle+PvE&#38;gn={$player['identity']['guild']}"><small style="color:grey;">{$player['identity']['guild_short']}</small></a>
{/if}
						</td>
{foreach $maps as $mapid => $mapname}
						<td style="text-align:center;vertical-align:middle;">
							<small>
{if isset($player[$mapid])}
								<span title="{$player[$mapid]['long']}" style="font-size:{$player[$mapid]['fontsize']}pt;">
								{$player[$mapid]['short']}
								<br />
								<small>{$player[$mapid]['unit']}</small>
								</span>
{else}
								<small>-</small>
{/if}
							</small>
						</td>
{/foreach}
						<td style="text-align:center;">
							<span title="{$player[0]['long']}" style="font-size:{$player[$mapid]['fontsize']}pt;">
							<strong>{$player[0]['short']}</strong>
							<br />
							<small>{$player[0]['unit']}</small>
							</span>
						</td>
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

