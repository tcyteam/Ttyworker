<?php
/**
* AppModel : simple sql function
* 
* @author Yannick Martins
* @license Creative Commons By
* @license http://creativecommons.org/licenses/by-nd/3.0/deed.fr
* @version 1.0
*/
class AppModel extends Tty
{
    /**
    * AppModel : simple sql function
    * � faire htmlentities()
	* self::$com['sql_message'] == pour le debug
    */
    public function AppModel()
    {

    }
    /**
    * Read : fonction de lecture 
    * @ return Read(attr,close,table);
    */
    public function Read($attr='*',$close='',$table='')
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
		self::$com['sql_message'] = self::$com['sql_message'].'<br>'.$query;
        self::$com['result'] =  Tty::$com['pdo']->query($query);
        return self::$com['result'];
    }
	/**
    * Read : fonction de lecture 
    * @ return Read(attr,close,table);
    */
    public function ReadCount($attr='*',$close='',$table='')
    {
        
        if(empty($table))
        {
            $table = $this->ModE();
        }
        if(!empty($close))
        {
            $close = 'WHERE '.$close;
        }
        $query = 'SELECT COUNT('.$attr.') FROM '.SGBD.'.'.$table.' '.$close;
		self::$com['sql_message'] = self::$com['sql_message'].'<br>'.$query;
        self::$com['result'] =  Tty::$com['pdo']->query($query);
        return self::$com['result'];
    }
    /**
    * @acces public
    * Write permet d'ecrire dans un table
    * @ return Write(attr,close,table);
    */
    public function Write($attr,$value,$table='')
    {
        if(empty($table))
        {
            $table = $this->ModE();
        }
		
        $query = 'INSERT INTO `'.SGBD.'`.`'.$table.'` ('.$attr.') VALUES ('.$value.')';
		self::$com['sql_message'] = self::$com['sql_message'].'<br>'.$query;
        Tty::$com['pdo']->exec($query);
    }
    public function FormGroup($var)
    {
        return $query = "id_group=".$var;
    }
    /**
    * @acces protected
    * Write permet d'effacer dans une table
    * @return delete(close,table);
    */
    protected function Delete($close,$table='')
    {          
        if(empty($table))
        {
            $table = $this->ModE();
        }
        $query = 'DELETE FROM '.SGBD.'.'.$table.' WHERE '.$close;
		self::$com['sql_message'] = self::$com['sql_message'].'<br>'.$query;
        Tty::$com['pdo']->exec($query);
    }
    /**
    * @acces protected
    * Met � jour une table
    * @return Update($close,$table='',$attr='');
    */
    protected function Update($close,$table='',$attr='')
    {
        if(empty($table))
        {
            $table = $this->ModE();
        }
        if(!empty($attr))
        {
            $attr = ' WHERE '.$attr;
        }
        $query = 'UPDATE '.SGBD.'.'.$table.' SET '.$close.$attr;
		self::$com['sql_message'] = self::$com['sql_message'].'<br>'.$query;
        self::$com['result'] =  Tty::$com['pdo']->exec($query);
        return self::$com['result']; 
    }
    protected function GenerateRights($niveau=250)
    {
        $attr = "allright";
        $value = 0;
        $value = $this->HexaForm(2,$niveau);
        for($i=0; $i<$niveau; $i++)
        {
            self::$com['model']->Write($attr,$value[$i],'allright');
        }
    }
}
?>