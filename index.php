<?php
	session_start();
	
	if(!isset($_SESSION['usuarioIngresado'])) {
		header("Location: login.php");
		exit;
	} else {
		require_once("./assets/includes/config.php");
		
		# Comprueba si desea desloguear
		if((isset($_GET["action"])) && ($_GET["action"] == "logout")) {
			
			session_start();
			session_destroy();
			
			header("Location: login.php");
			exit;
		}
		
		# Seleccionar varios datos del usuario
		$avatar = "./assets/images/avatars/default.gif";
		$consulta = "SELECT * FROM r_users WHERE usuario LIKE '{$_SESSION['usuario']}'";
		$resultado = $conexionSQL->query($consulta);
			
		if($resultado->num_rows > 0) {
			while($row = $resultado->fetch_assoc()) {
				$lema = $row['lema'];
				$avatar = $row['avatar'];
				$play = $row['view'];
				$countContent = $row['countContent'];
			}
			$resultado->close();
		}
		else {
			$lema = "Usuario";
			$avatar = "./assets/images/avatars/default.gif";
		}
		$conexionSQL->close();
	}
	
	$dir = "uploads/";
	$contadorArchivos = 0;
	if (glob($dir . "*") != false)
	{
		$contadorArchivos = count(glob($dir . "*"));
	}
		
	# Obtención de datos
	$usuario = $_SESSION['usuario'];
	$_SESSION['avatar'] = $avatar;
	$_SESSION['lema'] = $lema;

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
    <title>Índice - <?php echo $nombreProyecto ?></title>
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
                      <span class="text-default"><?php echo $usuario ?></span>
                      <small class="text-muted d-block mt-1"><?php echo $lema ?></small>
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
                    <a href="./index.php" class="nav-link active"><i class="fe fe-home"></i> Inicio</a>
                  </li>
				  <li class="nav-item">
                    <a href="./playlist.php" class="nav-link"><i class="fe fe-tv"></i> Reproducción</a>
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
					Índice
				  </h1>
				</div>
				<div class="alert alert-primary">¿Necesitas ayuda? Recuerda que en la parte del menú encontrarás una <a href="./guide.php" class="alert-link">guía</a> explicativa sobre el funcionamiento de <b><?php echo $nombreProyecto ?></b>.</div>
				<?php
					if(isset($play)) {
						if($play) {
							echo '
								<div class="alert alert-warning" role="alert">
									Actualmente hay contenido en reproducción y no podrás iniciar otro contenido hasta que no acabes el actual.
								</div>
							';
						}
					}
				?>
				
				
				<div class="row">
					<div class="col-12">
						<!--continuacion-->
						<div class="card">
							<div class="card-body">
								<p>Hola <b><?php echo $usuario?></b>, te encuentras en la página de inicio.<br></p>
							</div>
						</div>
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Información</h3>
							</div>
							<div class="card-body">
								<p>
								Aquí encontrarás la información del consumo que está en el dispositivo <b><?php echo $nombreProyecto ?></b>
								</p>
								<div class="row row-cards">
									<div class="col-sm-6 col-lg-3">
										<div class="card p-3">
											<div class="d-flex align-items-center">
												<span class="stamp stamp-md bg-gray mr-3">
													<i class="fa fa-info-circle"></i>
												</span>
												<div>
													<h4 class="m-0">
													<?php echo $contadorArchivos ?> 
													<small>
														<?php
															if($contadorArchivos == 1) {
																echo "archivo ";
															} else {
																echo "archivos ";
															}
														?>
													</small>
													</h4>
													<small class="text-muted">
														<?php
															if($contadorArchivos == 1) {
																echo "multimedia almacenado";
															} else {
																echo "multimedia almacenados";
															}
														?>
													</small>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6 col-lg-3">
										<div class="card p-3">
											<div class="d-flex align-items-center">
												<span class="stamp stamp-md bg-blue mr-3">
													<i class="fa fa-video-camera"></i>
												</span>
												<div>
													<h4 class="m-0">
														<?php echo $countContent ?> 
														<small>
															<?php
																if($countContent == 1) {
																	echo "archivo ";
																} else {
																	echo "archivos ";
																}
															?>
														</small>
													</h4>
													<small class="text-muted">reproduciendo</small>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--mas-->
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
				<li class="list-inline-item"><a href="./guide.php">Documentación</a></li>
				<li class="list-inline-item"><a href="http://insbaixcamp.org/" target="_blank">Institut Baix Camp</a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </body>
</html>