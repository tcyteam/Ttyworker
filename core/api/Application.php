<?php
abstract class Application extends Communicator
{
	public function Application()
	{
		
	}	
	public function Installation()
	{
		
	}
	public function ExecSqlFile($source)
	{
		$dir = "application/public/ressources/sql/";
        $this->ImportTables($dir.$source);
	}
	public function InstallTable($table,$requete)
	{
		$this->CreateTable($table);
		$this->Insert($requete);
	}
	private function ImportTables($source)
	{
		$req = "";
		$finRequete = false;
		$tables = file($source);
		foreach($tables AS $ligne)
		{
			if($ligne[0] != "-" && $ligne != "")
			{
				$req .= $ligne;
				echo $ligne.'<br>';
				$test = explode(";" , $ligne);
				if(sizeof($test) > 1)
				{
					$finRequete = true;
				}
			}
			if($finRequete)
			{
				$stmt = parent::$communicator['pdo']->prepare($req);
				if(!$stmt->execute())
				{
					throw new PDOException("Impossible d'insérer la ligne:<br>".$req."<hr>", 100);
				}
				$req = "";
				$finRequete = false;
			}
		}
	}
	private function Desinstallation()
	{
		
	}
	private function Insert($requete)
	{
		if(parent::$communicator['pdo']->prepare($requete)->execute())
		{
			echo 'Insert finished succefully';
		}
        else
        {
        	echo 'Problème occured in table creating';
        }		
	}
	private function CreateTable($table,$value,$charset="utf8",$engine="InnoDB")
	{
		$requete = "CREATE TABLE IF NOT EXISTS `".$table."` (".$value.") ENGINE=".$engine." default CHARSET=".$charset.";";
		if(parent::$communicator['pdo']->prepare($requete)->execute())
		{
			echo 'Database created succefully';
		}
        else
        {
        	echo 'Problème occured in database creating';
        }
	}
	private function DeleteTable($table)
	{
		$requete = "DROP TABLE ".$table;
	}
	private function SetTable($name,$set,$close)
	{
		
	}
	private function GetTable($name)
	{
		
	}
	private function SaveTable($name)
	{
		
	}
	private function CreateDataBase($name)
	{
		$heure = time();
		$requete = "CREATE DATABASE".$name.$heure." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		parent::$communicator['pdo']->prepare($requete)->execute();
	}
}
?>