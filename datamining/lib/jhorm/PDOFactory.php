<?php
class PDOFactory{
	public static function GetPDO($strDSN,$strUser,$strPass,$arParms){
		$strKey = md5(serialize(array($strDSN,$strUser,$strPass,$arParms)));
		if(!isset($GLOBALS["PDOS"][$strKey])){
			$GLOBALS["PDOS"][$strKey] = new JHPDO($strDSN,$strUser,$strPass,$arParms);
		}
		if(!$GLOBALS["PDOS"][$strKey] instanceof PDO){
			$GLOBALS["PDOS"][$strKey] = new JHPDO($strDSN,$strUser,$strPass,$arParms);
		};
		return($GLOBALS["PDOS"][$strKey]);
	}
}


class JHPDO extends PDO{
	
	
}
?>