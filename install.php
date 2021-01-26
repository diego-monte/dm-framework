<?php
error_reporting(0);
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
$version = '1.3.1.0'; 

// Connect to the database
function conectDB() {

  $address = htmlentities($_POST['address']);
  $user = htmlentities($_POST['user']);
  $password = htmlentities($_POST['password']);
  $database = htmlentities($_POST['database']);
  $port = (int)htmlentities($_POST['port']);

  $db = new \mysqli($address, $user, $password, $database, $port);
  
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
// Creating a connection file with the .env database
function createFileConexaoMysql() {

	$deploy = basename(__DIR__);

	$source = '	
	usuario = "'.$_POST['user'].'"
	senha = "'.$_POST['password'].'"
	banco = '.$_POST['database'].'
	porta = '.$_POST['port'].'
	endereco = '.$_POST['address'].'
	';

	$fp = fopen(__DIR__ . "/.env","wb");
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
  
  $rand = rand(0,99999999);

	$source = "
    <?php
    /**
     * DM-FRAMEWORK
     * Author: Diego Monte
     * E-Mail: d.h.m@hotmail.com
     * 
     * OBS: The framework is free to change but keep the credits.
     */

		// ARQUIVO DE CONEXAO AO BANCO DE DADOS
		define('DATABASE', parse_ini_file(\".env\", true));
		// PATH'S
		define('PATH_VIEW', \"src/View\");
		define('PATH_CONTROLLER', \"src/Controller\");
		define('PATH_MODEL', \"src/Model\");
		define('PATH_TEMPLATE', \"src/Templates\");
		define('TEMPLATE', \"Default\");
    define('PATH_ASSETS', \"Assets\");
    define('PATH_LOGS', \"Storage/logs\");
    define('PATH_LOGS', dirname(__FILE__) . \"Storage/logs\");
    define('PATH_IMAGES', dirname(__FILE__) . \"/../Storage/images\");
    define('PATH_STORAGE', dirname(__FILE__) . \"/../Storage\");
		// SYSTEM
		define('DEPLOY', \"$deploy\");
		define('PAGE_DEFAULT', \"index\");
    define('VERSION', \"1.3.1.0\");
    // MSGS
    define('MSG_ERROR_TAG', \"ERROR TAG, EXAMPLE OF HOW TO USE TAG {{STRING}}\");
    define('MSG_ERROR_500', \"CLASS DOES NOT EXIST OR IS POORLY STRUCTURED\");
    define('MSG_ERROR_404', \"FILE NOT FOUND\");
    // KEY JWT
    define('KEY_JWT', \"$rand\");
    define('MSG_ERROR_METHOD', \"Method not allowed\");
    define('MSG_ERROR_ARRAY', \"Expected array\");
    define('MSG_ERROR_FILE', \"Accessing file\");
    define('MSG_ERROR_SYSTEM', \"System error\");
    define('MSG_ERROR_RECURSO', \"Unknown resource\");
    define('MSG_ERROR_JSON', \"Invalid json\");
    define('MSG_ERROR_NOT_FUND', \"Data not found\");
    define('MSG_ERROR_USER_TERMINAL', \"Invalid username / password\");
    define('MSG_ERROR_CERTIFY', \"Unauthorized certificate token\");
    define('MSG_ERROR_USER_EXPIRED', \"Expired user\");
    define('MSG_ERROR_ACCESS', \"Unauthorized access to this resource\");
    define('MSG_ERROR_AUTHORIZATION', \"Missing invalid token or authorization type\");
    define('MSG_ERROR_IVALID', \"Invalid parameter\");
    define('MSG_ERROR_TYPE_ACCEPT', \"Missing reader type {accept: application/json}\");
    define('MSG_ERROR_JWT', \"\");
    define('ERROR_FUNCTION', \"\");
    define('MSG_ERROR_DELETE', \"Resource cannot be deleted as it is used by another\");
    define('HTTP_STATUS_100', \"Continue\");
    define('HTTP_STATUS_101', \"Switching Protocols\");
    define('HTTP_STATUS_200', \"OK\");
    define('HTTP_STATUS_201', \"Created\");
    define('HTTP_STATUS_202', \"Accepted\");
    define('HTTP_STATUS_203', \"Non-Authoritative Information\");
    define('HTTP_STATUS_204', \"No Content\");
    define('HTTP_STATUS_205', \"Reset Content\");
    define('HTTP_STATUS_206', \"Partial Content\");
    define('HTTP_STATUS_300', \"Multiple Choices\");
    define('HTTP_STATUS_301', \"Moved Permanently\");
    define('HTTP_STATUS_302', \"Found\");
    define('HTTP_STATUS_303', \"See Other\");
    define('HTTP_STATUS_304', \"Not Modified\");
    define('HTTP_STATUS_305', \"Use Proxy\");
    define('HTTP_STATUS_306', \"(Unused)\");
    define('HTTP_STATUS_307', \"Temporary Redirect\");
    define('HTTP_STATUS_400', \"Bad Request\");
    define('HTTP_STATUS_401', \"Unauthorized\");
    define('HTTP_STATUS_402', \"Payment Required\");
    define('HTTP_STATUS_403', \"Forbidden\");
    define('HTTP_STATUS_404', \"Not Found\");
    define('HTTP_STATUS_405', \"Method Not Allowed\");
    define('HTTP_STATUS_406', \"Not Acceptable\");
    define('HTTP_STATUS_407', \"Proxy Authentication Required\");
    define('HTTP_STATUS_408', \"Request Timeout\");
    define('HTTP_STATUS_409', \"Conflict\");
    define('HTTP_STATUS_410', \"Gone\");
    define('HTTP_STATUS_411', \"Length Required\");
    define('HTTP_STATUS_412', \"Precondition Failed\");
    define('HTTP_STATUS_413', \"Request Entity Too Large\");
    define('HTTP_STATUS_414', \"Request-URI Too Long\");
    define('HTTP_STATUS_415', \"Unsupported Media Type\");
    define('HTTP_STATUS_416', \"Requested Range Not Satisfiable\");
    define('HTTP_STATUS_417', \"Expectation Failed\");
    define('HTTP_STATUS_500', \"Internal Server Error\");
    define('HTTP_STATUS_501', \"Not Implemented\");
    define('HTTP_STATUS_502', \"Bad Gateway\");
    define('HTTP_STATUS_503', \"Service Unavailable\");
    define('HTTP_STATUS_504', \"Gateway Timeout\");
    define('HTTP_STATUS_505', \"HTTP Version Not Supported\");
		?>
	";

	$fp = fopen(__DIR__ . "/Core/Constants.php","wb");
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

  ErrorDocument 400 /src/Errors/404.html
	ErrorDocument 500 /src/Errors/500.html

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

if(count($_POST) > 0) {

	if(isset($_POST['install'])) {

		$status = "";

		if(conectDB()) {

			$finish = array();
			$finish[] = "success";
			$status .= "<i class=\"fas fa-check\" style=\"color:green\"></i> Successfully connected to the database.<br>";

      if(createFileConexaoMysql()) {
        $finish[] = "success";
        $status .= "<i class=\"fas fa-check\" style=\"color:green\"></i> .env file successfully created.<br>";
      } else {
        $finish[] = "problem";
        $status .= "<i class=\"fas fa-times\" style=\"color:red\"></i> Error: problem creating file .env (Permission denied).<br>";
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
                  <input type="text" class="form-control inputs" placeholder="localhost" value="<?php echo(isset($_POST['address']) ? $_POST['address'] : ''); ?>" name="address" id="address">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="user">User:</label>
                  <input type="text" class="form-control inputs" placeholder="root" value="<?php echo(isset($_POST['user']) ? $_POST['user'] : ''); ?>" name="user" cid="user">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input type="text" class="form-control inputs" value="<?php echo(isset($_POST['password']) ? $_POST['password'] : ''); ?>" name="password" id="password">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="database">Database:</label>
                  <input type="text" class="form-control inputs" placeholder="dm_framework" value="<?php echo(isset($_POST['database']) ? $_POST['database'] : ''); ?>" name="database" id="database">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="port">Port:</label>
                  <input type="number" class="form-control inputs" placeholder="3306" value="<?php echo(isset($_POST['port']) ? $_POST['port'] : ''); ?>" name="port" id="port">
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
            <p>Developed by <a href="https://diegomonte.com.br" target="_blank">diegomonte.com.br</a> - <?php echo($version); ?> - 2020-<?php echo(date("Y")); ?></p>
          </div> 
        </div>

      </div>
    </form>
  </div>
</div>

</body>
</html>