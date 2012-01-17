<?php
class CommentaireModel extends AppModel
{
	public function CommentaireModel()
	{
		
	}	
	public function AddComment($nom,$email,$comment)
	{
		$value = "'".$nom."','".$email."','".$comment."'";
		$attr = 'nom,email,comment'; 
		AppModel::Write($attr,$value,'commentaire');
	}
	public function CountComment()
	{
		$result = AppModel::ReadCount('*','','commentaire');
		return $result;
	}	
	public function ReadComment()
	{
		$result = AppModel::Read('*','','commentaire');
		return $result;
	}
	public function Read($attr='*',$close='',$table='',$order1='',$order2='')
    {
        
        if(empty($table))
        {
            $table = $this->ModE();
        }
        if(!empty($close))
        {
            $close = 'WHERE '.$close;
        }
        $query = 'SELECT '.$attr.' FROM '.SGBD.'.'.$table.' '.$close.' order by id desc limit '.$order1.','.$order2;
		self::$com['result'] =  Tty::$com['pdo']->query($query);
        return self::$com['result'];
    }
}
?>