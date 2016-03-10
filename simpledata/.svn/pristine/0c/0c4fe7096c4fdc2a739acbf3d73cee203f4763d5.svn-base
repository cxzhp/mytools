<?php

    function phpcheckstyle_autoload ($strClassName) {

		$strFileName = PHPCHECKSTYLE_HOME_DIR."/src/".str_replace("\\","/",$strClassName).".php";
		$strFileNameTmp = $strFileName;
		if(!file_exists($strFileName)){
			$strFileName = str_replace("src/","src/PHPCheckstyle/",$strFileNameTmp);
		}
		if(!file_exists($strFileName)){
			$strFileName = str_replace("src/","src/PHPCheckstyle/Config/",$strFileNameTmp);
		}
		if(!file_exists($strFileName)){
			$strFileName = str_replace("src/","src/PHPCheckstyle/Reporter/",$strFileNameTmp);
		}
        include($strFileName);
    }
    spl_autoload_register("phpcheckstyle_autoload");

