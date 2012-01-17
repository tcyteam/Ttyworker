<?php
/**
 * AppController : simple system controller
 * 
 * @author Yannick Martins
 * @license Creative Commons By
 * @license http://creativecommons.org/licenses/by-nd/3.0/deed.fr
 * @version 1.0
 */
class AppController extends Tty
{
     protected $action;
     protected $module;
     protected $defaut;
     protected $ngi;
     protected $mrt; 

     //Option posible ('debug','hide','oui' => important pour le module adn)
     public static $estLoad = array();
     public static $modo;
     public static $modelModule;
     public static $photo = array();
 
     /**
      * @access  public AppController::AppController()
      * @return la vue appeler par l'utilisateur après avoir demander le model
      */    
     public function AppController()
     {
         $objModel = ucfirst(self::$getRcv['module']).'Model';
         $objController = ucfirst(self::$getRcv['module']).'Controller';
         $this->appModel = new $objModel();
         self::$com['model'] = $this->appModel;
         $this->appController = new $objController(); 
         self::$com['controller'] = $this->appController;
         return $this->appController;
     } 
	 public function MysqlTest()
	 {
	 	 if(($_SESSION['sqltest'] == "true") AND ($_SESSION['user']->gid == 1))
		 {
		     echo '<div id="sqltest">'.self::$com['sql_message'].'</div>';
		 }
	 }
     /**
      * AppController::AppDefault()
      * 
      * @return
      */
     protected function AppDefault()
     {
         $objModel = ucfirst(APPNAME).'Model';
         $objController = ucfirst(APPNAME).'Controller';
         $this->appModel = new $objModel();
         self::$com['model'] = $this->appModel;
         $this->appController = new $objController(); 
         self::$com['controller'] = $this->appController;
         return $this->appController;
     }
     /**
      * @method AppController::ApplicationMenu()
      * @access  protected
      * @return Initialise les menus 
      */       
      protected function ApplicationMenu()
      {
        $this->menu = new Menu();
        return $this->menu;    
      }
     /**
      * @access  protected
      * @return Appel les autres controller puis renvoie le resultat au contructeur
      * @todo gere maintenant tout les controller situé dans les 3 dossier puclic/core/private
      */        
     protected function CoreController()
     {
        $this->ModuleLoader(COREMODULE);
        $this->ModuleLoader(PUBLICAPP); 
        $this->ModuleLoader(PRIVATEAPP);
        if(($this->modulable['both'] >= 2) OR (DEBUG == 'true'))
        {
          if(isset(self::$getRcv['module']) and (!empty(self::$getRcv['module'])))
          {
            if((file_exists('core/modules/controller/'.self::$getRcv['module'].'.php')) AND (file_exists('core/index.php')))
            {
                $this->BeforeLoadCore();
                include_once('core/index.php');  
            }
            elseif((file_exists('application/public/controller/'.self::$getRcv['module'].'.php')) AND (file_exists('core/index.php'))) 
            {
                $this->BeforeLoadCore();
                include_once('core/index.php'); 
            }
            elseif((file_exists('application/private/controller/'.self::$getRcv['module'].'.php')) AND (file_exists('core/index.php'))) 
            {
                $this->BeforeLoadCore();
                include_once('core/index.php'); 
            }  
            else
            {
                $this->BeforeLoadCore();
                $this->helper->TextBox('CoreController n\'existe pas','Le module demandé n\'existe pas');
            }
         }
         else
         {
             $this->BeforeLoadCore();
             include_once('core/index.php');         
         }
       }
       else
       {
         $this->helper->TextBox('Si le module n\'existe pas il faut que DEBUG soit à true dans core/config/infos.php');
       }
     } 
     /**
      * protected AppController::BefforLoadCore()
      * 
      * @return procedure de traitement des menus avant inclusion du controller demandé
      */
     public function BeforeLoadCore()
     {
         $this->ApplicationMenu();
         include_once('core/modules/view/menu/BeforeLoadCore.mrt');
     }
     /**
      * AppController::AfterLoadCore()
      * 
      * @return procedure de traitement des menus après inclusion du controller demandé
      */
     public function AfterLoadCore()
     {
        include_once('core/modules/view/menu/AfterLoadCore.mrt');
     }
     /**
      * AppController::AdminController()
      * 
      * @return verifie que le module demandé existe dans les dossiers renvoie une page d\'erreur ou inclus le fichier'
      */
     protected function AdminController()
     {
         if(isset(self::$getRcv['module']) and (!empty(self::$getRcv['module'])))
         {
            if(file_exists('core/modules/controller/'.self::$getRcv['module'].'.php'))
            {
               include_once('core/modules/index.php');
            }
            elseif(file_exists('application/public/controller/'.self::$getRcv['module'].'.php'))
            {
               include_once('core/modules/index.php');
            }
            elseif(file_exists('application/private/controller/'.self::$getRcv['module'].'.php'))
            {
               include_once('core/modules/index.php');
            }
            else
            {
                if(self::$getRcv['module'] == 'Error')
                {
                    if(self::$getRcv['action'] == 404)
                    {
                       $this->helper->TextBox('Error 404 : ','Le fichier demandé n\'existe pas sur le serveur !');  
                    }
                    elseif(self::$getRcv['action'] == 503)
                    {
                       $this->helper->TextBox('Error 503 : ','Service indisponible !');  
                    }
                    elseif(self::$getRcv['action'] == 403)
                    {
                       $this->helper->TextBox('Error 403 : ','Accès interdit !');  
                    }
                }
                else
                {
                   $this->helper->TextBox('Le module '.self::$getRcv['module'].' n\'existe pas');
                }
           }
         }
         else
         {
            if(file_exists(ACCUEILCONTROLLER))
            {
               include_once(CORESOURCE.'index.php');
            } 
            else
            {
               $this->helper->TextBox('The controller does not exist by default');
            }
         }
 
     }
     /**
     * @access  protected
     * @return verifie les droits d'accès au différentes actions
     * @Valeur : private,ad799rwd,ad769rwd,ad645r,ad499wr,ad599wd,public
     */  
     private function AdminLevelControl($vue)
     {
         //langue par defaut français
         if(empty($_SESSION['lang']))
         {
             $_SESSION['lang'] = 'fr';
         }
         //autoriser à tout le monde
         $action = strtolower(self::$getRcv['action']);
         if($this->appController->droit[$action] == 'private')
         {
             $this->helper->TextBox('Access denied');  
         }
         elseif($this->appController->droit[$action] == 'public')
         {
             $this->appController->$action();
             include_once($vue); 
         }
         elseif(!empty($this->appController->droit[$action]))
         {
             if($this->appController->droit[$action] == strtolower(self::$getRcv['id1']))
             {
                $this->appController->$action();
                include_once($vue); 
				$this->MysqlTest();
             }
         }
         else
         {
             if(!empty($_SESSION['user']))
             {
                $group = new Group();
                $lien_group = $this->FormGroup($_SESSION['user']->gid);
                $viewgroup = $group->ViewGroupPermission($lien_group);
                $perms = $group->ViewDroit();
    
                while ($rest = $perms->fetch(PDO::FETCH_OBJ))
                {
                    if(strtolower($rest->signification) == $action)
                    {
                        while($cedroit = $viewgroup->fetch(PDO::FETCH_OBJ))
                        {
                            if($cedroit->permission == $rest->permission)
                            {
                               $this->appController->$action();
                               include_once($vue);  
							   $this->MysqlTest();
							   $acces = true;                  
                               //on termine le script après affichage des balises de fermetures
                               break;
                            }
							else
							{
								$acces = false;
							}
                        }
                    }
                }
				if($acces == false)
				{
					$this->helper->TextBox('Unauthorized access','You are not authorized to view this page.');
				}

             }
             else
             {
                 $this->helper->TextBox('Access Denied');  
                 header("Location: ".ReelDir().strtolower(APPNAME));
             }
          
         }
     }
    protected function Error()
    {
        $this->Msg('<div id="adnErrorAdd">'.self::$com['req'].self::$com['co'].self::$com['helper'].'</div>');
    }
     /**
      * @access  prrivate AppController::IndexLevelControl($vue)
      * @return affichage du module par defaut
      */
     private function IndexLevelControl($vue)
     {
         $action = strtolower(self::$getRcv['action']);
         $module = strtolower(self::$getRcv['module']);
		 if(empty($_SESSION['lang']))
         {
             $_SESSION['lang'] = 'fr';
         }
         if($this->appController->droit[$action] == 'private')
         {
             $this->helper->TextBox('Accès interdit');
         }
         elseif(!(empty($module)) AND ($this->appController->droit['index'] == 'public'))
         {
            $this->appController->Index();
            include_once($vue);
         }
         elseif((empty($action)) AND ($this->appController->droit['index'] == 'public'))
         {
            $this->appController->Index();
            include_once($vue);
         }
         //rien n'est specifier aucun accès
         else
         {
             if(!empty($module)){ $action = 'index';}

             if(!empty($_SESSION['user']))
             {
                $group = new Group();
                $lien_group = $this->FormGroup($_SESSION['user']->gid);
                $viewgroup = $group->ViewGroupPermission($lien_group);
                $perms = $group->ViewDroit();
         
                while ($rest = $perms->fetch(PDO::FETCH_OBJ))
                {
                    if((strtolower($rest->signification) == $action) AND (strtolower($rest->module == $module)))
                    {
         
                        while($cedroit = $viewgroup->fetch(PDO::FETCH_OBJ))
                        {
                            if($cedroit->permission == $rest->permission)
                            {
                               $this->appController->$action();
                               include_once($vue); 
							   $acces = true;                     
                               //on termine le script après affichage des balises de fermetures
                               break;
                            }
							else
							{
								$acces = false;
							}	
                        }
                    }
                }
				if($acces == false)
				{
					$this->helper->TextBox('Unauthorized access','You are not authorized to view this page.');
				}
                //verifie que le compte est actif
         
             }
             else
             {
                 $this->helper->TextBox('Unauthorized access');  
             }
          
         }
     }
         
