<?php
	session_start();
	require("./assets/includes/config.php");
	
	if(!isset($_SESSION['usuarioIngresado'])) {
		
		if(isset($_POST["usuario"]) && isset($_POST["clave"])) {
			
			$usuario = $_POST["usuario"];
			$pass = $_POST["clave"];
			
			$consulta = "SELECT * FROM r_users WHERE usuario = '$usuario' AND clave = '".md5($pass)."'";
			if($resultado = $conexionSQL->query($consulta)) {
				while($row = $resultado->fetch_array()) {
					$userRow = $row["usuario"];
					$claveRow = $row["clave"];
				}
				$resultado->close();
			}
			$conexionSQL->close();
			
			if($usuario == $userRow && md5($pass) == $claveRow) {
				$_SESSION['success'] = true;
				$_SESSION['usuario'] = $usuario;
				header("Location: login.php?action=success");
			}
			else {
				header("Location: login.php?action=error");
			}
		}
	} else {
		header("Location: index.php");
		exit;
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
    <title>Login</title>
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
      <div class="page-single">
        <div class="container">
          <div class="row">
            <div class="col col-login mx-auto">
              <form class="card" action="login.php" method="post">
                <div class="card-body p-6">
                  <div class="card-title">Iniciar sesión</div>
					<?php
						if((isset($_GET["action"])) && ($_GET["action"] == "error")) {
							echo '
								<div class="alert alert-icon alert-danger" role="alert">
								  <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> El usuario o contraseña que has introducido es incorrecto.
								</div>
							';
						}
						if((isset($_GET["action"])) && ($_GET["action"] == "success")) {
							if((isset($_SESSION['success'])) && ($_SESSION['success'] == true)) {
								echo '	
									<div class="alert alert-icon alert-success" role="alert">
										<i class="fe fe-check mr-2" aria-hidden="true"></i> Ingreso correcto, serás redirigido al índice.
									</div>
								';
								$_SESSION['usuarioIngresado'] = true;
								header("refresh:2;url=index.php");
							}
						}
					?>
                  <div class="form-group">
                    <label class="form-label">Usuario</label>
					<div class="input-icon">
							<span class="input-icon-addon">
								<i class="fe fe-user"></i>
							</span>
						<input type="text" name="usuario" class="form-control" placeholder="Introduce tu usuario">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-label">
                      Contraseña
                    </label>
					<div class="input-icon">
							<span class="input-icon-addon">
								<i class="fa fa-key"></i>
							</span>
						<input type="password" class="form-control" name="clave" placeholder="Introduce tu contraseña">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="recordarme"/>
                      <span class="custom-control-label">Recordarme</span>
                    </label>
                  </div>
                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>