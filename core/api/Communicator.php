<?php

abstract class Communicator implements News,Social,Video,Outil,Image
{
	public $ComPdo;
	public $ComError;
	public $ComRes;
	public $ComMess;
	public static $communicator = array();
	
	public function Communicator()
	{
		$this->SqlConnect();
	}
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
	public function News()
	{
		require_once("core/modules/view/news/news.mrt");		
	}	
	public function AddNews($titre='',$auteur='',$area='',$table='',$imgLink='',$vidLink='')
	{
		$date_creation = date("Y-m-d");
		$heure_creation = date("H:i:s");
		
		$date_mod = $date_creation;
		$heure_mod = $heure_creation;
		
		
        $value = "'".$titre."','".$auteur."','".$area."','".$date_creation."','".$heure_creation."','".$imgLink."','".$vidLink."','".$date_mod."','".$heure_mod."'";
		$attr = '`titre`,`auteur`,`area`,`date_creation`,`heure_creation`,`vid_Link`,`img_Link`,`date_mod`,`heure_mod`';
		$this->Add($attr,$value,$table);		
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
		echo $query;
		$this->ComMess = $this->ComMess.'<br>'.$query;
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

}
?>