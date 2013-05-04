<section>
	<h1>Willkommen</h1>
	<table class="table">
		<thead>
			<tr>
				<th>Table</th>
				<th>Datensätze</th>
			</tr>
		</thead>
		<tbody>
{foreach $TABLEDATA as $key => $row}
			<tr>
				<td>{$key}</td>
				<td>{$row}</td>
			</tr>
{/foreach}
		</tbody>
    </table>
	Erster Eintrag in der Datenbank: {$FIRST}
</section>