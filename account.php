<?php
	session_start();
	require("./assets/includes/config.php");
	
	if(!isset($_SESSION['usuarioIngresado'])) {
		header("Location: login.php");
		exit;
	}
	
	if(isset($_GET["action"]) && !empty($_GET["action"])) {
		
		if($_GET["action"] == "password") {
			if(isset($_POST["claveNueva"]) && isset($_POST["claveConfirma"])) {
				if(!empty($_POST["claveNueva"]) && !empty($_POST["claveConfirma"])) {
					if($_POST["claveNueva"] == $_POST["claveConfirma"]) {
						# Realiza el cambio de contraseña
						$clave = $_POST["claveNueva"];
						$consulta = "UPDATE `r_users` SET clave = '".md5($clave)."' WHERE usuario = '".$_SESSION['usuario']."'";
						if (mysqli_query($conexionSQL, $consulta)) {
							$claveCambiada = true;
						}
					}
					else $noCoincide = true;
				}
			}
		}
		if($_GET["action"] == "avatar") {
			if(isset($_FILES["file"])) {
				$filename = $_FILES['file']['name'];
				
				$extensiones =  array('gif','png' ,'jpg');
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if(in_array($ext, $extensiones) ) {
					
					unlink('assets/images/avatars/'. $_SESSION['avatar']);
					move_uploaded_file($_FILES['file']['tmp_name'],'assets/images/avatars/'.$filename);
					$_SESSION['avatar'] = $filename;
					
					$consulta = "UPDATE `r_users` SET avatar = '{$filename}'";
					if (mysqli_query($conexionSQL, $consulta)) {
						$archivoSubido = true;
					}
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
    <title>Cuenta - <?php echo $nombreProyecto ?></title>
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
                    <a class="dropdown-item" href="#">
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
						if(isset($_GET["action"])) {
							if($_GET["action"] == "password") {
								echo "Cambiar contraseña";
							}
							if($_GET["action"] == "avatar") {
								echo "Cambiar avatar";
							}
						} else {
							echo "Cuenta";
						}
					?>
				  </h1>
				</div>
				
				<div class="row">
					<div class="col-lg-3 order-lg-1 mb-4">
						<div class="list-group list-group-transparent mb-0">
						<?php	
							if(isset($_GET["action"])) {
								if($_GET["action"] == "password") {
									echo '
										<a href="./account.php" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-user"></i></span>Cuenta</a>
										<a href="./account.php?action=password" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fa fa-key"></i></span>Cambiar contraseña</a>
										<a href="./account.php?action=avatar" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-smile-o"></i></span>Cambiar avatar</a>
									';
								}
								if($_GET["action"] == "avatar") {
									echo '
										<a href="./account.php" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-user"></i></span>Cuenta</a>
										<a href="./account.php?action=password" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-key"></i></span>Cambiar contraseña</a>
										<a href="./account.php?action=avatar" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fa fa-smile-o"></i></span>Cambiar avatar</a>
									';
								}
							}
							else {
								echo '
									<a href="./account.php" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fe fe-user"></i></span>Cuenta</a>
									<a href="./account.php?action=password" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-key"></i></span>Cambiar contraseña</a>
									<a href="./account.php?action=avatar" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-smile-o"></i></span>Cambiar avatar</a>
								';
							}	
						?>
						</div>
					</div>
					<div class="col-lg-9">
						<div class="card">
							<div class="card-body">
								<?php
									if(isset($_GET["action"]) && !empty($_GET["action"])) {
										if($_GET["action"] == "password") {
											
											# Menú modificar su contraseña
											if(isset($claveCambiada)) {
												if($claveCambiada) {
													echo '
														<div class="alert alert-icon alert-success" role="alert">
															<i class="fe fe-check mr-2" aria-hidden="true"></i> Se ha cambiado la clave correctamente, el próximo inicio de sesión deberás introducir la clave nueva.
														</div>
													';
												}
											} 
											else if(isset($noCoincide)) {
												if($noCoincide) {
													echo '
														<div class="alert alert-icon alert-danger" role="alert">
															<i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> La contraseña no coincide o se ha introducido incorrectamente y no es posible el cambio.
														</div>
													';
												}
											}
											else {
												echo '
													<div class="alert alert-icon alert-primary" role="alert">
														<i class="fe fe-bell mr-2" aria-hidden="true"></i> Para cambiar tu contraseña deberás introducir en el formulario una nueva contraseña
													</div>
												';
											}
											
											
											echo '
												<form action="account.php?action=password" method="post">
												   <div>
													  <div class="form-group">
														 <label class="form-label">Nueva contraseña</label>
														 <div class="input-icon">
															<span class="input-icon-addon">
															<i class="fa fa-key"></i>
															</span>
															<input type="password" name="claveNueva" class="form-control" placeholder="Introduce tu nueva contraseña">
														 </div>
													  </div>
													  <div class="form-group">
														 <label class="form-label">
															Confirmar contraseña
														 </label>
														 <div class="input-icon">
															<span class="input-icon-addon">
															<i class="fa fa-key"></i>
															</span>
															<input type="password" class="form-control" name="claveConfirma" placeholder="Introduce la contraseña nuevamente">
														 </div>
													  </div>
													  <div class="form-footer">
														 <button type="submit" class="btn btn-gray btn-block">Cambiar</button>
													  </div>
												   </div>
												</form>
											';
										}
										else if($_GET["action"] == "avatar") {
											# Menú modificar su avatar
											if(isset($archivoSubido)) {
												if($archivoSubido) {
													echo '
														<div class="alert alert-icon alert-success" role="alert">
															<i class="fe fe-check mr-2" aria-hidden="true"></i> Se ha cambiado el avatar correctamente
														</div>
													';
												}
											} else {
												echo '
														<div class="alert alert-icon alert-primary" role="alert">
															<i class="fe fe-bell mr-2" aria-hidden="true"></i> Un avatar es una pequeña imagen de identificación que es mostrada al lado del nombre del usuario cuando esté navegando por la web
														</div>
														<form method="post" action="account.php?action=avatar" enctype="multipart/form-data">
															<input type="file" name="file" id="file"><br>
															<center><button type="submit" name="submit" class="btn btn-gray"><i class="fe fe-upload mr-2"></i>Subir</button></center>
														</form>
													';
											}
										} else {
											# GET incorrecto
											echo '
												<div class="alert alert-danger" role="alert">
												  La opción que has escogido en el menú es incorrecta, vuelve a seleccionar una opción.
												</div>
											';
										}
									} else {
										echo "<div class='alert alert-icon alert-primary' role='alert'>";
										echo "<i class='fe fe-bell mr-2' aria-hidden='true'></i> En este apartado podrás ver y editar la configuración de tu cuenta de <b>" . $_SESSION['usuario'] . "</b></div>";
										echo '
											<div class="form-group">
											   <label class="form-label">Usuario</label>
											   <input type="text" class="form-control" name="example-disabled-input" value=" '. $_SESSION['usuario'] .' " disabled="">
											</div>
											<div class="form-group">
											   <label class="form-label">Contraseña</label>
											   <input type="password" class="form-control" name="example-disabled-input" value="******" disabled="">
											</div>
											<div class="form-group">
											   <label class="form-label">Lema</label>
											   <input type="text" class="form-control" name="example-disabled-input" value=" '. $_SESSION['lema'] .' " disabled="">
											</div>
											<div class="form-group">
											   <label class="form-label">Avatar</label>
											   <input type="text" class="form-control" name="example-disabled-input" value=" '. $_SESSION['avatar'] .' " disabled="">
											</div>
										';
									
									}						
								?>
							</div>
						</div>
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