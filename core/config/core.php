<?php
header('content-type: text/css');
define('FATHER','../ressources/themes/');
?>
body
{
   font-family:Arial, Helvetica, sans-serif; 
   font-size:12px;
   background-color:#212023;
   margin:auto;
   width:100%;
   height:100%;
}
body ul, li
{
    margin:0; 
    padding:0; 
    list-style:none;
}
#api
{
   width:980px;
   color:black;
   margin:auto;
}
#canvas
{
	background-color:
	height:980px;
	margin:auto;
	position:absolute;
	top:0px;
}
#sqltest h1
{
	background-color:#c54b40;
	width:100%;
}
#sqltest
{
	background-color:#36393D;
	width:80%;
	height:50px;
	overflow: auto;
	margin:auto;
	color:white;
	position:fixed;
	bottom:0px;
	left:10%;
	-moz-opacity:0.5;
    opacity: 0.5;
    filter:alpha(opacity=50);
	border:1px inset white;
}
#input#envois
{
	visibility:hidden;
	display:none;
}
form label{  
    display:block;  
    float:left;  
    width:200px;  
    text-align:right; 
    margin-right:2px;
    margin-bottom:1px;
} 
<?php
require_once('sql.php');
class Theme
{
    protected $cssCour;
	protected $cssCore;
	protected $cssApp;
	protected $cssAdd;
	public static $com;
    
    public function Theme()
    {
        $this->ApplicationSgbd();
        $this->cssCour = '../ressources/themes/';
		$this->cssCore = '../ressources/css/';
        $this->LoadTheme();
    }
    /**
    * @access  protected LoadTheme()
    * @return  inclus l'ensemble des fichiers css pour l'application
    */ 			
    protected function LoadTheme()
    {
        $theme = $this->SelectTheme();
        $_SESSION['themeDir'] = $theme->directory;
        $_SESSION['themeName'] =  $theme->name.'.css';
        require_once($this->cssCour.$_SESSION['themeDir'].$_SESSION['themeName']);
		$this->LoadCoreThemes();
    }
    /**
    * @access  protected LoadCoreThemes()
    * @return  Chercher l'ensemble des fichiers css du core en spécifiant le repertoire à scanner
    */ 	
	protected function LoadCoreThemes()
	{
        $this->LoadByExt($this->cssCore);
	}
	protected function LoadApplicationThemes()
	{
		
	}
	protected function LoadAddOnThemes()
	{
		
	}
    /**
    * @access  protected LoadByExt($directory,$extValue='css')
    * @return scan directory, éxtrait les fichiers avec l'extension souhaité puis les inclus 
    */ 	
	protected function LoadByExt($directory,$extValue='css')
	{
		$core = $this->ScanDir($directory);
		for($i=0;$i<count($core);$i++)
        {
        	$ext = strrchr($core[$i],'.');
			$ext = substr($ext,1);
			if($ext == $extValue)
			{
                require_once($directory.$core[$i]);
			}
        }				
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
    protected function SelectTheme($table='theme',$attr='*',$close='')
    {
        if(empty($table))
        {
            $table = $this->ModE();
        }
        if(!empty($close))
        {
            $close = 'WHERE '.$close;
        }
        $query = 'SELECT '.$attr.' FROM '.SGBD.'.'.$table.' '.$close;
        self::$com['result'] = self::$com['pdo']->query($query);
        $theme = self::$com['result']->fetch(PDO::FETCH_OBJ);
        return $theme;
    }
}
$theme = new Theme();
?>