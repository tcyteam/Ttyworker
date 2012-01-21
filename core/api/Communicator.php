<?php
/**
 * @author Yannick Martins
 * @see InterfaceNews,InterfaceImage,InterfaceVideo,Application,Addon
 */ 
abstract class Communicator implements News,Social,Video,Outil,Image
{
	public $ComPdo;
	public $ComError;
	public $ComRes;
	public $ComMess;
	public static $communicator = array();
	public static $editor;
	public static $editorOpt;
	
    /**
     * Communicator() est le Contructeur de la classe Communicator
	 * Se connecte à la base de données mysql
     *
     * @return void()
     */
	public function Communicator()
	{
		$this->SqlConnect();
	}
    /**
     * DateFr(date) prend une date aux format 12-12-2012
	 * 
     * @return date au format : dimanche 15 septembre 2012
     */	
	public function DateFr($date) 
	{
        $date = explode("-", $date);
		$date = $date[2].'-'.$date[1].'-'.$date[0];
		
		setlocale(LC_TIME, 'fr');
        
		$format = '-';
        list($day, $month, $year) = explode($format, $date);
	    $date = mktime(0, 0, 0, $month, $day, $year);

        return ucfirst(strftime('%A %d %B %Y', $date));
    }
    /**
	 * News() Fait une requete de selection sans critère vers la table par defaut article
     *
     * @return affiche le resultat sur la vue news
     */		
	public function News()
	{
		$this->GetNews('*','','article order by date_creation asc limit 0, 5');
		require_once("core/modules/view/plugins/news.mrt");		
	}
    /**
	 * News() Fait une requete de selection avec le critère id sur la table article
     *
     * @return affiche le resultat sur la vue readnews
     */		
	public function ReadNews()
	{
		$id = htmlentities($_GET['id1']);
		$this->GetNews('*','id='.$id,'article');
		require_once("core/modules/view/plugins/readnews.mrt");
	}
	public function NewsAdd()
	{
		require_once("core/modules/view/plugins/newsadd.mrt");
		if((isset($_POST['titre'])) AND (isset($_POST['contenu'])))
		{
			$this->AddNews($_POST['titre'],'administrator',htmlspecialchars($_POST['contenu']));
		}
	}	
	public function AddNews($titre='',$auteur='',$area='',$table='article',$imgLink='',$vidLink='')
	{
		if((!empty($titre)) AND (!empty($area)))
		{
		    $date_creation = date("Y-m-d");
		    $heure_creation = date("H:i:s");
		
		    $date_mod = $date_creation;
		    $heure_mod = $heure_creation;
		
		
            $value = "'".$titre."','".$auteur."','".$area."','".$date_creation."','".$heure_creation."','".$imgLink."','".$vidLink."','".$date_mod."','".$heure_mod."'";
		    $attr = '`titre`,`auteur`,`area`,`date_creation`,`heure_creation`,`vid_Link`,`img_Link`,`date_mod`,`heure_mod`';
		    $this->Add($attr,$value,$table);
		}		
	}
	public function GetNews($attr='*',$close='',$table='')
	{
		$this->ComRes = $this->Get($attr,$close,$table);
		self::$communicator['news'] = $this->ComRes; 
		return $this->ComRes;		
	}
	public function DelNews($close,$table='')
	{
		$this->Del($close,$table);		
	}
	public function SetNews($attr='',$close='',$table='')
	{
		$this->Set($attr,$close,$table);		
	}
	public function Verification($titre,$texte,$niv=false,$auteur,$imglien,$vidlien)
	{
	}
	public function Image()
	{
		
	}
	public function AddImage()
	{
		
	}
	public function GetImage()
	{
		
	}
	public function SetImage()
	{
		
	}
	public function DelImage()
	{
		
	}
	public function Outil()
	{
		
	}
	public function AddOutil()
	{
		
	}
	public function GetOutil()
	{
		
	}
	public function SetOutil()
	{
		
	}
	public function DelOutil()
	{
		
	}
	public function Social()
	{
		
	}
	public function AddSocial()
	{
		
	}
	public function GetSocial()
	{
		
	}
	public function SetSocial()
	{
		
	}
	public function DelSocial()
	{
		
	}
	public function Video()
	{
		
	}
	public function AddVideo()
	{
		
	}
	public function GetVideo()
	{
		
	}
	public function SetVideo()
	{
		
	}
	public function DelVideo()
	{
		
	}
	private function Add($attr,$value,$table='')
	{
		if(empty($table))
        {
            $table = $this->ModE();
        }
		
        $query = 'INSERT INTO `'.SGBD.'`.`'.$table.'` ('.$attr.') VALUES ('.$value.')';
		$this->ComMess = $this->ComMess.'<br>'.$query;
		echo $query;
        self::$communicator['pdo']->exec($query);
	}
	private function Del($close,$table='')
	{
        $query = 'DELETE FROM '.SGBD.'.'.$table.' WHERE '.$close;
		$this->ComMess = $this->ComMess.'<br>'.$query;
        self::$communicator['pdo']->exec($query);		
	}
	private function Get($attr='*',$close='',$table='')
	{
        if(!empty($close))
        {
            $close = 'WHERE '.$close;
        }
        $query = 'SELECT '.$attr.' FROM '.SGBD.'.'.$table.' '.$close;
		$this->ComMess = $this->ComMess.'<br>'.$query;
        $this->ComRes =  self::$communicator['pdo']->query($query);
        return $this->ComRes;	
	}
	private function Set($attr='',$close='',$table='')
	{
        if(!empty($attr))
        {
            $attr = ' WHERE '.$attr;
        }
        $query = 'UPDATE '.SGBD.'.'.$table.' SET '.$close.$attr;
		$this->ComMess = $this->ComMess.'<br>'.$query;
        $this->ComRes =  self::$communicator['pdo']->exec($query);
        return $this->ComRes; 		
	}
	private function SqlConnect()
	{
		try
        {
            $sqlhost = SQLHOST; $sqlogin = SQLUSER; $sqlpass = SQLPASS; $sgbd = SGBD;
            $dsn = "mysql:host=$sqlhost;dbname=$sgbd";
            $this->ComPdo = new PDO($dsn,$sqlogin,$sqlpass);
			self::$communicator['pdo'] = $this->ComPdo;
        }
        catch(Exception $e)
        {
           $this->ComSql = 'Erreur : '.$e->getMessage();
        }	  
        return $this->ComPdo; 
	}
    /**
    * @access  protected
    * @return autorise un module Ã  utiliser le l'editeur de texte compris dans l'api
    */         
    protected function AllowEditor($var=false,$option='minimal')
    {
	    self::$editorOpt = $option;
		self::$editor = $var;
	    return self::$editor; 
     } 
    /**
    * @access  protected
    * @return affiche un editeur de texte diffÃ©rents selon que minimal, simple est Ã©tÃ© choisit sinon il affiche la totale
    */         
    protected function CkEditor($name,$width=300)
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
             $this->Msg($editor);
         }
	}	
    protected function NicEdit($name,$option="",$optionList="'fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html','image'",$directory="../externes/nicedit/nicEditorIcons.gif")
	{
	    if(self::$editor)
        {
        	if($option == "full")
			{
				$option=",fullPanel:true";
			}
			elseif($option == "list")
			{
				$option = ",buttonList : [".$optionList."]";
			} 
			new NicEditLoader($name,$option,$optionList,$directory);
		}
	}

}
class NicEditLoader
{
	public function NicEditLoader($name,$option,$optionList,$directory)
	{
		require("core/modules/view/plugins/nicedit.mrt");
	}
}
?>