     /**
      * @access  protected AppController::SecondController()
      * @return Appel le public et le private (controller) et renovoie le tout au frontcontroller
      */        
     protected function SecondController()
     {
         define('VUES1','application/public/view/'.strtolower(self::$getRcv['module']).'/'.strtolower(self::$getRcv['action'].'.mrt'));     
         define('VUES2','application/private/view/'.strtolower(self::$getRcv['module']).'/'.strtolower(self::$getRcv['action'].'.mrt'));
         define('VUES3','core/modules/view/'.strtolower(self::$getRcv['module']).'/'.strtolower(self::$getRcv['action'].'.mrt'));
         define('DEFS1','application/public/view/'.strtolower(self::$getRcv['module']).'/index.mrt');     
         define('DEFS2','application/private/view/'.strtolower(self::$getRcv['module']).'/index.mrt');
         define('DEFS3','core/modules/view/'.strtolower(self::$getRcv['module']).'/'.'index.mrt');
         
         $module = self::$getRcv['module'];
         $action = self::$getRcv['action'];
         $id1 = self::$getRcv['id1'];
         $id2 = self::$getRcv['id2'];
         
         if((isset(self::$getRcv['module'])) and (!empty(self::$getRcv['module'])))
         {
             
             if((isset(self::$getRcv['action'])) and (!empty(self::$getRcv['action'])))
             {
                 if(($this->ClassExists(self::$getRcv['module'],'Controller')) AND (file_exists(VUES1)) AND ($this->MethodExists(self::$getRcv['module'].'Controller',self::$getRcv['action'])))
                 {
                     $this->AppController();
                     $this->AdminLevelControl(VUES1);
                 }
                 elseif(($this->ClassExists(self::$getRcv['module'],'Controller')) AND (file_exists(VUES2)) AND ($this->MethodExists(self::$getRcv['module'].'Controller',self::$getRcv['action'])))
                 {
                     $this->AppController();
                     $this->AdminLevelControl(VUES2);
                 }
                 elseif(($this->ClassExists(self::$getRcv['module'],'Controller')) AND (file_exists(VUES3))AND ($this->MethodExists(self::$getRcv['module'].'Controller',self::$getRcv['action'])))
                 {
                     $this->AppController();
                     $this->AdminLevelControl(VUES3);
                 }
                 else
                 {     
                    if($this->ClassExists(self::$getRcv['action']) == false)
                    {
                         $this->helper->TextBox('Error','The method '.ucfirst($action).' is not implemented');
                    }
                    else
                    {
                         $this->helper->TextBox('Error','the file linked to the action '.ucfirst($action).' does not exist');
                    }
                 }
             }
             else
             {
                 if(($this->ClassExists(self::$getRcv['module'],'Controller')) AND (file_exists(DEFS1)))
                 {
                     $this->AppController();
                     $this->IndexLevelControl(DEFS1);
                 }
                 elseif(($this->ClassExists(self::$getRcv['module'],'Controller')) AND (file_exists(DEFS2)))
                 {
                     $this->AppController();
                     $this->IndexLevelControl(DEFS2);
                 }
                 elseif(($this->ClassExists(self::$getRcv['module'],'Controller')) AND (file_exists(DEFS3)))
                 {
                     $this->AppController();
                     $this->IndexLevelControl(DEFS3);
                 }
                 else
                 {                     
                    if($this->ClassExists(self::$getRcv['action']) == false)
                    {
                         $this->helper->TextBox('Error','The method '.ucfirst($action).' is not implemented');
                    }
                    else
                    {
                         $this->helper->TextBox('Error','the file linked to the action '.ucfirst($action).' does not exist');
                    }
                 }
             }
         }
         else
         {
             $this->AppDefault();
             $this->IndexLevelControl(ACCUEIL.'view/'.strtolower(APPNAME).'/index.mrt');
         } 
     }      
   
}  