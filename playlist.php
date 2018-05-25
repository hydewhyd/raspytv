<?php
	session_start();
	require("./assets/includes/config.php");
	
	if(!isset($_SESSION['usuarioIngresado'])) {
		header("Location: login.php");
		exit;
	}

	# Consulta si se está reproduciendo algun contenido...
	$consulta = "SELECT view, playimg, playvideo, playmusic FROM r_users WHERE usuario LIKE '{$_SESSION['usuario']}'";
	$resultado = $conexionSQL->query($consulta);
	$row = mysqli_fetch_assoc($resultado);
	$play = $row["view"];
	$playImg = $row["playimg"];
	$playVideo = $row["playvideo"];
	$playSnd = $row["playmusic"];
	
	
	if(!empty($_POST["imagecheck"])) {
		
		$countReproducir = count($_POST["imagecheck"]);
		
		for($i=0; $i < $countReproducir; $i++) {
			$img[$i] = "uploads/" . $_POST["imagecheck"][$i];
		}
		
		$consulta = "UPDATE `r_users` SET view = 1, playimg = 1, countContent = ".$countReproducir." WHERE usuario = '".$_SESSION['usuario']."'";
		mysqli_query($conexionSQL, $consulta);
		
		$playImg = true;
		$play = true;
		
		$imagenes = implode(" ", $img);
		$comando = "sudo fbi -T 1 -t 5 -a -noverbose ".$imagenes . " > /dev/tty1";
		exec("sudo pkill fbi > /dev/tty1");
		exec($comando); 
	}
	else if(!empty($_POST["videocheck"])) {
		$countReproducir = count($_POST["videocheck"]);
		$playVideo = true;
		
		for($i=0; $i < $countReproducir; $i++) {
			$vid[$i] = "sudo omxplayer -o hdmi " . "uploads/" . $_POST["videocheck"][$i] . " > /dev/tty1";
		}
		
		if($countReproducir > 1) {
			$videos = implode(' && ', array_reverse($vid));
		} else {
			$videos = $vid[0];
		}
		
		$consulta = "UPDATE `r_users` SET view = 1, playvideo = 1, countContent = ".$countReproducir." WHERE usuario = '".$_SESSION['usuario']."'";
		mysqli_query($conexionSQL, $consulta);
		
		$playVideo = true;
		$play = true;
		
		exec("sudo pkill omxplayer > /dev/tty1");
		exec($videos);
	}
	else if(!empty($_POST["soundcheck"])) {
		$countReproducir = count($_POST["soundcheck"]);
		
		for($i=0; $i < $countReproducir; $i++) {
			$sng[$i] = "sudo omxplayer -o local " . "uploads/" . $_POST["soundcheck"][$i] . " > /dev/tty1";
		}
		
		if($countReproducir > 1) {
			$canciones = implode(' && ', array_reverse($sng));
		} else {
			$canciones = $sng[0];
		}
		
		$consulta = "UPDATE `r_users` SET view = 1, playmusic = 1, countContent = ".$countReproducir."  WHERE usuario = '".$_SESSION['usuario']."'";
		mysqli_query($conexionSQL, $consulta);
		
		$playSnd = true;
		$play = true;
		
		exec("sudo pkill omxplayer > /dev/tty1");
		exec($canciones);
	}
	
	if(isset($_POST["pararIMG"])) {
		# Consulta MySQL
		$consulta = "UPDATE `r_users` SET view = 0, playimg = 0, countContent = 0 WHERE usuario = '".$_SESSION['usuario']."'";
		mysqli_query($conexionSQL, $consulta);
		
		# Paramos todos los procesos llamados 'fbi'
		exec("sudo pkill fbi > /dev/tty1");
		
		# Reseteamos las variables
		$imgParado = true;
		$playImg = 0;
		$play = false;
	}
	if(isset($_POST["pararVideo"])) {
		# Consulta MySQL
		$consulta = "UPDATE `r_users` SET view = 0, playvideo = 0, countContent = 0 WHERE usuario = '".$_SESSION['usuario']."'";
		mysqli_query($conexionSQL, $consulta);
		
		# Paramos todos los procesos llamados 'omxplayer'
		exec("sudo pkill omxplayer > /dev/tty1");
		
		# Reseteamos las variables
		$videoParado = true;
		$playVideo = 0;
		$play = false;
	}
	if(isset($_POST["pararMusica"])) {
		# Consulta MySQL
		$consulta = "UPDATE `r_users` SET view = 0, playmusic = 0, countContent = 0 WHERE usuario = '".$_SESSION['usuario']."'";
		mysqli_query($conexionSQL, $consulta);
		
		# Paramos todos los procesos llamados 'omxplayer'
		exec("sudo pkill omxplayer > /dev/tty1");
		
		# Reseteamos las variables
		$songParado = true;
		$playSnd = 0;
		$play = false;
	}
	
