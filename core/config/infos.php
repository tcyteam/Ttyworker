<?php
/***************************************************************
 * staticfunction : simple config files                        *
 *                                                             *
 * @author Yannick Martins                                     * 
 * @license Creative Commons By                                *
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr    *
 * @version 0.9.9                                              *
 ***************************************************************/
    define('COREVERSION','0.1.1');
    define('AUTEUR','Yannick Martins');
    define('EMAIL','tcyteam@gmail.com');
    define('TELEPHONE','+32494675249');
    define('LICENCE','<a href="http://creativecommons.org/licenses/by-nd/3.0/deed.fr">http://creativecommons.org/licenses/by-nd/3.0/deed.fr</a>');
    
    define('COREDIR','core/api/');
    define('COREMODULE','core/modules/');
    define('CORECONFIG','core/config/');   
    define('RESSOURCES','core/ressources/');    
    define('ADD-ON','core/add-on/');  
    define('COREEXTERNE','externes/');    
    define('PUBLICAPP','application/public/');  
    define('PRIVATEAPP','application/private/');  
    
    define('DEBUG','true');
    define('SQLINSTANCE',$sqlInstance);
    define('VALID', $_SESSION['varForm']);// Permet de valider le formulaire
    define('FORMERROR', $_SESSION['formMess']);// Message d'erreur du formulaire     
    
    define('SQLFILE','core/config/sql.php');
    define('APPCONTROLLER','core/api/AppController.php');
    define('APPMODEL','core/api/AppModel.php');
    define('APPHELPER','core/api/Helper.php');
    define('APPIMAGE','core/api/AppImage.php');
    define('ACCUEIL','application/public/');
	define('CORESOURCE','core/modules/');
    define('LINEEDIT','core/api/LineEdit.php');
    define('FORM','core/api/Form.php');
    define('TEXTAREA','core/api/TextArea.php');
    define('SUBMIT','core/api/Submit.php');
    define('TABLE','core/api/Table.php');
    define('CORE','core/api/Tty.php');
    define('CACHE','core/api/Cache.php');
    define('GROUP','core/api/Group.php');
    define('MENU','core/api/Menu.php');
	
	define('INTNEWS','core/api/InterfaceNews.php');
	define('INTSOCIAL','core/api/InterfaceSocial.php');
	define('INTVIDEO','core/api/InterfaceVideo.php');
	define('INTIMAGE','core/api/InterfaceImage.php');
	define('INTOUTIL','core/api/InterfaceOutil.php');
	
	define('COMMUNICATOR','core/api/Communicator.php');
	define('ADDON','core/api/Addon.php');
	define('APPLICATION','core/api/Application.php');
	
    define('SECONDCONTROLLER','application/index.php');
    $_SESSION['exec'] ="non";
    
    require_once(SQLFILE);	
	require_once(INTNEWS);
	require_once(INTSOCIAL);
	require_once(INTVIDEO);
	require_once(INTOUTIL);
	require_once(INTIMAGE);

	require_once(COMMUNICATOR);
	require_once(ADDON);
	require_once(APPLICATION);

    require_once(CACHE);  
    require_once(CORE);	  
    require_once(APPCONTROLLER);	 
    require_once(APPMODEL);
    require_once(GROUP);
    #require_once(APPIMAGE);		 	 	 
    require_once(MENU);
    require_once(APPHELPER);	 
    require_once(LINEEDIT);
    require_once(FORM);
    require_once(TEXTAREA);
    require_once(SUBMIT);
    require_once(TABLE);
    
    function AfficheurPage($nombreDePages,$module,$action)
    {
         echo 'Page : ';
    
         for ($i = 1 ; $i <= $nombreDePages ; $i++) 
         {
           if(isset($_GET['action']))
    	   {
    	     if(isset($_GET['do']))
    		 {
    		   echo '<a href="../../'.$module.'/'.$action.'/' . $i . '">' . $i . '</a> ';
    		 }
    		 else
    		 {
    		   echo '<a href="../'.$module.'/'.$action.'/' . $i . '">' . $i . '</a> ';
    		 }
    	   }
    	   else
    	   {
             echo '<a href="'.$module.'/index/' . $i . '">' . $i . '</a> ';	 
           }  
         }
    }
    function ReelDir()
    {    
        if(isset($_GET['id2']))
        {
    	   $var = '../../../';
        }
        elseif(isset($_GET['id1']))
        {
    	   $var = '../../';
        } 
        elseif(isset($_GET['action']))
        {
    	   $var = '../';
        }
        else
        {
    	   $var = '';
        }
        return $var;
    }

?>