<?php
class AdnModel extends AppModel
{
    public function AdnModel()
    {
        
    }
    public function TryConnect($user,$pass)
    {
        $query = 'user="'.$user.'" AND pass="'.$pass.'"';
        $result = AppModel::Read('*',$query);
        if(!empty($result))
        {
          return $result;
        }
        else
        {
            $result = 0;
            return $result;
        }
    }
	public function AllTest($attr)
	{
	    $attr1 = utf8_encode($attro);
		$attr = html_entity_decode($attr1);
		
		
		$query = "rue LIKE '%$attr%' OR rue LIKE '%".strtolower(utf8_decode($attr))."%' OR rue LIKE '%".ucfirst(utf8_decode($attr))."%' OR rue LIKE '%".strtoupper(utf8_decode($attr))."%' OR (rue LIKE '%".utf8_decode($attr)."%' AND postal='$post')";
        $result = AppModel::Read('*',$query,'commande');
        if(!empty($result))
        {
            return $result;
        }
  
	}
	public function AdnJoin()
	{
		$var = Tty::$com['pdo']->query("select * from adn join client on uid=id_adn where uid = id_adn order by user");
		return $var;
	}
    public function Validation($hash)
    {
        $query = 'hash_validation="'.$hash.'"';
        $result = AppModel::Read('hash_validation',$query);
        if(!empty($result))
        {
            AppModel::Update('hash_validation=""','adn',$query);
            return 1;
        }
        else
        {
            return 0;
        }
    }
	public function UpdateMember($attr,$query)
    {
        AppModel::Update($attr,'adn',$query);
    }
    public function FormGroup($var)
    {
        return $query = "id_group='".ucfirst($var)."'";
    }
    public function Del($user,$pass)
    {
        $query = 'user="'.$user.'" and pass="'.$pass.'"';  date("Y-m-d h:i:s");
        $result = AppModel::Delete($query);
    }
    public function Add($don,$hash,$uid,$group)
    {
    	//insert in table adn
        $value = "'".$uid."','".$don['username']."','".sha1($don['password'])."','".$hash."','".$group."','".$don['email']."','0','".date("Y-m-d")."','". date("Y-m-d h:i:s")."','0','0','0'";       
        $attr = "`uid`,`user`,`pass`,`hash_validation`,`gid`,`email`,`lostpass`,`date_naissance`,`date_inscription`,`ville`,`pays`,`code_postal`";
        AppModel::Write($attr,$value);
    }
	public function Inscription($don,$hash,$uid,$group)
    {      
		//insert in table adn
        $value = "'".$uid."','".utf8_decode($don['username'])."','".sha1($don['password'])."','".$hash."','".$group."','".$don['email']."','0','".date("Y-m-d")."','". date("Y-m-d h:i:s")."','0','0','0'";       
        $attr = "`uid`,`user`,`pass`,`hash_validation`,`gid`,`email`,`lostpass`,`date_naissance`,`date_inscription`,`ville`,`pays`,`code_postal`";
        AppModel::Write($attr,$value,'adn');
        
		//insert in table client
		$value0 = "'".$uid."','".utf8_decode($don['societe'])."','".$don['tva']."','".addslashes(utf8_decode($don['addr_facturation']))."','".utf8_decode($don['ville'])."','".$don['postal']."','".utf8_decode($don['pays'])."','".$don['tel']."','".$don['gsm']."','".$don['fax']."','".$don['pers_expe']."','".addslashes($don['adresse'])."','". date("Y-m-d")."'";       
        $attr0 = "`id_adn`,`societe`,`tva`,`adresse_fact`,`ville`,`postal`,`pays`,`telephone`,`gsm`,`fax`,`nom_responsable`,`adresse_prise_charge`,`date`";
		AppModel::Write($attr0,$value0,'client');
	}
    public function ViewMember($uid='')
    {
        if(!empty($uid))
        {
            $query = "uid=".$uid;
        }
        else
        {
            $query = '';
        }
        $result = AppModel::Read('*',$query);
        return $result;
    }
    public function ViewContact($uid)
    {
        $query = "uid=".$uid;
        $result = AppModel::Read('*',$query,'contact');
        return $result;
    }
    public function ViewModifMember()
    {
       $result = AppModel::Read('*','','adn');
       return $result; 
    }
    public function ModifierMember($user)
    {
       $query = 'user="'.$user.'"';
       $result = AppModel::Read('*',$query,'adn');
       return $result; 
    }
    public function LostPassCompare($email)
    {
        $query = 'email="'.$email.'"';
        $result = AppModel::Read('*',$query,'adn');
        return $result;
    }
    public function LostPassInsert($hash,$email)
    {
        $query = 'lostpass="'.$hash.'"';
        $attr = 'email="'.$email.'"';
        AppModel::Update($query,'adn',$attr);
        $result = AppModel::Read('lostpass',$query);
        if(!empty($result))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function WaitValidView($email)
    {
        $query = 'email="'.$email.'"';
        $result = AppModel::Read('*',$query,'adn');
        return $result;
    }
    public function HashNewPassword($hash,$user,$pass)
    {
        $query = 'lostpass=" " AND pass="'.sha1($user).'"';
        $attr = 'user="'.$user.'" AND lostpass="'.$hash.'"';
        AppModel::Update($query,'adn',$attr);
        $result = AppModel::Read('lostpass',$attr);
        if(!empty($result))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>