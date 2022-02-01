<?php


//Variable para demostrar la funcionalidad del GitHub
$Variable_Zabaleta_Estuvo_Aqui;

$servername = "localhost";
$dbname = "id18116251_variables";
$username = "id18116251_root";
$password = "Hr)!IvtiHrE{2B7%";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, temperatura, presion, humedad, lectura FROM sensor order by lectura desc limit 40";

$result = $conn->query($sql);
$sensor_data = [];

while ($data = $result->fetch_assoc()){
    $sensor_data[] = $data;
}

$readings_time = array_column($sensor_data, 'lectura');

$temperatura = json_encode(array_reverse(array_column($sensor_data, 'temperatura')), JSON_NUMERIC_CHECK);
$presion = json_encode(array_reverse(array_column($sensor_data, 'presion')), JSON_NUMERIC_CHECK);
$humedad = json_encode(array_reverse(array_column($sensor_data, 'humedad')), JSON_NUMERIC_CHECK);
$lectura = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);

// echo end($temperatura);
// echo end($presion);
// echo end($humedad);
// echo end($lectura);

$result->free();
$conn->close();
?>

<!DOCTYPE html>
<html>
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1" http-equiv="refresh" content="10">
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <style>
    body {
      text-align: center;
      font-family: "Trebuchet MS", Arial;
      min-width: 310px;
      max-width: 1280px;
      height: 500px;
      margin: 0 auto;
    }
    h2 {
      font-family: Arial;
      font-size: 2.5rem;
      text-align: center;
    }
    h4 {
      font-family: Arial;
      font-size: 1rem;
      text-align: center;
    }
    table {
        border-collapse: collapse;
        width:35%;
        margin-left:auto
        margin-right:auto;
    }
    th {
        padding: 12px;
        background-color: black;
        color: white;
    }
    tr {
        border: 1px solid #ddd;
        padding: 12px;
    }
    tr:hover {
        background-color: #bcbcbc;
    }
    td {
        border: none; padding: 12px;
    }
  </style>
  </head>
  <body>
    <h2>Weather Station powered by IOT</h2>
    <h4>ESCALERA - GALDAMEZ - SARMIENTO</h4>
    <!-- <div class="container">
        <table><tr><th>ULTIMA MEDICION</th><th>VALOR</th></tr>
        <tr>
            <td>Temperatura</td>
            <td><span class="sensor">
                temperatura
            </span></td>
        </tr>
        <tr>
            <td>Presion</td>
            <td><span class="sensor">
                presion
            </span></td>
        </tr>
        <tr>
            <td>Humedad</td>
            <td><span class="sensor">
                humedad
            </span></td>
        </tr>
        <tr>
            <td>Fecha de captura</td>
            <td><span class="sensor">
                lectura
            </span></td>
        </tr>
    </div> -->
    <div id="chart-temperature" class="container"></div>
    <div id="chart-humidity" class="container"></div>
    <div id="chart-pressure" class="container"></div>
<script>

var temperatura = <?php echo $temperatura; ?>;
var presion = <?php echo $presion; ?>;
var humedad = <?php echo $humedad; ?>;
var lectura = <?php echo $lectura; ?>;

var chartT = new Highcharts.Chart({
  chart:{ renderTo : 'chart-temperature' },
  title: { text: 'Temperatura' },
  series: [{
    showInLegend: false,
    data: temperatura
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#059e8a' }
  },
  xAxis: {
    type: 'datetime',
    categories: lectura
  },
  yAxis: {
    title: { text: 'Temperatura (C)' }
  },
  credits: { enabled: false }
});

var chartH = new Highcharts.Chart({
  chart:{ renderTo:'chart-humidity' },
  title: { text: 'Humedad' },
  series: [{
    showInLegend: false,
    data: presion
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    }
  },
  xAxis: {
    type: 'datetime',
    categories: lectura
  },
  yAxis: {
    title: { text: 'Humedad (%)' }
  },
  credits: { enabled: false }
});


var chartP = new Highcharts.Chart({
  chart:{ renderTo:'chart-pressure' },
  title: { text: 'Presion' },
  series: [{
    showInLegend: false,
    data: humedad
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#18009c' }
  },
  xAxis: {
    type: 'datetime',
    categories: lectura
  },
  yAxis: {
    title: { text: 'Presion (hPa)' }
  },
  credits: { enabled: false }
});

</script>
</body>
</html>
