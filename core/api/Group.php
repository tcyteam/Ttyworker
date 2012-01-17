<?php
/**
 * Group
 * 
 * @package api.kodingen
 * @author Yannick Martins
 * @copyright 2011
 * @version $Id$
 * @access public
 */
class Group extends AppModel
{
    public $droit = array();
    public $group = array();
    public $user = array();
    
    /**
     * Group::Group()
     * 
     * @return ne renvoie rien
     */
    public function Group()
    {

    }
    /**
     * Group::AddGroup()
     * 
     * @param mixed $name
     * @param string $permission
     * @return ajoute un groupe à la liste des groupes existants
     */
    public function AddGroup($name,$permission='')
    {
        //recherche dans la bdd si group existe déjà
        $name = ucfirst($name);
        $result = $this->ViewGroup();
        if(!empty($result))
        {
           $nb = $result->fetch();
        }
        if(!empty($nb))
        {
            if(count($result) == 1)
            {
                if($res['id_group'] == $name)
                {
                   exit;
                }
                else
                {
                   $this->group[$name] = $name;
                   foreach($permission as $key=>$value)
                   {
                     $group['permission'] |= $value;
                   }
                   $attr = 'id_group,group_name';
                   $resu = "'".$name."','".$group['permission']."'";     
                   $this->Write($attr,$resu,'group');
                }
            }
            elseif(count($result) > 1)
            {
                while($res = $result->fetch())
                {        
                   if($res['id_group'] == $name)
                   {
                      exit;
                   }
                   else
                   {
                      $this->group[$name] = $name;
                      foreach($permission as $key=>$value)
                      {
                        $group['permission'] |= $value;
                      }
                      $attr = 'id_group,group_name';
                      $resu = "'".$name."','".$group['permission']."'";     
                      $this->Write($attr,$resu,'group');
                      exit;
                   }
                }
            }
        }
        else
        {
            $this->group[$name] = $name;
            foreach($permission as $key=>$value)
            {
                   //selectionne le groupe avec le nom donné
                   $voir = $this->Read('*','id_name='.$name,'group');
                   if(empty($voir))
                   {
                     $group['permission'] |= $value;
                     echo $group['permission'];
                   }
            }
            $attr = 'id_name,permission';
            $resu = "'".$name."','".$group['permission']."'";     
            $this->Write($attr,$resu,'group');
        }

    }
    /**
     * Group::ViewDroit()
     * 
     * @param string $attr
     * @return Permet d'afficher la liste des droits présentes dans la bdd
     */
    public function ViewDroit($attr='')
    {
        $result = $this->Read('*',$attr,'droit');
        return $result;
    }
    /**
     * Group::ViewGroup()
     * 
     * @param string $attr
     * @return Permet d'afficher la liste des groupes présentes dans la bdd
     */
    public function ViewGroup($attr='')
    {
        $result = $this->Read('*',$attr,'group');
        return $result;
    }
    /**
     * Group::ViewGroupPermission()
     * 
     * @param string $attr
     * @return Permet d'afficher la liste des droits du groupe présentes dans la bdd
     */
    public function ViewGroupPermission($attr='')
    {
        $result = $this->Read('*',$attr,'group_permission');
        return $result;
    }
    /**
     * Group::DelGroup()
     * 
     * @return supprime un groupe de la liste des groupes
     */
    public function DelGroup()
    {
    }
    /**
     * Group::UpdateGroup()
     * 
     * @param mixed $name
     * @param mixed $perm
     * @param mixed $type
     * @return met à jour les informations d'un groupe
     */
    public function UpdateGroup($name,$perm,$type)
    {
        $name = ucfirst($name);
        if($type == 'del')
        {
            $query = "id_group='".$name."' AND permission=".$perm;
            $this->Delete($query,'group_permission');
        }
        elseif($type == 'add')
        {
        	$attr = 'id_group,permission';
            $query = '"'.$name.'","'.$perm.'"';
            $this->Write($attr,$query,'group_permission');
        }
		$this->Redirection($this->UrlActuelle(),'0');
        
    }
    /**
     * Group::AddUser()
     * 
     * @return ajoute un utilisateur dans un groupe
     */
    public function AddUser()
    {
    }
    /**
     * Group::DelUser()
     * 
     * @return supprime un utilisateur d'un groupe
     */
    public function DelUser()
    {
    }
    /**
     * Group::AddDroit()
     * 
     * @param mixed $sign
     * @param mixed $module
     * @param mixed $titre
     * @param mixed $explication
     * @return ajoute un droit à la liste des droits
     */
    public function AddDroit($sign,$module,$titre,$explication)
    {
        //selectionne le numero du droit suivant
        $resultView = $this->Read('allright','','allright');
        $readdroit = $resultView->fetch(PDO::FETCH_OBJ);
		$attr = 'permission,signification,module,nom,explication';
        $value = $readdroit->allright.",'".$sign."','".$module."','".$titre."','".$explication."'";
	    $this->Write($attr,$value,'droit'); 
        AppModel::Update("allright=allright+1","allright");    
    }
    public function GenAllRight()
    {

        $attr = "allright";
        $value = 0;
        $value = $this->Interval(100,250);
        for($i=0; $i<150; $i++)
        {
            self::$com['model']->Write($attr,$value[$i],'allright');
        }
    }
    /**
     * Group::DelDroit()
     * 
     * @param mixed $id
     * @return supprime un droit à la liste des droits
     */
    public function DelDroit($id)
    {
        if(!empty($id))
        {
           $close = "permission='".$id."'";
           $this->Delete($close,'droit');
        }
    }
        
}
?>