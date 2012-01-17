<?php
class MessagerieModel extends AppModel
{
    public function MessagerieModel()
    {
    }
    public function AddMessage($don)
    {
        $value = "'".$_SESSION['user']->user."','".$don['destinataire']."','".$don['objet']."','".$don['editor1']."','".date('Y-m-d H:i:s')."',0";  
        $attr = 'id_exp,id_dest,objet,message,date,lu';
        AppModel::Write($attr,$value,'messagerie');
    }
    public function ViewMessage($id_dest,$par='')
    {
    	if(!empty($par))
		{
		    $res = "and id=".$par;		
		}
		else
		{
			$res = '';
		}	
        $query = "id_dest='".$id_dest."' ".$res;
        $result = AppModel::Read('*',$query);
        return $result;
    }
    public function ViewMember($value='')
    {
        $query = "user <> '".$value."'";
        $result = AppModel::Read('*',$query,'adn');
        return $result;
    }
    public function ViewMyMember($uid='')
    {
        if(!empty($uid))
        {
            $query = "uid=".$uid;
        }
        else
        {
            $query = '';
        }
        $result = AppModel::Read('*',$query,'adn');
        return $result;
    }
    public function ViewContact($uid)
    {
        $query = "uid=".$uid;
        $result = AppModel::Read('*',$query,'contact');
        return $result;
    }
}
?>