<?php
/**
 * @abstract class Tty
 * @copyright TtyWorker 2011 by Martins Yannick
 * @licence http://creativecommons.org/licenses/by-nd/3.0/deed.fr
 * @version  1.0
 * Fonction static externe: Load() , ReelDir() 
 */
abstract class Tty extends Application
{
     /**
      * @access  private
      * @return capte la iÃ¨re variable de type get dans le navigateur qui correspondra au module
      */  
     private $moduleRcv;
     /**
      * @access  private
      * @return capte la 2 variable de type get dans le navigateur qui correspondra Ã  l'action
      */     
     private $actionRcv;
     /**
      * @access  private
      * @return capte la 3 variable de type get dans le navigateur qui correspondra Ã  l'action Ã  faire
      */     
     private $doRcv;
     /**
      * @access  private
      * @return capte la 4 variable de type get dans le navigateur qui correspondra Ã  une id ou string
      */     
     private $id1Rcv;
     /**
      * @access  private
      * @return capte la 5 variable de type get dans le navigateur qui correspondra Ã  une id ou string
      */        
     private $id2Rvc;
     /**
      * @access  private
      * @static variable static
      * @return met les 5 variables du get dans une variable static
      */  
     public static $getRcv = array(); 
     /**
      * @access  public
      * @static variable static
      * @return affiche les diffÃ©rents statuts de la connection Ã  une base de donnÃ©e
      */  
     protected $sql= array(); 
     /**
      * @access  public
      * @return enregistre les noms de modules ajouter par l'utilisateur
      */   
      
     public $droit = array(); 
     
     public $externes = array(); 
     
     public $loaderMessage;
     protected $publicPart = array();
     protected $privatePart = array();
     
     protected $instance;
     
     /**
     * @access  public
     * @return permet d'envoyer des informations aux vues
     */ 
     public static $com = array();
     protected $version;
     public static $formStat;
     public static $acces;
     
    /**
     * @access  protected
     * @return permet d'acceder Ã  l'objet courant du controller demandÃ©
     */ 
     protected $appController;
     /**
     * @access  protected
     * @return permet d'acceder Ã  l'objet courant du model demandÃ©
     */ 
     protected $appModel;
     protected $doctype;
     protected $appName;
     protected $charset;  
     protected $css;  
     protected $csscharset;
     protected $plugins;
     protected $jquery;
     protected $cssprint;
     protected $userjs;
     protected $corejs;
     public $menu;
     
     /**
     * @access  public
     * @return contient l'objet courant du helper pour les formulaires et tableaux.
     */ 
     public $helper;
     public $modulable = array();
     public static $level;   
     protected $mod;
     public static $sqlInt = array();
     public static $tab = array();   
     protected $titre;
     public static $echo = array(); 
     protected $var;
     public static $editor;
     public static $editorOpt;
     public static $ACC;
     public static $mysqlStatut;
     public $textError;
     public $appNameVersion; 
     public static $cont; 
     public static $externe = array();
     
     
     
     
     
