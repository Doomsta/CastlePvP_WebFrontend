<section id="battlegrounds">
    <h2>{$title}</h2>
    {include file='timemanager.tpl'}
    <br />
    <h3>Klassenverteilung</h3>
    <canvas id="classdistribution" width="900" height="350"></canvas>
    <script>
	var data = {
	labels : [{$labels}],
	datasets : [
                {
                        fillColor : "rgba(220,220,220,0.5)",
                        strokeColor : "rgba(220,220,220,1)",
                        pointColor : "rgba(220,220,220,1)",
                        pointStrokeColor : "#fff",
                        data : [{$total}]
                },
		{
		        fillColor : "rgba(220,50,47,0.5)",
		        strokeColor : "rgba(220,220,220,1)",
		        pointColor : "rgba(220,220,220,1)",
		        pointStrokeColor : "#00ff",
			data : [{$horde}]
		},
        	{
		        fillColor : "rgba(38,139,210,0.5)",
		        strokeColor : "rgba(220,220,220,1)",
		        pointColor : "rgba(220,220,220,1)",
		        pointStrokeColor : "#fff",
	                data : [{$alliance}]
	        }
	]}

        new Chart(document.getElementById('classdistribution').getContext('2d')).Bar(data);

    </script>
</section>
