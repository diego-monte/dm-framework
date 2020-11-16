
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
		define('DATABASE', parse_ini_file("Conexao_mysql.ini", true));
		// PATH'S
		define('PATH_VIEW', "src/View");
		define('PATH_CONTROLLER', "src/Controller");
		define('PATH_MODEL', "src/Model");
		define('PATH_TEMPLATE', "src/Templates");
		define('TEMPLATE', "Default");
    define('PATH_ASSETS', "Assets");
    define('PATH_LOGS', "Storage/logs");
		// SYSTEM
		define('DEPLOY', "dm-framework");
		define('PAGE_DEFAULT', "index");
    define('VERSION', "1.1.0.0");
    // MSGS
    define('MSG_ERROR_TAG', "ERROR TAG, EXAMPLE OF HOW TO USE TAG {{STRING}}");
    define('MSG_ERROR_500', "CLASS DOES NOT EXIST OR IS POORLY STRUCTURED");
    define('MSG_ERROR_404', "FILE NOT FOUND");
		?>
	