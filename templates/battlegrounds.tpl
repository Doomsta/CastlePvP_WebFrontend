<section id="battlegrounds">
    <h2>Schlachtfelder</h2>
    {include file='timemanager.tpl'}
    <canvas id="bgtimesum" width="900" height="400"></canvas>
    <script>
	var data = {
	labels : [{$LABEL}],
	datasets : [
		{
			fillColor : "rgba(134,1,15,0.5)",
			strokeColor : "rgba(220,220,220,1)",
			data : [{$DATA_WSG}]
		},
		{
			fillColor : "rgba(0,59,104,0.5)",
			strokeColor : "rgba(220,220,220,1)",
                        data : [{$DATA_AB}]
                },
		{
                        fillColor : "rgba(51,128,17,0.5)",
                        strokeColor : "rgba(220,220,220,1)",
                        data : [{$DATA_EOS}]
                },
		{
                        fillColor : "rgba(202,172,29,0.5)",
                        strokeColor : "rgba(220,220,220,1)",
                        data : [{$DATA_AV}]
                },
		{
                        fillColor : "rgba(60,60,60,0.5)",
                        strokeColor : "rgba(220,220,220,1)",
                        data : [{$DATA_SOTA}]
                }
	]}

	new Chart(document.getElementById('bgtimesum').getContext('2d')).Bar(data);

    </script>
    <br />
    <div class="well well-small">
    <label>Legende</label>
    Alle Angaben beziehen sich auf die Gesamtspielzeit des Schlachtfeldes in Minuten.
    <table>
        <tr>
            <td><span class="label label-important">Kriegshymnenschlucht</span></td>
            <td><span class="label label-info">Arathibecken</span></td>
            <td><span class="label label-success">Auge des Sturms</span></td>
            <td><span class="label label-warning">Alteractal</span></td>
            <td><span class="label label-inverse">Strand der Uralten</span></td>
        </tr>
    </table>
    </div>

</section>
