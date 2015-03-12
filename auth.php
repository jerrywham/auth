<?php
/**
 * Plugin Auth
 *
 * @package	PLX
 * @version	1.0
 * @date	03/08/2011
 * @author	Cyril MAGUIRE
 **/
class auth extends plxPlugin {

	/**
	 * Constructeur de la classe Auth
	 *
	 * @param	default_lang	langue par défaut utilisée par PluXml
	 * @return	null
	 * @author	Stephane F
	 **/
	public function __construct($default_lang) {

		# Appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);
		
		# Déclarations des hooks		
		$this->addHook('AdminAuthPrepend', 'AdminAuthPrepend');		
	}

	/**
	 * Méthode qui évite de casser le mot de passe par brute force
	 *
	 * @return	stdio
	 * @author	Mordred, Cyril MAGUIRE
	 **/	
	public function AdminAuthPrepend() {
		
		$string = ' /* Modification anti cracking formulaire admin */
		if(!empty($_GET[\'d\']) && $_GET[\'d\']==1 && isset($_SESSION[\'user\']) && isset($_SESSION[\'maxtry\'])) {
			unset($_SESSION[\'maxtry\']);
		}
		if(isset($_SESSION[\'maxtry\']) && $_SESSION[\'maxtry\'] >= 2) {
			exit();
		}
		if(!empty($_POST[\'login\']) AND !empty($_POST[\'password\'])) {
			if(!isset($_SESSION[\'maxtry\'])) {
				$_SESSION[\'maxtry\'] = 1; // Si la sessvar maxtry n\'existe pas on la met à 1 dès qu\'une tentative est faite
			} else{ 
				$_SESSION[\'maxtry\']++; // Si elle existe, on l\'incrémente
				@error_log("Host:".$_SERVER[\'REMOTE_ADDR\']."-PluXml: Login failed. IP : ".$_SERVER[\'REMOTE_ADDR\']);
			}
		}
		';
		echo "<?php ".$string."?>";
	}

}
?>