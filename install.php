<?php
error_reporting(0);
/**
 * DM-FRAMEWORK 2020-2020
 * Version: 1.1.0.0
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
// Connect to the database
function conectDB() {

	$db = new \mysqli(
    $_POST['address'], 
    $_POST['user'], 
    $_POST['password'], 
    $_POST['database'], 
    $_POST['port']
  );
	if($db->client_info == null) {
	  return false;
	} else {

    if(isset($_POST['install'])) {
      
      $tableExist = mysqli_query($db, "SHOW TABLES LIKE 'contacts'")->num_rows;

      if ($tableExist > 0) {
        return true;
      }

      $ret = mysqli_query($db, "
        CREATE TABLE `contacts` (
          `ct_id` int(11) NOT NULL AUTO_INCREMENT,
          `ct_name` varchar(45) NOT NULL,
          `ct_email` varchar(45) NOT NULL,
          `ct_subject` varchar(45) NOT NULL,
          `ct_message` varchar(450) NOT NULL,
          `ct_timestamp` datetime DEFAULT NULL,
          PRIMARY KEY (`ct_id`)
        )");
      
      if ($ret === false) {
        return false;
      }

    }
     
	  return true;
  }
	mysqli_close($db);
}
// Creating a connection file with the config.ini database
function createFileConexaoMysql() {

	$deploy = basename(__DIR__);

	$source = '	
	[DATABASE]
	usuario = "'.$_POST['user'].'"
	senha = "'.$_POST['password'].'"
	banco = '.$_POST['database'].'
	porta = '.$_POST['port'].'
	endereco = '.$_POST['address'].'
	';

	$fp = fopen(__DIR__ . "/Config/Conexao_mysql.ini","wb");
	fwrite($fp, $source);
	fclose($fp);

	if($fp) {
		return true;
	} else {
		return false;
	}
}
// Creating file constants
function createFileConstats() {

	$deploy = basename(__DIR__);

	$source = "
    <?php
    /**
     * DM-FRAMEWORK 2020-2020
     * Version: 1.1.0.0
     * Author: Diego Monte
     * E-Mail: d.h.m@hotmail.com
     * 
     * OBS: The framework is free to change but keep the credits.
     */

		// ARQUIVO DE CONEXAO AO BANCO DE DADOS
		define('DATABASE', parse_ini_file(\"Conexao_mysql.ini\", true));
		// PATH'S
		define('PATH_VIEW', \"src/View\");
		define('PATH_CONTROLLER', \"src/Controller\");
		define('PATH_MODEL', \"src/Model\");
		define('PATH_TEMPLATE', \"src/Templates\");
		define('TEMPLATE', \"Default\");
    define('PATH_ASSETS', \"Assets\");
    define('PATH_LOGS', \"Storage/logs\");
		// SYSTEM
		define('DEPLOY', \"$deploy\");
		define('PAGE_DEFAULT', \"index\");
    define('VERSION', \"1.1.0.0\");
    // MSGS
    define('MSG_ERROR_TAG', \"ERROR TAG, EXAMPLE OF HOW TO USE TAG {{STRING}}\");
    define('MSG_ERROR_500', \"CLASS DOES NOT EXIST OR IS POORLY STRUCTURED\");
    define('MSG_ERROR_404', \"FILE NOT FOUND\");
		?>
	";

	$fp = fopen(__DIR__ . "/Config/Constants.php","wb");
	fwrite($fp, $source);
	fclose($fp);

	if($fp) {
		return true;
	} else {
		return false;
	}
}
// Creating htaccess file
function createFileHtaccess() {

  $source = "
  # DM-FRAMEWORK 2020-2020
  # Version: 1.1.0.0
  # Author: Diego Monte
  # E-Mail: d.h.m@hotmail.com
  # OBS: The framework is free to change but keep the credits.

	RewriteEngine On
	RewriteCond %{REQUEST_URI} !-f
	RewriteCond %{REQUEST_URI} !-d
	RewriteCond %{REQUEST_URI} !-l
	RewriteCond $1 !\.(gif|jpe?g|png|ico)$ [NC]
	RewriteRule ^(.*)$ main.php?url=$1 [QSA,L]
	";

	$fp = fopen(__DIR__ . "/.htaccess","wb");
	fwrite($fp, $source);
	fclose($fp);

	if($fp) {
		return true;
	} else {
		return false;
	}
}
// Creating config directory
function createDirConfig() {
	if(mkdir('Config', 0777, true)) {
		chmod('Config', 0777);
		return true;
	} else {
		return false;
	}
}

if(count($_POST) > 0) {

	if(isset($_POST['install'])) {

		$status = "";

		if(conectDB()) {

			$finish = array();
			$finish[] = "success";
			$status .= "<i class=\"fas fa-check\" style=\"color:green\"></i> Successfully connected to the database.<br>";

			if(createDirConfig()) {
				if(createFileConexaoMysql()) {
					$finish[] = "success";
					$status .= "<i class=\"fas fa-check\" style=\"color:green\"></i> Conexao_mysql.ini file successfully created.<br>";
				} else {
					$finish[] = "problem";
					$status .= "<i class=\"fas fa-times\" style=\"color:red\"></i> Error: problem creating file Conexao_mysql.ini (Permission denied).<br>";
				}
				if(createFileConstats()) {
					$finish[] = "success";
					$status .= "<i class=\"fas fa-check\" style=\"color:green\"></i> Constant.php file successfully created.<br>";
				} else {
					$finish[] = "problem";
					$status .= "<i class=\"fas fa-times\" style=\"color:red\"></i> Error: problem creating file Constants.php (Permission denied).<br>";
				}
				if(createFileHtaccess()) {
					$finish[] = "success";
					$status .= "<i class=\"fas fa-check\" style=\"color:green\"></i> .htaccess file successfully created.<br>";
				} else {
					$finish[] = "problem";
					$status .= "<i class=\"fas fa-times\" style=\"color:red\"></i> Error: problem creating file .htaccess (Permission denied).<br>";
				}
			}
		} else {
			$finish[] = "problem";
			$status .= "<i class=\"fas fa-times\" style=\"color:red\"></i> Error: Unable to connect to MySQL.<br>";
		}
	} else if(isset($_POST['test'])) {
 
		$status = "";

		if(conectDB()) { 
			$finish[] = "success";
			$status .= "<i class=\"fas fa-check\" style=\"color:green\"></i> Successfully connected to the database.<br>";
		} else {
			$finish[] = "problem";
			$status .= "<i class=\"fas fa-times\" style=\"color:red\"></i> Error: Unable to connect to MySQL.<br>";
		}
  }

  if(isset($_POST['install'])) {
    if(!in_array("problem", $finish)) {
      $status .= "
        <div class=\"alert alert-light\">
          <strong><i class=\"fas fa-exclamation-triangle\"></i> Notice!</strong> Please for safety <strong>remove</strong> the installer install.php.
        </div>
      ";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <title>Install - DM Framework</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicons -->
  <link href="Storage/images/favicon.ico" rel="icon">
  <link href="Storage/images/favicon.ico" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css'>
  <style>
    body {
      background: #181818;
      font-family: 'PT Sans', sans-serif;
    }
    .btn-install, .btn-test {
      background: #169F44;
      color: #D9D9D9;
      box-shadow: 0 0 3px 2px #141414;
    }
    .btn-install:hover, .btn-test:hover {
      background: #1FC959;
      color: #FFFFFF;
    }
    .btn-test {
      margin-right: 5px;
    }
    .jumbotron {
      background-color: #212121;
      box-shadow: 0 0 3px 2px #141414;
      color: #FFFFFF;
    }
    .card {
      border-radius: 0px;
      background: #181818;
      box-shadow: 0 0 3px 2px #141414;
      margin-bottom: 20px;
    }
    .card-header {
      background: #222222;
      color: #FFFFFF;
      font-weight: bold;
    }
    .card-body {
      background: #121212;
      color: #FFFFFF;
    }
    .inputs, .inputs:hover, .inputs:visited, .inputs:active {
      border-radius: 0px;
      background: #000000;
      border: 0px;
      padding: 10px;
      color: #FFFFFF;
    }
    .footer {
      color: #FFFFFF;
      font-size: 14px;
    }
    a, a:link, a:visited, a:hover, a:active {
      font-size: 14px;
      color: #169F44;
    }
    .status {
		background: #169F44;
		border-radius: 10px;
		padding: 20px;	
    }
    .row {
      margin-bottom: 20px;
    }
	.alert {
		margin-top: 20px;
		padding: 5px;
		border-radius: 30px;
		color: #169F44;
		text-align: center;
  }
  .logo-dois {
    width: 500px;
    height: 95px;
	}
  </style>
</head>
<body>

<div class="jumbotron text-center">
  <img src="Storage/images/logo-dois.png" class="logo-dois" />

</div>
  
<div class="container">
  <div class="row">
    <form action="" method="POST">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><i class="fas fa-cogs"></i> Database connection</div>
          <div class="card-body">
            <div class="row"> 
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="address">Address:</label>
                  <input type="text" class="form-control inputs" placeholder="localhost" value="<?php echo($_POST['address']); ?>" name="address" id="address">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="user">User:</label>
                  <input type="text" class="form-control inputs" placeholder="root" value="<?php echo($_POST['user']); ?>" name="user" cid="user">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input type="text" class="form-control inputs" value="<?php echo($_POST['password']); ?>" name="password" id="password">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="database">Database:</label>
                  <input type="text" class="form-control inputs" placeholder="dm_framework" value="<?php echo($_POST['database']); ?>" name="database" id="database">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="port">Port:</label>
                  <input type="number" class="form-control inputs" placeholder="3306" value="<?php echo($_POST['port']); ?>" name="port" id="port">
                </div>
              </div>
              <?php 
                if(count($_POST) > 0) {
              ?>
              <div class="col-sm-12">
                <div class="status"><?php echo($status); ?></div>
              </div>
              <?php 
                };
              ?> 
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-install float-right" name="install"><i class="fas fa-box-open"></i> Install</button>
            <button type="submit" class="btn btn-test float-right" name="test"><i class="fas fa-server"></i> Test connection</button>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12 text-center footer">
            <p>Developed by <a href="https://diegomonte.com.br" target="_blank">diegomonte.com.br</a> - v1.1.0.0 - 2020-2020</p>
          </div> 
        </div>

      </div>
    </form>
  </div>
</div>

</body>
</html>