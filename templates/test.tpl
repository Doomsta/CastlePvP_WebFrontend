<section id="lv80overall">
    <h2>Charaktere: Level 80 (Gesamt/Allianz/Horde)</h2>
	<div class="btn-group">
		<a href="?s=600"><button class="btn">600</button></a>
		<a href="?s=1200"><button class="btn">1200</button></a>
		<a href="?s=1800"><button class="btn">1800</button></a>
    </div>
    <canvas id="canvas" width="900" height="400"></canvas>
    <script>

    var lineChartData = {
    labels : [{$LABEL}],
    datasets : [{
      fillColor : "rgba(220,220,220,0.5)",
      strokeColor : "rgba(220,220,220,1)",
      pointColor : "rgba(220,220,220,1)",
      pointStrokeColor : "#fff",
      data : [{$DATA0}]
      },{
       fillColor : "rgba(220,50,47,0.5)",
       strokeColor : "rgba(220,220,220,1)",
       pointColor : "rgba(220,220,220,1)",
       pointStrokeColor : "#fff",
       data : [{$DATA1}]
       },{
       fillColor : "rgba(38,139,210,0.5)",
       strokeColor : "rgba(220,220,220,1)",
       pointColor : "rgba(220,220,220,1)",
       pointStrokeColor : "#fff",
       data : [{$DATA2}]
       }]};    var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData);

    </script>
</section>        