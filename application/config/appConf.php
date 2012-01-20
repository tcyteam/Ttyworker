<?php
/***************************************************************
 * staticfunction : simple config files                        *
 *                                                             *
 * @author Yannick Martins                                     * 
 * @license Creative Commons By                                *
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr    *
 * @version 0.1.1                                              *
 ***************************************************************/
 /**
  * Dependance()
  * 
  * @return configure l'application utilisateur'
  */
 function Dependance()
 {	
       define('TITRE','Tcy & Team Site');//titre du programme
       define('VERSION','V 0.0.1');//version du programme
       define('DOMAINE','dev.tcyteam.kodingen.com/');//adresse du site
       define('LOGO',ReelDir().'application/public/ressources/images/icon.png');
       define('APPNAME','Intro'); //Permet de modifier le nom de l'application très important pour les dépendances	 		
       define('ACCUEILCONTROLLER','application/public/controller/Intro.php');// à Modifier pour la page d'accueil de votre application
       define('ACCUEILMODEL','application/public/model/Intro.php');// à Modifier pour la page d'accueil de votre application	 
       define('PDF','externes/fpdf/pdf.php');//Plugins externe pour generer les pdf    
       define('USERMAIL','tcyteam@gmail.com');
	   define('LINK','http://dev.tcyteam.kodingen.com');
	   define('TEL','');
	   define('GSM','0494675249');
       #----------------------------------------------------------------------------------------------------------------------------
       /* Helpers du core
	   Dossier des helpers => Tty/Helper
       */ 
       define('TEXTEDITOR','false');	
	   /*Plugins du co
	   Dossier des plugins => plugins
	   */ 
       define('JQUERY','true');
	   define('NIVO','false');
	   define('NICEDIT','true');
       define('FORMVALIDATOR','false');
       define('FILESTYLE','false');
       define('UNIFORM','false');
       define('NEWSTICKER','false');
       define('ACCORDION','false');	
       define('PROTOTYPE','false');	
       //Fichier js configurable par l'utilisateur	
       define('USERJS','true');	    	  
       #----------------------------------------------------------------------------------------------------------------------------	 	 
       require_once(ACCUEILCONTROLLER);
       require_once(ACCUEILMODEL);
       require_once(PDF);
       #require_once("diaporama.php");//plugins externes
       #require_once("plugins/magpierss/rss_fetch.inc");//plugins externes pour le flux xml

}      
Dependance();
?>