     /**
      * @method Tty() 
      * @access  protected
      * @return la renderisation du flux html
      * @todo gerer l'ensemble des modifications:
      * model, controller,session,bdd,cache,cron
      */    
     protected function Tty()
     {
         
     }   
     /**
     * @method WindowTitle() 
     * @access  protected
     * @return Nome la fenetre courante
     */
     protected function WindowTitle()
     {
         $this->titre = TITRE;
         return $this->titre;
     }
     /**
      * @method ApplicationHelper() 
      * @access  protected
      * @return Initialise les Helpers 
      */       
     protected function ApplicationHelper()
     {
        $this->helper = new Helper();
        return $this->helper;    
     } 
	 /**
	  * @method Model FormGroup
	  * @access public
	  * @return Appel de l'id pour le model
	  */
	 public function FormGroup($var,$attr='id_group')
     {
        return $query = $attr."='".ucfirst($var)."'";
     }
      /**
     * @method DestroyAll() 
     * @access  protected
     * @return deconnecte les connexios sql et detruit les sessions
     */ 
     protected function DestroyAll()
     {
        // DÃ©truit toutes les variables de session
        $_SESSION = array();

        // Si vous voulez dÃ©truire complÃ¨tement la session, effacez Ã©galement
        // le cookie de session.
        // Note : cela dÃ©truira la session et pas seulement les donnÃ©es de session !
        if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
             );
        }

        // Finalement, on dÃ©truit la session.
        session_destroy();
        //on ferme les connexion sql;
        $this->sql['pdo'] = NULL;
     }
     /**
      * @access  protected
      * @return charge les dÃ©pendances des modules appeler par le navigateur
      */       
     protected function ModuleLoader($dirSpace)
     {   
         //Chargement du fichier controller
         if(file_exists($dirSpace.'controller/'.ucfirst($this->moduleRcv).'.php'))
         {
            require_once($dirSpace.'controller/'.ucfirst($this->moduleRcv).'.php');
            $this->loaderMessage = '';
            $this->loaderMessage = $this->loaderMessage = $this->loaderMessage.'<br>'.ucfirst($this->moduleRcv).'Controller Charge a partir de '.$dirSpace.'controller/';
            $this->modulable['controller'] = 1;
         }
         else
         {
             $this->loaderMessage = $this->loaderMessage.'<br>'.ucfirst($this->moduleRcv).'Controller non trouve dans '.$dirSpace.'controller/';
         }
         //Chargement du fichier Model
         if(file_exists($dirSpace.'model/'.ucfirst($this->moduleRcv).'.php'))
         {
             require_once($dirSpace.'model/'.ucfirst($this->moduleRcv).'.php');
             $this->loaderMessage = $this->loaderMessage.'<br>'.ucfirst($this->moduleRcv).'Model Charge a partir '.$dirSpace.'model/';
             $this->modulable['model'] = 1;
         }
         else
         {
             $this->loaderMessage = $this->loaderMessage.'<br>'.ucfirst($this->moduleRcv).'Model non trouve dans '.$dirSpace.'model/';
         }
         $this->modulable['both'] = $this->modulable['controller'] + $this->modulable['model'];
         $this->SetModulable($this->modulable['both']);
         return $this->loaderMessage;
             
     } 
     /**
     * @access  protected
     * @return verifie si les model et le controller sont lancÃ©es
     */   
     protected function SetModulable($var)
     {
         $this->modulable['both'] = $var;
         return $this->modulable['both'];
     }  
      /**
     * @method Init() 
     * @access  protected
     * @return Initialise les dependances aux controllers
     */  
     protected function Init()
     {
        session_start();
        $this->CapterGet();
        $this->WindowTitle();
        $this->DocType();
		$this->Communicator();
        //ouverture de la connexion Ã  la base de donnÃ©e
        $this->ApplicationSgbd();
        $this->ApplicationHelper();
        //Appel des methodes du controller voir AppController
        $this->CoreController();
        $this->AfterLoadCore();
        $this->Msg('</html>');
     }
     /**
     * @method ExecDocType(var) 
     * @access  protected
     * @return execute les dÃ©clarations des doctype
     */  
     protected function ExecDocType($var)
     {
         echo $var;
     } 
     public function LoaderMessage()
     {
         echo $this->loaderMessage;        
     }
     /**
      * @access  protected
      * @return une connexion Ã  la base de donnÃ©e 
      */       
     protected function ApplicationSgbd()
     {
        try
        {
            $sqlhost = SQLHOST; $sqlogin = SQLUSER; $sqlpass = SQLPASS; $sgbd = SGBD;
            $dsn = "mysql:host=$sqlhost;dbname=$sgbd";
            $this->sql['pdo'] = new PDO($dsn,$sqlogin,$sqlpass);
            self::$com['pdo'] = $this->sql['pdo'];
        }
        catch(Exception $e)
        {
           $this->sql['message'] = 'Erreur : '.$e->getMessage();
        }	  
        return $this->sql['pdo'];  
     } 
      /**
      * @access  protected
      * @return renvoie la valeur des gets dans un tableau accessible par tout les apps
      * @todo les 5 gets sont Ã  definir dans le httacces pour le rewriting
      */       
     protected function CapterGet()
     {
         $this->moduleRcv = htmlentities(ucfirst($_GET['ngi']));
	     $this->actionRcv = htmlentities(ucfirst($_GET['action']));
	     $this->doRcv = htmlentities(ucfirst($_GET['do']));
	     $this->id1Rcv = htmlentities(ucfirst($_GET['id1']));
	     $this->id2Rcv = htmlentities(ucfirst($_GET['id2']));
	 
	     //On met le tout dans un tableau accessible de l'exterieur de l'objet
	     self::$getRcv['module'] = $this->moduleRcv;
	     self::$getRcv['action'] = $this->actionRcv;
	     self::$getRcv['do'] = $this->doRcv;
	     self::$getRcv['id1'] = $this->id1Rcv;
	     self::$getRcv['id2'] = $this->id2Rcv;
	     return self::$getRcv;
     } 
      /**
      * @access  protected
      * @return lit un flux rss et le sous forme de lien Ã  cliquer, utilise une blibliothÃ¨que externes
      */         
     protected function FeedParser($url_feed, $nb_items_affiches=10)
     {   
	    // lecture du fichier distant (flux XML)
	    $rss = fetch_rss($url_feed);

        // si la lecture s'est bien passee,
        // on lit les elements
        if (is_array($rss->items))
        {
           // on ne recupere que les elements les + recents
           $items = array_slice($rss->items, 0, $nb_items_affiches);

           // debut de la liste
           // (vous pouvez indiquer un style CSS
           // pour la formater)
           $html = "<ul>\n";

            // boucle sur tous les elements
            foreach ($items as $item)
            {
               $html .= "<li>";
               $html .= "<a href=\"".$item['link']."\">".$item['title']."</a>";
               $html .= "</li>\n";
            }
	   $html .= "</ul>\n";
        }
	 // retourne le code HTML a inclure dans la page
         return $html;
      } 
      /**
         * @access  protected
         * @return affiche des 10 news ticker grace Ã  la methode feedparser
         * controller, model
         */        
      protected function NewsTicker($lien='news',$var=10)
      {   
	           $this->Msg(
	                '<div id="newsticker">'.
                       $this->FeedParser($lien,$var)
                       .'</div>'
		       );
       }      
      /**
      * @access  protected
      * @return renvoie tru si la classe existe, vous devez definir le type de classe
      * controller, model
      */  
      protected function ClassExists($class,$type='')
      {  
	     if(class_exists($class.$type))
	     {
	        return true;
	     }  
	     else
	     {
	       return false;
	     }
       }
       /**
       * @access  protected
       * @return renvoie tru si la methode existe
       * controller, model
       */  
       protected function MethodExists($class,$method)
       {
           if(method_exists(ucfirst($class),ucfirst($method)))
           {
               return true;
           }
           else
           {
               return false;
           }
       }
	   /**
         * @access  protected
         * @return Force le navigateur ï¿½ tï¿½lï¿½chargï¿½ le fichier en paramï¿½tre
       */
	   protected function ForceDownload($dir,$nom)
	   {
	   	  if((!empty($nom)) AND (file_exists($dir.$nom)))
		  {
		  	  header("Content-type: application/pdf");
              header("Content-Disposition: attachment; filename=$nom");
              readfile($dir.$nom); 
		  }
	   }
      /**
         * @access  protected
         * @return modifie la fonction echo
         */         
       protected function Msg($text)
       {
           echo $text;
       }
      /**
         * @access  protected
         * @return scan les repertoires de modules et renvoie les modules trouvÃ©s
         * @todo Ã  modifier le tableau	 
         */        
       protected function ScanDir($rep)
       {
           $dir = opendir($rep);
           $fileName = array();
           $i=0;
           while ($f = readdir($dir)) 
           {
               if(is_file($rep.'/'.$f)) 
               {
                  $fileName[$i] = $f;
                  $i++;
               }
           }
           return $fileName;
       } 
       public static function CouperChaine($chaine,$el='.')
       {
           $nom = basename($chaine);         
           $elagage=strrchr($nom, $el);          
           $seg = explode($el, $nom);          
           return $seg[0];
       }
           
       /**
       * @access  protected ModuleInstaller()
       * @return installe les modules dÃ©tÃ©ctÃ©s
       * Voir ModuleUninstaller()
       */  
       protected function ModuleInstaller()
       {
           if((!isset($_GET['id1'])) AND (empty($_GET['id1'])))
           {
               $config = $this->ScanDir('core/modules/config');
               for($i=0; $i<count($config); $i++)
               {
                  $message = 'Modules dÃ©tectÃ©(s)<br>';
                  if(!empty($config))
                  {
                      $module = Tty::CouperChaine($config[$i]);
                      $message = $message.'<a href="'.$this->ReelDir().'adn/moduleinstaller/'.strtolower($module).'">'.$module.':::::INSTALLER</a><br>';
                  }
               }
               return $message;
           }
           elseif(($_GET['action'] = 'moduleinstaller') AND (!empty($_GET['id1'])))
           {
               $dom = new DomDocument();
               $dom ->validateOnParse = true;
               $dom->load(Tty::XmlConfigLoader('adn')); 
               $listeModule = $dom->getElementsByTagName("module");
               $listeDroit = $dom->getElementsByTagName("droit");
               echo '<br>------------------------------------------------------------<br/>';
               foreach($listeModule as $module)
               {             
                   echo "Nom du module : " . $module->getAttribute("name")."<br/>".
                   "Auteur : " . $module->getAttribute("auteur")."<br/>".
                   "Version : " . $module->getAttribute("version")."<br/>";
               }
               echo '------------------------------------------------------------<br/>';
                                  echo "Permissions<br /><br />";
               foreach($listeDroit as $droit)
               {
                    echo "Nom affiche : ".$droit->firstChild->nodeValue . "<br />".
                    "Nom action : ".$droit->getAttribute("name")."<br/>";
                    echo "---------<br />";
               }
            }
       }
      /**
         * @access  protected DateLettre($date)
         * @return affiche la date en paramÃ¨tre au format lettre ex: lundi 04 mars 2010
         * Voir aussi DateHeure
         */         
      protected static function DateLettre($date)
      {  
         setlocale(LC_TIME, 'fr');
         $date = Tty::dateToTimestamp($date);
         return ucfirst(strftime('%A %d %B %Y', $date));
      } 
      /**
         * @access  protected
         * @return affiche la date et l'heure
         * Voir aussi DateLettre
      */         
      protected static function DateHeure() 
      {  
	      return date("d/m/Y H:i:s");
      }
      /**
         * @access  protected
         * @return retourne vraie si la date1 est plus grand que la date2
         * protected function datePlusGrand($date1,$date2)
      */        
      protected function datePlusGrand($date1,$date2)
      {
	  $date1 = $this->dateToTimestamp($date1);
	  $date2 = $this->dateToTimestamp($date2);		
	  if($date1 > $date2){return true;} 
      }
       /**
         * @access  protected
         * @return tranforme un timestamp en date
         * protected function TimeStampToDate($timestamp,$format="/")
         * Voir aussi DateToTimestamp($date,$format="/")	 
         */         
      protected function TimeStampToDate($timestamp,$format="/")
      {
	  return date("d/m/Y",$timestamp);
      }
       /**
         * @access  protected
         * @return tranforme une date en timestamp
         * protected function DateToTimestamp($date,$format="/")
         * Voir aussi TimeStampToDate($timestamp,$format="/")	 
         */       
      protected function DateToTimestamp($date,$format="/")
      {
	  list($day, $month, $year) = explode($format, $date);
	  $timestamp = mktime(0, 0, 0, $month, $day, $year);
	  return $timestamp;
      } 
       /**
         * @access  protected
         * @return ajoute un nombre de mois Ã  une date
         * protected function AjouterMois($date,$mois,$format="/")
         * Voir aussi AjouterJour($date,$jour,$format="/")
         */         
      protected function AjouterMois($date,$mois,$format="/")
      {
	   list($day, $month, $year) = explode($format, $date);
	   $date_retour = mktime(0,0,0,$month + $mois  ,$day ,$year);;
	   return $date_retour;
      }
       /**
         * @access  protected
         * @return ajoute un nombre de jours Ã  une date
         * protected function AjouterJour($date,$jour,$format="/")
         * Voir aussi AjouterMois($date,$mois,$format="/")
         */         
      protected function AjouterJour($date,$jour,$format="/")
      {
	   list($day, $month, $year) = explode($format, $date);
	   $date_retour = mktime(0,0,0,$month ,$day + $jour ,$year);;
	   return $date_retour;
      }
       /**
         * @access  protected
         * @return tranforme une date mysql au form d/m/Y
         * protected static function DateMysql($date)
         * Voir aussi DateToTimestamp($date,$format="/")
         */        
      protected static function DateMysql($date)
      { 
 	  list($year, $month, $day) = explode("-", $date);
	  return "$day/$month/$year";  
      } 
       /**
         * @access  protected
         * @return renvoie l'extension du fichier entrer en paramÃ¨tre
         * protected function FileExtension($file)
         */         
      protected function FileExtension($file)
      {
         $extension = explode('.', $file);
         $extension = array_reverse($extension);
         $extension = $extension[0]; 
         return $extension;  
      }
       /** UrlActuelle()
         * @access  protected
         * @return retourne l'url actuelle du serveur
         */        
      protected function UrlActuelle()
      {
         return "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
      }  
      /**
      * Tty::HexaForm()
      * 
      * @param mixed $x
      * @param mixed $nbr
      * @return renvoie les multiple du nombre donnÃ©e
      */
      protected function HexaForm($x,$nbr)
      {
        $j = 1;
        $array[0] = 1;
        for($i=1; $i<$nbr; $i++)
        {
            $j = $j*$x;
            $array[$i] = $j;
        }
        return $array;
      } 
            /**
      * Tty::HexaForm()
      * 
      * @return des nombres Ã  interval
      */
      protected function Interval($x1,$x2)
      {
        for($i=$x1; $i<$x2; $i++)
        {
            $array[$i] = $i;
        }
        return $array;
      } 
      /**
         * @access  protected
         * @return affiche un diaporama de photo en miniature 200*120
      */        
      protected function Diapo($path="application/public/diapo",$iddiapo="diapo")
      {   
         // id du diapo (sera utilisÃ© pour le dom) sans caracteres speciaux 
         $d=new PHPdiapo($path,$iddiapo,"dia",5,array("width"=>200,"height"=>120,"href"=>"news"));
      }
       /**
         * @access  public
         * @return renvoie le temps d'exÃ©cution d'un script
         */         
      public function ExecTime()
      {   
          $debut = microtime(true);          
          $temps = round(microtime(true) - $debut,6);
          return 'Page gÃ©nÃ©rÃ©e en '. $temps .' secondes';
          
      } 
       /**
         * @access  public
         * @return renvoie Vers la racine de l'index du controlleur
         */         
       public function ReelDir()
       {	
          if(isset($_GET['id2']))
          {
	          $var = '../../../';
          }
          elseif(isset($_GET['id1']))
          {
	          $var = '../../';
          }   
          elseif((isset($_GET['action'])) AND (empty($_GET['id1'])))
          {
	          $var = '../';
          }
          else
          {
	          $var = '';
          }
          return $var;
       } 
       protected function Space($nbr)
       {
           for($i=0; $i<$nbr; $i++)
           {
               $var = $var.'&nbsp;';
           }
           return $var;
       }
       protected function GetServeurInfos($mod_name)
       {
           phpinfo();
       }   
       /**
         * @access  public
         * @return renvoie les diffÃ©rents modules charger, definis le charset et l'emplacement des css et autres 
         */          
       protected function DocType($charset='utf-8',$css='core/config/core.php',$cssprint='core/config/core.php',$plugins='externes/scriptaculous/',$csscharset= 'iso-8859-1')
       {
		
	      $plugins='externes/scriptaculous/';
	      $jquery='externes/jquery/';
		  $nivo = $this->ReelDir().'externes/nivo/';
	      $userjs='application/public/ressources/js/userjs.js';
          $corejs='core/ressources/js/core.js';
          $fomvalid='externes/formvalidator/jquery.formvalidation.js';
          $ckeditor='externes/ckeditor/';
		  $jwww='externes/jwww/';
		  $cssfr=$this->ReelDir().'core/ressources/themes/base/menu_fr.css';
		  $cssnl=$this->ReelDir().'core/ressources/themes/base/menu_nl.css';
	  
          $this->css = $this->ReelDir().$css;
		  $this->css = $this->ReelDir().$css;
	      $this->cssprint = $this->ReelDir().$cssprint;
	      $this->charset = $this->ReelDir().$charset;
	      $this->csscharset = $charset;
          $this->plugins = $this->ReelDir().$plugins;	
          $this->jquery = $this->ReelDir().$jquery;	 
          $this->userjs = $this->ReelDir().$userjs;
          $this->corejs = $this->ReelDir().$corejs;
          $formvalidator = $this->ReelDir().$fomvalid;
          $this->ckeditor = $this->ReelDir().$ckeditor;
          $doctype ='
          <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
          <head>
	      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		  <meta name="description" content="Course express et longue distance">';
		  if(empty(self::$getRcv['action']))
		  {
		  	 $doctype = $doctype.'<title>'.$this->titre.' - '.self::$getRcv['module'].' - Acceuil</title>'; 
		  }	
		  else 
		  {
		     $doctype = $doctype.'<title>'.$this->titre.' - '.self::$getRcv['module'].' - '.self::$getRcv['action'].'</title>'; 
		  }       
	      if(JQUERY == "true")
	      {	  
	          $doctype = $doctype.' 
              <script type="text/javascript" src="'.$this->jquery.'jquery-1.5.1.js"></script>	
              <script type="text/javascript" src="'.$this->jquery.'js/jquery-ui-1.8.11.custom.min.js"></script>';
	          if(FILESTYLE == 'true')
	          {
	             $doctype = $doctype.'	  
	             <script type="text/javascript" src="'.$this->jquery.'jquery.filestyle.js"></script>';	 
	          }
              $doctype = $doctype.'      	  
              <link rel="stylesheet" href="'.$this->jquery.'css/blitzer/jquery-ui-1.8.11.custom.css" type="text/css" />';              	  
          }          
          if(TEXTEDITOR == 'true')
          {
	          $doctype = $doctype.'
              <link rel="stylesheet" type="text/css" href="'.$this->ckeditor.'sample.css" />	  
              <script type="text/javascript" src="'.$this->ckeditor.'ckeditor.js"></script>
              <script type="text/javascript" src="'.$this->ckeditor.'sample.js"></script>';           
	      }	 
          if(FORMVALIDATOR == 'true')
          {
	          $doctype = $doctype.'	  
              <script type="text/javascript" src="'.$formvalidator.'"></script>';           
	      } 
          if(PROTOTYPE == 'true')
          {
	          $doctype = $doctype.'	  
              <script type="text/javascript" src="'.$this->plugins.'prototype.js"></script> 
              <script type="text/javascript" src="'.$this->plugins.'scriptaculous.js?load=effects"></script>	
              <script type="text/javascript" src="'.$this->plugins.'effects.js"></script>';
          }
	      if(NEWSTICKER == 'true')
          {
	          $doctype = $doctype.'	  	  
              <script type="text/javascript" src="'.$this->plugins.'newsticker.js"></script>';
	      }
          if(ACCORDION == 'true')
          {
	          $doctype = $doctype.'	  		 
              <script type="text/javascript" src="'.$this->plugins.'accordion.js"></script>';
          }
          if(NIVO == 'true')
		  {
		  	 $doctype = $doctype.'
		  	 <link rel="stylesheet" href="'.$nivo.'themes/default/default.css" type="text/css" />';	
		  	 $doctype = $doctype.'
		  	 <link rel="stylesheet" href="'.$nivo.'themes/pascal/pascal.css" type="text/css" />';
			 $doctype = $doctype.'
		  	 <link rel="stylesheet" href="'.$nivo.'themes/orman/orman.css" type="text/css" />';
		  	 $doctype = $doctype.'
		  	 <link rel="stylesheet" href="'.$nivo.'nivo-slider.css" type="text/css" />'; 
		  	 $doctype = $doctype.'
		  	 <link rel="stylesheet" href="'.$nivo.'style.css" type="text/css" />';
			 $doctype = $doctype.
             '<script type="text/javascript" src="'.$nivo.'jquery.nivo.slider.pack.js"></script>';
		  }	
          if(USERJS == 'true')
          {
	         $doctype = $doctype.'	  	
             <script type="text/javascript" src="'.$this->userjs.'"></script>';
          }	
          $doctype = $doctype.'
          <link rel="shortcut icon" href="'.LOGO.'">';	
          $doctype = $doctype.'	  	
          <script type="text/javascript" src="'.$this->corejs.'"></script>';
          $doctype = $doctype.' 
	      <link media="screen" rel="stylesheet" href="'. $this->css .'" type="text/css" charset="'. $this->csscharset .'" />
	  
	      <link media="print" rel="stylesheet" href="'. $this->cssprint .'" type="text/css" charset="'. $this->csscharset .'" />';
          if(NEWSTICKER == 'true')
          {
	          $doctype = $doctype.'	  		  
	          <link rel="stylesheet" href="'.$this->plugins.'newsticker.css" type="text/css" />';
	      }	 
          if($_SESSION['lang'] == 'nl')
		  {
		  	  $doctype = $doctype.' 
	          <link media="screen" rel="stylesheet" href="'. $cssnl .'" type="text/css" charset="'. $this->csscharset .'" />'; 
		  } 
          elseif($_SESSION['lang'] == 'fr')
		  {
		  	  $doctype = $doctype.' 
	          <link media="screen" rel="stylesheet" href="'. $cssfr .'" type="text/css" charset="'. $this->csscharset .'" />'; 
		  } 
		  else 
		  {
			 $doctype = $doctype.' 
	          <link media="screen" rel="stylesheet" href="'. $cssfr .'" type="text/css" charset="'. $this->csscharset .'" />'; 
		  }
	      $doctype = $doctype.'
          </head>';
	      $this->doctype = $doctype;
	      $this->ExecDocType($this->doctype);
          return $this->doctype;   
       }
        /**
         * @access  public
         * @return Met les droits dans des tableau associatifs
         */
       public function PutInArray($sql,$assoc=false)
	   {
		   $allright = array();
		   //charge tout les droits disponibles
		   if($assoc)
		   {
		       while ($nb = $sql->fetch(PDO::FETCH_OBJ))
               {
		          $tab1[$nb->permission] = $nb->permission;
			      $tab2[$nb->permission] = $nb->nom;
				  $tab3[$nb->permission] = $nb->module;
				  $tab4[$nb->permission] = $nb->signification;
				  $tab5[$nb->permission] = $nb->explication;
               }
               return $tab = array($tab1,$tab2,$tab3,$tab4,$tab5);
		    }
		   //charge les droits du groupe associï¿½ ï¿½ l'utilisateur
		   elseif($assoc==false)
		   {
		   	   while ($nb = $sql->fetch(PDO::FETCH_OBJ))
               {
		          $tab6[$nb->permission] = $nb->permission;
               }
		   	   return $tab6;
		   }	
	    }
       /**
         * @access  protected
         * @return fait une redirection vers le lien donner Ã  x ms donner
         */           
       protected function Redirection($lien,$temp=100)
       {  
	       $this->mod = $this->Msg('<script language="Javascript">
           <!--
           var t=setTimeout("document.location.replace('."'".$lien."'".')", '.$temp.')
           // -->
           </script>');
           return true;   
       } 
       /**
       * @access  protected
       * @return fait une redirection vers le lien donner Ã  x ms donner
       */ 
       protected function Redirect($location)
       {
          $location = strtolower(ReelDir().$location);
          header('Location: '.$location); 
       }
       /**
         * @access  protected
         * @return autorise un module Ã  utiliser le l'editeur de texte compris dans l'api
         */         
       protected function AllowEditor($var=false,$option='simple')
       {
	       self::$editorOpt = $option;
	       return self::$editor = $var; 
       } 
       /**
         * @access  protected
         * @return affiche un editeur de texte diffÃ©rents selon que minimal, simple est Ã©tÃ© choisit sinon il affiche la totale
         */         
       protected function Editor($name,$width="")
       {
	      if(self::$editor)
          {	  
	          if(self::$editorOpt == 'minimal')
	          {
                  $editor = '<script type="text/javascript">';
                  $editor = $editor."CKEDITOR.replace( '".$name."',{toolbar :[";
                  $editor = $editor."['Styles', 'Format'],['Font','FontSize'],['TextColor','BGColor'],['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', '-', 'About']]}); ";
                  $editor = $editor.'</script>';
	          }
              elseif(self::$editorOpt == 'full')
              {
                  $editor = '<script type="text/javascript">';
                  $editor = $editor."CKEDITOR.replace( '".$name."',{toolbar :[";
                  $editor = $editor."['Source','-','Save','NewPage','Preview','-','Templates'],";
                  $editor = $editor."['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],";
                  $editor = $editor."['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat']";
                  $editor = $editor."['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],";
                  $editor = $editor."'/',";
                  $editor = $editor."['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],";
                  $editor = $editor."['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],";
                  $editor = $editor."['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],";
                  $editor = $editor."['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],";
                  $editor = $editor."['BidiLtr', 'BidiRtl'],";
                  $editor = $editor."['Link','Unlink','Anchor'],";
                  $editor = $editor."['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],";
                  $editor = $editor."'/',";
                  $editor = $editor."['Styles','Format','Font','FontSize'],";
                  $editor = $editor."['TextColor','BGColor'],";
                  $editor = $editor." ['Maximize', 'ShowBlocks','-','About']]})";
                  $editor = $editor.'</script>';
              }
         }
         return $editor;
	}
    /**
     * @access  protected
     * @return verifie si une chaine est de type alphaNumÃ©rique
    */ 
    protected function AlphaNum($str)
    {
        preg_match("/([^A-Za-z0-9])/",$str,$result);
        //On cherche tt les caractÃ¨res autre que [A-Za-z] ou [0-9]
        if(!empty($result)){//si on trouve des caractÃ¨re autre que A-Za-z ou 0-9
            return false;
        }
        return true;
    }
    /**
     * @access  protected
     * @return verifie si une chaine est de type numÃ©rique
    */ 
    protected function Number($str)
    {
        preg_match("/([^0-9])/",$str,$result);
        //On cherche tt les caractÃ¨res autre que [A-Za-z] ou [0-9]
        if(!empty($result)){//si on trouve des caractÃ¨re autre que A-Za-z ou 0-9
            return false;
        }
        return true;
    }
    /**
     * @access  protected
     * @return verifie si une chaine est de type alpha
    */ 
    protected function Alpha($str)
    {
        preg_match("/([^A-Za-z])/",$str,$result);
    //On cherche tt les caractÃ¨res autre que [A-z] 
        if(!empty($result)){//si on trouve des caractÃ¨re autre que A-z
            return false;
        }
        return true;
    }
    /**
    * @access  protected
    * @return retourne une chaine de caractÃ¨re avec la taille donnÃ©e en paramÃ¨tre
    */ 
    protected function Alea($size='') 
    {
        $chars = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789';
        $max = strlen($chars)-1;
        $generated = "";
        for($i=0; $i < $size; $i++) 
        {
           $generated.= $chars{mt_rand(0, $max)};
        }
        return $generated;
     } 
     /**
    * @access  protected function GetIp()
    * @return retourne l'adresse ip du visteur 
    */ 	
	 protected function GetIp()
	 {
	 	if(isset($_SERVER['HTTP_X_FORWADED_FOR']))
		{
			$ip = $_SERVER['HTTP_X_FORWADED_FOR'];
		}
		elseif(isset($_SERVER['HTTP_CLIENT_IP']))
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else 
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	 }
     /**
    * @access  protected function GetLang()
    * @return retourne l'adresse ip du visteur 
    */ 	
	 protected function GetLang()
	 {
         if(!isset($langue))
		 {
		    $langue = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
			$langue = strtolower(substr(chop($langue[0],0,2)));
		 }
		 return $langue;
	 }	 
     /**
    * @access  protected function SendMail($dest,$exp,$mess,$sujet,$nom)
    * @return Envoi un email
    */ 		 
     protected function SendEmail($dest,$exp,$mess,$sujet,$nom)
     {
         
         $entete = "MIME-Version: 1.0\r\n";
         $entete .= "Content-type: text/html; charset=iso-8859-1\r\n";
         $entete .= "From: $nom <$exp>\r\n";
         if(mail($dest,$sujet,$mess,$entete))
         {
              return true;
         }
         else
         {
              return false;
         } 
     }
     /**
    * @access  protected function ConnectFtp($serv,$user,$pass)
    * @return  Se connecte à un ftp
    */ 		 
     protected function ConnectFtp($serv,$user,$pass)
     {
         if(self::$com['ftpConnexion'] = ftp_connect($serv))
         {
              if(@ftp_login(self::$com['ftpConnexion'], $user, $pass))
			  {
			  	  $mess = 'Connecté en tant que $user sur $serv\n<br/>';
			  	  self::$com['ftpBuff'] = ftp_rawlist(self::$com['ftpConnexion'], '/');
			  }
			  else 
			  {
			  	  $mess = 'Connexion impossible en tant que '.$user;  
			  }
         }
         else
         {
              $mess = 'Impossible de se connecter à '.$serv;
         } 
		 return $mess;
     }	
     /**
    * @access  protected function DisconnectFtp($con,$buff)
    * @return  Se deconnecte à un ftp
    */ 	     
	 protected function DisconnectFtp($con,$buff)
	 {
	 	 ftp_close($con); //Deconnexion
		 var_dump($buff);
	 } 
     /**
    * @access  function DownloadFtp($con,$dest,$file)
    * @return  Télécharge un fichier depuis le ftp
    */ 	 
	 protected function DownloadFtp($con,$dest,$file)
	 {
	 	if(ftp_get($con,$dest,$file,FTP_BINARY))
		{
			$mess = $con;
		}
		else 
		{
			$mess = 'Problem found';
		}
		return $mess;
	 }
     /**
    * @access  function UploadFtp($con,$remote_file,$local_file)
    * @return  Télécharge un fichier vers le ftp
    */ 	 
	 protected function UploadFtp($con,$remote_file,$local_file)
	 {
	 	if(ftp_put($con,$remote_file,$local_file,FTP_ASCII))
		{
			$mess = $con;
		}
		else 
		{
			$mess = 'Problem found';
		}
		return $mess;
	 }	 
     /*
       public static function ModuleDepend($name)
       {
          inclus le controller et le model de la dÃ©pendance en paramÃ¨tre
          renvoie le dossier de la vue
       }       
     */
     public static function ModuleDepend($name)
     {
         require_once('core/modules/controller/'.ucfirst($name).'.php');
         require_once('core/modules/model/'.ucfirst($name).'.php');
         self::$com['model'] = new MessagerieModel();
         return 'core/modules/view/'.$name.'/';
     }
     //execute la methode entrÃ©e en paramÃ¨tre si elle existe
     public function Get($action)
     {
         $this->$action();
     }
     public static function XmlConfigLoader($name="")
     {
         if((isset($_GET['module'])) and (!empty($_GET['module'])))
         {
             $var = 'core/modules/config/'.ucfirst(self::$getRcv['module']).'.xml';
         }
         else
         {
             $var = 'core/modules/config/'.ucfirst($name).'.xml';
         }
         return $var;
     }     
     private function ModExistsLinkS()
     {
         $action = strtolower(self::$getRcv['action']);
         $id1 = strtolower(self::$getRcv['id1']);
         $id2 = strtolower(self::$getRcv['id2']);
         if(!empty($action))
         {
             if(!empty($id2))
             {
                 return '../../../'.strtolower(htmlentities($_GET['ngi'])).'/'.$action.'/'.$id1.'/'.$id2;
             }          
             elseif(!empty($id1))
             {
                 return '../../'.strtolower(htmlentities($_GET['ngi'])).'/'.$action.'/'.$id1;
             }          
             else
             {
                 
                return '../'.strtolower(htmlentities($_GET['ngi'])).'/'.$action;
             }
         }
         else
         {
            return strtolower(htmlentities($_GET['ngi']));
         }
     }
    /**
     * @access  protected
     * @return verifie si le controller et le model existent dans les dossiers
    */     
    protected function ModExists()
    {  
        $scanOne = 'application/public/controller/'.ucfirst(htmlentities($_GET['ngi'])).'.php';
	    $scanTwo = 'core/modules/controller/'.ucfirst(htmlentities($_GET['ngi'])).'.php';
        $scanThree = 'application/private/controller/'.ucfirst(htmlentities($_GET['ngi'])).'.php';
	  
        if(file_exists($scanOne))
	    {
	        $this->mod = $this->ModExistsLinkS();
	    }
	    elseif(file_exists($scanTwo))
	    {   
            $this->mod = $this->ModExistsLinkS();
	    }
        elseif(file_exists($scanThree))
        {
           
            $this->mod = $this->ModExistsLinkS();	   
        }
        elseif(file_exists(ACCUEILCONTROLLER))
        {
            $this->mod = strtolower(APPNAME);	   
        }
	    else
	    {
	        $this->mod = "Le Module demandÃ© n''existe pas";
	    }
	    return $this->mod;
   
     }
     protected function ModE()
     {  
	  
        if(isset($_GET['ngi']))
	    {
	        $this->mod = $_GET['ngi'];
	    }
	    return $this->mod;
   
     }
       
}









//Fonctions externes
function Load($file)
{
   if(file_exists($file))
   {
       require_once($file);
   }
}		 
?>