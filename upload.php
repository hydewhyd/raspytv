<?php
	session_start();
	require("./assets/includes/config.php");
	
	if(!isset($_SESSION['usuarioIngresado'])) {
		header("Location: login.php");
		exit;
	} else {
		# Variables necesarias
		$usuario = $_SESSION['usuario'];
		
		if(isset($_POST['submit'])) {
			
			# Count de archivos totales a subir
			$countfiles = count($_FILES['file']['name']);
			
			if($countfiles >= 1) {
				for($i=0;$i<$countfiles;$i++) {
					$filename = $_FILES['file']['name'][$i];
				 
					# Subir archivo
					move_uploaded_file($_FILES['file']['tmp_name'][$i],'uploads/'.$filename);
					$_SESSION['archivoSubido'] = true;
				 
				}
			}
		}
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
    <title>Subir contenido - <?php echo $nombreProyecto ?></title>
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
                    <a href="./playlist.php" class="nav-link"><i class="fe fe-tv"></i> Reproducción</a>
                  </li>
				  <li class="nav-item dropdown">
					<a href="javascript:void(0)" class="nav-link active" data-toggle="dropdown"><i class="fe fe-folder"></i> Contenido</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
						<a href="./upload.php" class="dropdown-item active">Subir</a>
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
					Subir contenido
				  </h1>
				</div>

				<div class="row">
					<div class="col-12">
						<!--continuacion-->
						<div class="alert alert-icon alert-primary" role="alert">
							<i class="fe fe-bell mr-2" aria-hidden="true"></i> En este apartado podrás subir el contenido multimedia (.jpg, .png, .gif, .mp4)
						</div>
						<div class="card">
							<div class="card-body">
								<?php
									if((isset($_GET['action'])) && ($_GET['action'] == "uploaded")) {
										if(isset($_SESSION['archivoSubido'])) {
											echo '
												<div class="alert alert-icon alert-success" role="alert">
													<i class="fe fe-check mr-2" aria-hidden="true"></i> Los archivos han sido subidos correctamente. 
												</div>
											';
											unset($_SESSION['archivoSubido']);
										} else {
											echo "<p>Nada para mostrar</p>";
										}
										
									} else {
										echo '
											<form method="post" action="upload.php?action=uploaded" enctype="multipart/form-data">
												<input type="file" name="file[]" id="file" multiple><br>
												<center><button type="submit" name="submit" class="btn btn-gray"><i class="fe fe-upload mr-2"></i>Subir</button></center>
											</form>
										';
									}
								?>
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
				<li class="list-inline-item"><a href="#">Documentación</a></li>
				<li class="list-inline-item"><a href="#">Institut Baix Camp</a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </body>
</html>