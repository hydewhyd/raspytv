<?php
	session_start();
	require("./assets/includes/config.php");
	
	if(!isset($_SESSION['usuarioIngresado'])) {
		header("Location: login.php");
		exit;
	} else {
		# Variables necesarias
		$usuario = $_SESSION['usuario'];
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
    <title>Guía - <?php echo $nombreProyecto ?></title>
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
					<a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-folder"></i> Contenido</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
						<a href="./upload.php" class="dropdown-item ">Subir</a>
						<a href="./delete.php" class="dropdown-item ">Eliminar</a>
                    </div>
                  </li>
				  <li class="nav-item">
                    <a href="./guide.php" class="nav-link active"><i class="fe fe-file-text"></i> Guía</a>
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
					Guía
				  </h1>
				</div>

				<div class="row">
					<div class="col-lg-3 order-lg-1 mb-4">
						<div class="list-group list-group-transparent mb-0">
						<?php	
							if(isset($_GET["action"])) {
								if($_GET["action"] == "funcionamiento") {
									echo '
										<a href="./guide.php" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-fa"></i></span>Introducción</a>
										<a href="./guide.php?action=funcionamiento" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fa fa-cogs"></i></span>Funcionamiento</a>
										<a href="./guide.php?action=instalacion" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-package"></i></span>Instalación</a>
										<a href="./guide.php?action=reproduccion" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-send"></i></span>Reproducción</a>
									';
								}
								if($_GET["action"] == "instalacion") {
									echo '
										<a href="./guide.php" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-fa"></i></span>Introducción</a>
										<a href="./guide.php?action=funcionamiento" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-cogs"></i></span>Funcionamiento</a>
										<a href="./guide.php?action=instalacion" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fe fe-package"></i></span>Instalación</a>
										<a href="./guide.php?action=reproduccion" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-send"></i></span>Reproducción</a>
									';
								}
								if($_GET["action"] == "reproduccion") {
									echo '
										<a href="./guide.php" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-fa"></i></span>Introducción</a>
										<a href="./guide.php?action=funcionamiento" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-cogs"></i></span>Funcionamiento</a>
										<a href="./guide.php?action=instalacion" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-package"></i></span>Instalación</a>
										<a href="./guide.php?action=reproduccion" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fe fe-send"></i></span>Reproducción</a>
									';
								}
							}
							else {
									echo '
										<a href="./guide.php" class="list-group-item list-group-item-action active"><span class="icon mr-3"><i class="fa fa-fa"></i></span>Introducción</a>
										<a href="./guide.php?action=funcionamiento" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fa fa-cogs"></i></span>Funcionamiento</a>
										<a href="./guide.php?action=instalacion" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-package"></i></span>Instalación</a>
										<a href="./guide.php?action=reproduccion" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-send"></i></span>Reproducción</a>
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
									if(isset($_GET["action"]) && !empty($_GET["action"])) {
										if($_GET["action"] == "funcionamiento") {
											echo '
												<h2 class="mt-0 mb-4">Funcionamiento</h2>
												<p> Bienvenido a la guia de '.$nombreProyecto.' a continuacio le explicaremos todos los apartados que dispone nuestro producto detalladamente con el proposito de facilitar-le el uso de nuestro producto. </p>
												<p> En la pantalla inicial encontrara informacion sobre el sistema, cantidad de archivos subidos, archivos multimedia reproduciendose, consumo del aparato ... </p>
												<br>
												<img src="./assets/images/guide/Principal.PNG"/>
												<br><br>
												<p> En la parte superior encontrara el menu con los diferentes apartados que tenemos disponibles: </p>
												<br>
												<img src="./assets/images/guide/menu.PNG"/>
												<br><br>
												<p>En el aprartado Contenido encontraremos los apartados de subir archivos y eliminarlos:</p>
												<p> Para realizar la subida de archivos le daremos al boton de seleccionar archivos, se abrira un explorador en el cual tendremos que seleccionar los archivos que queremos subir.</p>
												<p> Por ultimo le daremos al boton de subir de esta manera los archivo.s ya estaran listos para poder reproducir-se. </p>
												<br>
												<img src="./assets/images/guide/Subir.PNG"/>
												<br><br>
												<p>Para eliminar archivos tenemos que selecionar uno a uno los archivos que queremos borrar, una vez que seleccionados tenemos que clicar al boton de eliminar Selección</p>
												<br>
												<img src="./assets/images/guide/Eliminar.PNG"/>
												<br><br>
												<h2> Configurar Usuario </h2>
												<p> Nuestra configuración de usuario se encuentra arriba a la izquierda de la pantalla donde aparece nuestro avatar y el nombre de usuario.</p>
												<p> Cuando clicamos al avatar aparece un desplegable con las opciones, cuenta y salida.  </p>
												<p> A continuacion le explicaré la configuración de usuario que tenemos disponible y opciones que usted puede editar. </p>
												<p> Recuerde utilizar la opcion de salida cuando vaya a dejar de utilizar nuestro producto.</p>
												<br>								
												<img src="./assets/images/guide/Principal.PNG"/>
												<br><br>
												<p> Una vez accedido a el apartado cuenta encontraremos en pantalla la informacion de nuestro usuario.</p>
												<br>
												<img src="./assets/images/guide/cuenta.PNG"/>
												<br><br>
												<p> En la parte derecha encontrará dos opciones para configurar datos del usuario.</p>
												<p> A continuacion explicaré lo que podemos hacer en cada una de las opciones. </p>
												<p> Cambiar contraseña, nos aparecera un formulario donde introduciremos la contraseña dos veces para realizar el cambio </p>
												<p> RECUERDE MEMORIZAR O APUNTAR EN UN LUGAR SEGURO SU NUEVA CONTRASEÑA! </p>
												<br>
												<img src="./assets/images/guide/passwd.PNG"/>
												<br><br>
												<p> Por ultimo disponemos de la opcion de cambiar el avatar </p>
												<p> Para realizar el cambio tenemos que clicar a subir archivo, seleccionar en el explorador la imagen que queremos utilizar y por ultimo clicar al boton de subir.</p>
												<p> Una vez realizado el paso anterior ya tendremos el cambio completado </p>
												<br>
												<img src="./assets/images/guide/avatar.PNG"/>
											';
										} 
										else if($_GET["action"] == "instalacion") {
											echo '
												<h2 class="mt-0 mb-4">Instalación</h2>
												<p> Bienvenido a la guia de instalació de nuestro producto, en este apartado le enseñaremos todas las partes de nuestro dispositivo y las partes que lo componen</p>
												<p> Primero de todo veremos que contiene nuestro kit de '.$nombreProyecto.' </p>
												<p> Como observamos en la siguiente imagen disponemos de la raspberry, un cargador, un adaptador de vga a hdmi y nuestro sistema operativo instalado en la SD</p>
												<img src="./assets/images/guide/kit.PNG"/>
												<p> A continuacion le explicaremos que debe hacer para encender la raspberry </p>
												<p> Primero de todo debe conectar el adaptador siempre que use vga si no directamente conectamos el hdmi a la raspberry  </p>
												<img src="./assets/images/guide/hdmi.PNG"/>
												<p> Una vez realizado el paso anterior tenemos que conectar a la raspberry un cable rj45 para tener conexion a internet y gestionar nuestro producto </p>
												<p> Tambien disponemos de la opcion de conectar nuestro producto via wifi </p>
												<img src="./assets/images/guide/rj45.PNG"/>
												<p> Lo mas importante es introducir nuestra SD para que funcione el producto</p>
												<img src="./assets/images/guide/sd.PNG"/>
												<p> Para terminar conectaremos el cable de alimentación para encender la raspberry</p>
												<img src="./assets/images/guide/encender.PNG"/>
											';
										}
										else if($_GET["action"] == "reproduccion") {
											echo '
												<h2 class="mt-0 mb-4">Reproducción</h2>
												<p>En el apartado de reproducción podrás reproducir tu contenido una vez lo hayas subido en el respectivo apartado. Podrás encontrar los siguientes apartados para reproducir:</p>
												<p>
													<ul>
														<li>Imágenes</li>
														<li>Vídeos</li>
														<li>Música</li>
													</ul>
												</p>
												<img src="./assets/images/guide/repImage.PNG"/>
												<img src="./assets/images/guide/repVideo.PNG"/>
												<img src="./assets/images/guide/repSong.PNG"/>
											';
										}
									}
									else {
										echo '
											<h2 class="mt-0 mb-4">Introducción</h2>
											<center><img src="./assets/images/logo.gif"/></center>
											<p align="center">Te damos la bienvenida al apartado de introducción sobre el proyecto '.$nombreProyecto.'.</p>
											<p align="justify">'.$nombreProyecto.' nace de un proyecto de final de curso realizado en el centro por dos estudiantes de Administración de Sistemas Informáticos y Redes.
												<br><br>
												El propósito de '.$nombreProyecto.' es la función de mostrar contenido multimedia en una pantalla administrado remotamente, gracias a ello se utiliza una Raspberry Pi 3 que hará posible el funcionamiento de mostrar el contenido y poder administrar de forma remota mediante una página web el contenido a mostrar en la pantalla.
											</p>
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