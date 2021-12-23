<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dockerigniter</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
<input type="hidden" id="base_url" name="base_url" value="<?php echo base_url(); ?>">
<div class="container-fluid">
	<div style="margin-top:10%" class="jumbotron">
		<h1 class="display-4">Health Check</h1>
		<p class="lead">This is a healthcheck of system requirements and/or dependences </p>
		<hr class="my-4">
		<?php
			if($mysqlCheck){ $mysqlCheckClass = 'alert-success'; } else { $mysqlCheckClass = 'alert-danger'; }
			if($redisCheck){ $redisCheckClass = 'alert-success'; } else { $redisCheckClass = 'alert-danger'; }
			if($sendgridCheck){ $sendgridCheckClass = 'alert-success'; } else { $sendgridCheckClass = 'alert-danger'; }
			if($phpmailerCheck){ $phpmailerCheckClass = 'alert-success'; } else { $phpmailerCheckClass = 'alert-danger'; }
		?>
		<div class="alert <?php echo $mysqlCheckClass; ?>">MySQL Check</div><br>
		<div class="alert <?php echo $redisCheckClass; ?>">Redis Check</div><br>
		<div class="alert <?php echo $sendgridCheckClass; ?>">Sendgrid Check</div><br>
		<div class="alert <?php echo $phpmailerCheckClass; ?>">PHPMailer Check</div><br>
	</div>
</div>
</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
</html>
