<html>
<head>
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/script.js"></script>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="panel panel-default">
  <div class="panel-heading">Prodotti disponibili</div>
</div>
<?php
	include("db.php");
	$con=DB::getInstance()->getConn();

echo('<table class="table table-bordered table-striped">
	<tr><th>ID</th><th>Titolo</th><th>Descrizione</th></tr>
	');
   $sql="SELECT * FROM prodotti";

		$result=$con->query($sql);
		if($result){
			while($row=$result->fetch_assoc()){
				?>
				<tr id="<?= $row['id']?>">
					<td class="id"><?= $row['id']?></td>
					<td class="titolo"><?= $row['titolo']?></td>
					<td class="descrizione"><?= $row['descrizione']?></td>
				</tr>

				<?php
			}
		}
echo('</table>');
?>

<span class="label label-primary">Quanti prodotti vuoi mettere in coda?</span>
	<select id="numero">
		<?php

		 for($i=1; $i<=6; $i++)
			{
		?>
			<option value="<?= $i ?>"> <?= $i ?></option>
		<?php
			}
		?>

	</select>
	<button type="button" id="invia" onclick="invia()" class="btn btn-success">Invia</button>


<div class="container container-fluid">
	<div class="row">
		<div class="col col-sm-6">
			<h1>Coda</h1>
			<table class="table-bordered table-striped" id="coda">
				<tr id="table_head"><th>ID</th><th> Messaggio</th></tr><tr>

			</table>
		</div>
		<div class="col col-sm-6">
			<button class="receiver btn btn-success"" onclick="receiver()" id="receiver" >Abilita Receiver</button>
			<button class="receiver btn btn-success"" onclick="cancella()" id="receiver" >Disabilita Receiver</button>
			<button class="receiver btn btn-warning"" onclick="pulisci()" id="pulisci" >Pulisci</button>
			<a target="_blank" href="log.txt"><button class="receiver btn btn-warning" >Log file</button></a>
				<div class="receiver-box">
					


				</div>
		</div>
	</div>
</div>



</body>
</html>