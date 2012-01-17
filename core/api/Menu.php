<?php
class Menu extends Tty
{
    public function Menu()
    {
    	$this->helper = new Helper();
        $this->Init();
    }
    public function Adn()
    {
        if((empty($_SESSION['user']->hash_validation)) AND (!empty($_SESSION['user'])))
        {
           $group = new Group();
           $lien_group = $this->FormGroup($_SESSION['user']->gid);
           self::$com['menu_group'] = $group->ViewGroupPermission($lien_group);
           self::$com['menu_droit'] = $group->ViewDroit();
           self::$com['menu'] = true;
        }
        else
        {
            self::$com['menu1'] = false;
        }
        return self::$com['menu'];
    }
	public function AdnConnect()
	{
		$this->helper->Form('formulaire',$this->ReelDir().'adn');
        $this->helper->LineEdit('user')->SetLabel('Login : ');
        $this->helper->SetId('user');
        $this->helper->LineEdit('pass')->SetLabel('Password : ');
        $this->helper->SetMode('password');
        $this->helper->Submit('connexion','Connexion');
        $this->helper->Render();		
	}
	public function AdnConnectMenu()
	{
        $group = new Group();
        $lien_group = $this->FormGroup($_SESSION['user']->gid);
        $viewgroup = $group->ViewGroupPermission($lien_group);
        $perms = $group->ViewDroit();
	    $i=0;
    
	    while($cedroit = $viewgroup->fetch(PDO::FETCH_OBJ))
	    {
		    $vars[$i] = $cedroit->permission;
		    $i++;
	    }
        while($rest = $perms->fetch(PDO::FETCH_OBJ))
        {
            for($t=0; $t<$i; $t++)
		    {
		        if(($vars[$t] == $rest->permission) AND ($rest->signification == 'administration'))
		        {
			  	   $_SESSION['adm-acc'] = $rest->signification;
		        }
		    } 
		    for($t=0; $t<$i; $t++)
		    {
		       if(($vars[$t] == $rest->permission) AND ($rest->signification != 'administration') AND($rest->signification != 'disconnect') AND($rest->signification != 'updategroup')
			   AND($rest->signification != 'insertsend') AND($rest->signification != 'send') AND($rest->signification != 'insertsend') AND($rest->module != 'commande')
			   )
		       {
		          $disLinkMember = ReelDir().$rest->module.'/'.$rest->signification;
                  $disNameMember = ucfirst($rest->nom);
		          $this->helper->Link($disLinkMember,$disNameMember,'li');
		       }
		     }
	    }
		$this->helper->Rend();		
	}
    public function ContactWidget()
    {
        if(empty($_SESSION['user']->hash_validation))
        {
           $contact = new ContactModel();
           self::$com['menu_contact'] = $contact->ViewContact($_SESSION['user']->uid);
           self::$com['menu_user'] = $contact->ViewMember();
           self::$com['menu2'] = true;
        }
        else
        {
            self::$com['menu2'] = false;
        }
        return self::$com['menu2'];
    }
    public function FormGroup($var)
    {
        return $query = "id_group=".$var;
    }
    //strtok($var[$i], ".php")
    public function Init()
    {
        $core = array();
        $app = array();
        
        //Modules inclus dans la partie administration du logiciel
        $core = $this->ScanDir( getcwd().'/core/modules/controller/');
        $app  = $this->ScanDir( getcwd().'/application/public/controller/');
		for($i=0;$i<count($core);$i++)
        {
            require_once(getcwd().'/core/modules/model/'.$core[$i]);
        }
		$count = count($app);
		for($i=0;$i<$count;$i++)
        {
            require_once(getcwd().'/application/public/model/'.$app[$i]);
        }

    }
}
?>