?>

<!doctype html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="es" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Reproducción - <?php echo $nombreProyecto ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <script src="./assets/js/require.min.js"></script>
    <script>
      requirejs.config({
          baseUrl: '.'
      });
    </script>
    <!-- Dashboard Core -->
    <link href="./assets/css/dashboard.css" rel="stylesheet" />
    <script src="./assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="./assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <script src="./assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="./assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <script src="./assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="./assets/plugins/input-mask/plugin.js"></script>
  </head>
  <body class="">
    <div class="page">
      <div class="page-main">
        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="./index.php">
                <img src="./assets/images/logo.gif" class="header-brand-img" alt="logo">
              </a>
              <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url(<?php echo "./assets/images/avatars/".$_SESSION['avatar'] ?>)"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default"><?php echo $_SESSION['usuario'] ?></span>
                      <small class="text-muted d-block mt-1"><?php echo $_SESSION['lema'] ?></small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="./account.php">
                      <i class="dropdown-icon fe fe-settings"></i> Cuenta
                    </a>
                    <a class="dropdown-item" href="./index.php?action=logout">
                      <i class="dropdown-icon fe fe-log-out"></i> Salida
                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="./index.php" class="nav-link"><i class="fe fe-home"></i> Inicio</a>
                  </li>
				  <li class="nav-item">
                    <a href="./playlist.php" class="nav-link active"><i class="fe fe-tv"></i> Reproducción</a>
                  </li>
				  <li class="nav-item dropdown">
					<a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-folder"></i> Contenido</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
						<a href="./upload.php" class="dropdown-item ">Subir</a>
						<a href="./delete.php" class="dropdown-item ">Eliminar</a>
                    </div>
                  </li>
				  <li class="nav-item">
                    <a href="./guide.php" class="nav-link"><i class="fe fe-file-text"></i> Guía</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="my-3 my-md-5">
			<div class="container">
				<div class="page-header">
				  <h1 class="page-title">
					<?php
						if(isset($_GET["play"])) {
							if($_GET["play"] == "images") {
								echo "<i class='fa fa-photo'></i>&nbsp;Imágenes";
							}
							if($_GET["play"] == "video") {
								echo "<i class='fe fe-film'></i>&nbsp;Videos";
							}
							if($_GET["play"] == "song") {
								echo "<i class='fe fe-volume-2'></i>&nbsp;Música";
							}
						} else {
							echo "<i class='fe fe-tv'></i>&nbsp;Reproductor";
						}
					?>
				  </h1>
				</div>

				<div class="row">
					<div class="col-lg-3 order-lg-1 mb-4">
						<div class="list-group list-group-transparent mb-0">
						<?php						
							if(isset($_GET["play"])) {
								if($_GET["play"] == "images") {
									echo '
										<a href="./playlist.php" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-tv"></i></span>Índice</a>
										<a href="./playlist.php?play=images" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fa fa-photo"></i></span>Imágenes</a>
										<a href="./playlist.php?play=video" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-film"></i></span>Videos</a>
										<a href="./playlist.php?play=song" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-volume-2"></i></span>Música</a>
									';
								}
								if($_GET["play"] == "video") {
									echo '
										<a href="./playlist.php" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-tv"></i></span>Índice</a>
										<a href="./playlist.php?play=images" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-photo"></i></span>Imágenes</a>
										<a href="./playlist.php?play=video" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fe fe-film"></i></span>Videos</a>
										<a href="./playlist.php?play=song" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-volume-2"></i></span>Música</a>
									';
								}
								if($_GET["play"] == "song") {
									echo '
										<a href="./playlist.php" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-tv"></i></span>Índice</a>
										<a href="./playlist.php?play=images" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-photo"></i></span>Imágenes</a>
										<a href="./playlist.php?play=video" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-film"></i></span>Videos</a>
										<a href="./playlist.php?play=song" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fe fe-volume-2"></i></span>Música</a>
									';
								}
							}
							else {
									echo '
										<a href="./playlist.php" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fe fe-tv"></i></span>Índice</a>
										<a href="./playlist.php?play=images" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-photo"></i></span>Imágenes</a>
										<a href="./playlist.php?play=video" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-film"></i></span>Videos</a>
										<a href="./playlist.php?play=song" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-volume-2"></i></span>Música</a>
									';
							}	
						?>
						</div>
					</div>
					<div class="col-lg-9">
						<!--continuacion-->
						<div class="card">
							<div class="card-body">
								<?php
									if(isset($_GET["play"]) && !empty($_GET["play"])) {
										if($_GET["play"] == "images") {
											
											# Contenido parado, el usuario le ha dado el botón de detener.
											if(isset($imgParado)) {
												if($imgParado == 1) {
													echo '
														<div class="alert alert-icon alert-success" role="alert">
															<i class="fe fe-check mr-2" aria-hidden="true"></i> Se ha parado la reproducción de imágenes.
														</div>
													';
												}
											}
											
											# Contenido reproduciendose, le dice si quiere pararlo.
											if(isset($play)) {
												if($play) {
													echo '
														<div class="alert alert-warning" role="alert">
														  Actualmente hay contenido en reproducción y no podrás iniciar otro contenido hasta que no acabes el actual.
														</div>
													';
												}
											}
											
											# Muestra de imágenes
											echo "<form action='playlist.php?play=images' method='post'>";
											echo "<div class='form-group'>";
											echo "<div class='row gutters-sm'>";
											foreach (new DirectoryIterator("uploads/") as $file) {
												if ($file->isFile()) {
													$mostrar = '<img src="./uploads/'.$file->getFilename().'" class="imagecheck-image">';
													if($file->getExtension() == "jpg" || $file->getExtension() == "png" || $file->getExtension() == "gif") {
														echo '
															<div class="col-sm-2">
																<label class="imagecheck mb-4">
																	<input type="checkbox" name="imagecheck[]" value="'.$file->getFilename().'" class="imagecheck-input"  />
																	<figure class="imagecheck-figure">
																		'.$mostrar.'
																	</figure>
																</label>
																<span class="tag tag-blue">'.substr(preg_replace("/\.[^.]+$/", "", $file->getFilename()), 0, 20).'</span>&nbsp;
																<span class="tag tag-gray">.'.$file->getExtension().'</span>
															</div>
														';
													}
												}
											}
											echo "</div>";
											echo "</div>";
												
											# Boton, si hay contenido reproduciendose mostrarle
											if(isset($play)) {
												if($play && $playImg == 1) {
													echo '<center><button type="submit" name="pararIMG" class="btn btn-danger">&nbsp;<i class="fe fe-zap"></i>&nbsp; Detener</button></center>';
												}
												else if(!$play && $playImg == 0) {
													echo '<center><button type="submit" name="submit" class="btn btn-gray">&nbsp;<i class="fe fe-tv"></i>&nbsp; Iniciar</button>';
												}
											}

										}
										else if($_GET["play"] == "video") {
											if(isset($videoParado)) {
												if($videoParado == 1) {
													echo '
														<div class="alert alert-icon alert-success" role="alert">
															<i class="fe fe-check mr-2" aria-hidden="true"></i> Se ha parado la reproducción de video.
														</div>
													';
												}
											}

											# Contenido reproduciendose, le dice si quiere pararlo.
											if(isset($play)) {
												if($play) {
													echo '
														<div class="alert alert-warning" role="alert">
														  Actualmente hay contenido en reproducción y no podrás iniciar otro contenido hasta que no acabes el actual.
														</div>
													';
												}
											}
											
											echo "<form action='playlist.php?play=video' method='post'>";
											echo "<div class='form-group'>";
											echo "<div class='row gutters-sm'>";
											foreach (new DirectoryIterator("uploads/") as $file) {
												if ($file->isFile()) {
													$mostrar = '<img src="./assets/images/mp4.png" class="imagecheck-image">';
													if($file->getExtension() == "mp4" || $file->getExtension() == "avi") {
														echo '
															<div class="col-sm-2">
																<label class="imagecheck mb-4">
																	<input type="checkbox" name="videocheck[]" value="'.$file->getFilename().'" class="imagecheck-input"  />
																	<figure class="imagecheck-figure">
																	   '.$mostrar.'
																	</figure>
																 </label>
																 <span class="tag tag-blue">'.substr(preg_replace("/\.[^.]+$/", "", $file->getFilename()), 0, 20).'</span>&nbsp;
																 <span class="tag tag-gray">.'.$file->getExtension().'</span>
															</div>
														';
													}
												}
											}
											echo "</div>";
											echo "</div>";
												
											# Boton, si hay contenido reproduciendose mostrarle
											if(isset($play)) {
												if($play && $playVideo == 1) {
													echo '<center><button type="submit" name="pararVideo" class="btn btn-danger">&nbsp;<i class="fe fe-zap"></i>&nbsp; Detener</button></center>';
												}
												else if(!$play && $playVideo == 0) {
													echo '<center><button type="submit" name="submit" class="btn btn-gray">&nbsp;<i class="fe fe-tv"></i>&nbsp; Iniciar</button>';
												}
											}
											
										} 
										else if($_GET["play"] == "song") {
											if(isset($songParado)) {
												if($songParado == 1) {
													echo '
														<div class="alert alert-icon alert-success" role="alert">
															<i class="fe fe-check mr-2" aria-hidden="true"></i> Se ha parado la reproducción de música.
														</div>
													';
												}
											}
											
											# Contenido reproduciendose, le dice si quiere pararlo.
											if(isset($play)) {
												if($play) {
													echo '
														<div class="alert alert-warning" role="alert">
															Actualmente hay contenido en reproducción y no podrás iniciar otro contenido hasta que no acabes el actual.
														</div>
													';
												}
											}
											
											echo "<form action='playlist.php?play=song' method='post'>";
											echo "<div class='form-group'>";
											echo "<div class='row gutters-sm'>";
											foreach (new DirectoryIterator("uploads/") as $file) {
												if ($file->isFile()) {
													$mostrar = '<img src="./assets/images/mp3.png" class="imagecheck-image">';
													if($file->getExtension() == "mp3") {
														echo '
															<div class="col-sm-2">
																<label class="imagecheck mb-4">
																	<input type="checkbox" name="soundcheck[]" value="'.$file->getFilename().'" class="imagecheck-input"  />
																	<figure class="imagecheck-figure">
																	   '.$mostrar.'
																	</figure>
																 </label>
																 <span class="tag tag-blue">'.substr(preg_replace("/\.[^.]+$/", "", $file->getFilename()), 0, 20).'</span>&nbsp;
																 <span class="tag tag-gray">.'.$file->getExtension().'</span>
															</div>
														';
													}
												}
											}
											echo "</div>";
											echo "</div>";
											
											# Boton, si hay contenido reproduciendose mostrarle
											if(isset($play)) {
												if($play && $playSnd == 1) {
													echo '<center><button type="submit" name="pararMusica" class="btn btn-danger">&nbsp;<i class="fe fe-zap"></i>&nbsp; Detener</button></center>';
												}
												else if(!$play && $playSnd == 0) {
													echo '<center><button type="submit" name="submit" class="btn btn-gray">&nbsp;<i class="fe fe-tv"></i>&nbsp; Iniciar</button>';
												}
											}
										}
									}
									else {
											# Contenido reproduciendose, le dice si quiere pararlo.
										if(isset($play)) {
											if($play) {
												echo '
													<div class="alert alert-warning" role="alert">
														Actualmente hay contenido en reproducción y no podrás iniciar otro contenido hasta que no acabes el actual.
													</div>
												';
											}
										}
										
										echo '
											<div class="card">
											  <div class="card-header">
												<h3 class="card-title">Sabías que...</h3>
											  </div>
											  <div class="card-body">
												<div class="alert alert-primary" role="alert">
													En este apartado encontrarás un menu en tu parte derecha donde podrás reproducir tu contenido que hayas subido previamente.
												</div>
											  </div>
											</div>
											<center><span class="tag"><b>'.$_SESSION['usuario'].'</b></span><br><i>¿Qué deseas reproducir hoy?</i></center>
										';
									}
								?>
							</div>
						</div>
						<!-- fin-->
					</div>
				</div>
			</div>
        </div>
      </div>
	  
      <footer class="footer">
        <div class="container">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
              <div class="row align-items-center">
                <div class="col-auto">
					<div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
						RaspyTV - Creado por Juan y Alex
					</div>
                </div>
              </div>
            </div>
			<ul class="list-inline list-inline-dots mb-0">
				<li class="list-inline-item"><a href="#"><img src="https://licensebuttons.net/l/by-nc-nd/3.0/es/80x15.png"></a></li>
				<li class="list-inline-item"><a href="#">Documentación</a></li>
				<li class="list-inline-item"><a href="#">Institut Baix Camp</a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </body>
</html>