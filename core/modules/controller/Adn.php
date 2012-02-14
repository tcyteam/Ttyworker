<?php
//Module de connexion lié au controller
class AdnController extends AppController
{
    protected $mess;
    protected $uid;
	
	/**
	 * Mets certaines vues en public pour permettre à tout les monde d'y acceder
	 */
    public function AdnController()
    {
        $this->droit['tryconnect'] = 'private';
        $this->droit['tryconnectModel'] = 'private';
        $this->droit['notEmpty'] = 'private';
        $this->droit['tryconnect'] = 'public';
        $this->droit['waitvalid'] = 'public';
        $this->droit['validation'] = 'public';
        $this->droit['index'] = 'public';
        $this->droit['lostpass'] = 'public';
        $this->droit['inscription'] = 'public';
        $this->droit['insertsend'] = 'public';
		$this->droit['alltest'] = 'public';
		$this->droit['bugreport'] = 'public';
        $this->droit['newpassword'] = 'public';
        $this->droit['loginreturn'] = 'public';
    }
	/**
	 *  protected function Index()
	 *
	 * @return Verifie qu'on est connecté puis renvoie vers la page connect sinon il réafiche la vue index
	 *  
	 */
    protected function Index()
    {
        if($_SESSION['co'] == true)
        {
            $this->Redirect(ReelDir()."adn/connect");
        }
        else
        {
            $this->TryConnect();
        }
    }
	/**
	 * protected function CheckValid($mod='')
	 *
	 *@return Verifie que le compte de l'utilisateur soit activé
	 * Si oui il renvoie vers la page connect si non il renvoie vers la vue waitvalid
	 */
    protected function CheckValid($mod='')
    {
        if(empty($_SESSION['user']['hash_validation']))
        {
            $this->Redirection(ReelDir().$mod.'connect',4);
        }
        else
        {
           $this->Redirection(ReelDir().$mod.'waitvalid',4); 
        }
    }
	/**
	 * protected function AddDroit()
	 *
	 * @return Ajoute une permission à la liste existante
	 * Et inscrit dans une base de donnée
	 */
    protected function AddDroit()
    {
        $sign = htmlspecialchars($_POST['nom']);
        $titre = htmlspecialchars($_POST['nom_aff']);
        $module = htmlspecialchars($_POST['module']);
        $explication= htmlspecialchars($_POST['explication']);
        $droit = new Group();
        //Ajout d'un nouveau droit si inéxistant
        if(isset($_POST['adddroit']))
        {
            if((!empty($sign)) AND (!empty($module)))
            {
                self::$com['result'] = $droit->AddDroit($sign,$module,$titre,$explication);
				self::$com['resulta'] = 'Right added successfully';
            }
            else
            {
                self::$com['resulta'] = 'A field is empty';
            }
        }
    } 
	/**
	 * protected function ViewGroup()
	 *
	 * @return Affiche la liste des groupes
	 * Et renvoie vers la page de modification du groupe
	 */
    protected function ViewGroup()
    {
        $group = new Group();
        self::$com['group'] = $group->ViewGroup();
        if((isset($_POST['modifier'])) AND (isset($_POST['group'])))
        { 
             $this->Redirect(ReelDir()."adn/updategroup/".$_POST['group']);
        }
    }
	/**
	 * protected function UpdateGroup()
	 *
	 * @return Ajoute,modifie les droits d'un groupe donné
	 */
    protected function UpdateGroup()
    {
        $modif_name = htmlspecialchars($_POST['nom_modif_group']);
        $id_name = htmlspecialchars($_GET['id1']);
        $group = new Group();
		//select les droits du groupe donnï¿½ en paramï¿½tre
        self::$com['group_permission'] = $group->ViewGroupPermission('id_group='.$id_name);
		self::$com['group'] = $group->ViewGroup(self::$com['model']->FormGroup($id_name));
		//select tout les droits disponible
        self::$com['droit'] = $group->ViewDroit();
        self::$com['id_name'] = $id_name;
		//Si l'on veut rajouter un droit au groupe
        if(isset($_POST['addroit']))
        {
            $permission = (int)$_POST['add'];
            if(!empty($modif_name))
            {
                $group->UpdateGroup(self::$getRcv['id1'],$permission,'add');
            }
        }
		// si l'on veut supprimer un droit au groupe
        elseif(isset($_POST['deldroit']))
        {
            $permission = (int)$_POST['modif'];
            if(!empty($modif_name))
            {
                $group->UpdateGroup(self::$getRcv['id1'],$permission,'del');
            }
        }
    }
	/**
	 * protected function UpdateMember()
	 *
	 * @return Affiche la liste des utilisateurs 
	 * Et met à jour les informations rentrées en paramètres
	 */
    protected function UpdateMember()
    {
        $group = new Group();
        self::$com['group'] = $group->ViewGroup();
		self::$com['result'] =  self::$com['model']->AdnJoin();	
        if(isset($_POST['update1']))
		{
			if((!empty($_POST['newpass'])) AND ((!empty($_POST['user']))))
			{
			   if($_POST['actived'] == 'zero')
			   {
			      self::$com['model']->UpdateMember("pass='".sha1($_POST['newpass'])."',`user`='".$_POST['user']."',gid='".$_POST['id_name']."' ,hash_validation=''","`adn`.`uid`='".$_POST['uid']."'");
                  $this->SendEmail($_POST['email'],'Adn@tty.com','Votre compte a été activer par un administrateur','Account activation','Moto-trans-express');
			   }
			   else 
			   {
				  self::$com['model']->UpdateMember("pass='".sha1($_POST['newpass'])."',`user`='".$_POST['user']."',gid='".$_POST['id_name']."'","`adn`.`uid`='".$_POST['uid']."'"); 
			   }
               self::$com['result'] = self::$com['model']->AdnJoin();	
			   echo '<div id="updatedialog">Updated successfully</div>';
			}
			elseif((empty($_POST['newpass'])) AND ((!empty($_POST['user']))))
			{
			   if($_POST['actived'] == 'zero')
			   {	
			      self::$com['model']->UpdateMember("`user`='".$_POST['user']."',`gid`='".$_POST['id_name']."' ,hash_validation=''","`adn`.`uid`='".$_POST['uid']."'");
			      $this->SendEmail($_POST['email'],'Adn@tty.com','Votre compte a été activer par un administrateur','Account activation','Moto-trans-express');
			   }
			   else 
			   {
				  self::$com['model']->UpdateMember("`user`='".$_POST['user']."',`gid`='".$_POST['id_name']."'","`adn`.`uid`='".$_POST['uid']."'"); 
			   }
               self::$com['result'] = self::$com['model']->AdnJoin();	
			   echo '<div id="updatedialog">Updated successfully</div>';				
			}
			else 
			{
				echo '<div id="updatedialog">'.$_POST['user'].'</div>';
			}
		} 
		elseif(isset($_POST['update2']))
        {
        	self::$com['model']->UpdateMember("date_naissance='".$_POST['date_naissance']."',email='".($_POST['email'])."', 
        	ville='".addslashes($_POST['ville'])."',code_postal='".$_POST['code_postal']."',pays='".$_POST['pays']."'","'uid='".$_POST['uid']."'");
            self::$com['result'] = self::$com['model']->AdnJoin();	
			echo '<div id="updatedialog">Updated successfully</div>';
        }
		elseif(isset($_POST['update3']))
        {
        	$info = new CommandeModel();
        	$info->UpdateClient($_POST,"'uid='".addslashes($_POST['uid'])."'");
            self::$com['result'] = self::$com['model']->AdnJoin();	
			echo '<div id="updatedialog">Updated successfully</div>';
        }
    }
	/**
	 * protected function AddGroup()
	 *
	 * @return Ajoute un groupe 
	 */
    protected function AddGroup()
    {
        $id_name = htmlspecialchars($_POST['nom_group']);
        $droit = new Group();
        self::$com['result'] = $droit->ViewDroit();
        if(isset($_POST['addgroup']))
        {
            $permission = $_POST['perms'];
            if((!empty($id_name)) AND (!empty($permission)))
            {
               $droit->AddGroup($id_name,$permission);
            }
        }
        
    }
	/**
	 * protected function DelDroit()
	 *
	 * @return Retire un droit à un groupe donné
	 */    
    protected function DelDroit()
    {
        if(isset($_POST['droit']))
        {
            $perm = htmlspecialchars($_POST['droit']);
            $droit = new Group();
            $droit->DelDroit($perm);
        }
    }
	/**
	 * protected function TryConnect()
	 *
	 * @return Verifie le login et mot de passe de l'utilisateur
	 */    
    private function TryConnect()
    {
        if((isset($_POST['connexion'])) && (($_POST['connexion'] == 'Connexion') OR ($_POST['connexion'] == 'Sign in')))
        {
            if((isset($_POST['user'])) && (!empty($_POST['user'])) && (isset($_POST['pass'])) && (!empty($_POST['pass'])))
            {
                //SÃ©curisation des donnÃ©es
                $user = htmlspecialchars($_POST['user']);
                $pass = sha1(htmlspecialchars($_POST['pass']));
                //Appel au model adn
                $this->TryConnectModel($user,$pass);
            }
            else
            {
                $this->NotEmpty();
            }
        }
        return self::$com['co'];
    }
    private function TryConnectModel($user,$pass)
    {
        //Appel du model
		$sqlu = self::$com['model']->TryConnect($user,$pass);
        //si tout correspond
        if($sqlu == 1)
        {
            $con0 = $sqlu->fetch(PDO::FETCH_OBJ); 
            $_SESSION['user'] = $con0 ;
            $_SESSION['username'] = $con0 ->user;
		
            if(($con0->user == $user) AND ($con0 ->pass == $pass))
            {
               $_SESSION['waitvalidemail'] = $con0 ->email;
			   if(empty($con0->hash_validation))
			   {
			      $_SESSION['co'] = true;
			      header("Location: ".ReelDir()."adn/connect");
			   }
			   else 
			   {
			   	  $_SESSION['co'] = false;
				  header("Location: ".ReelDir()."adn/waitvalid");   
			   }
            }
            else
            {
            	$_SESSION['co'] = false;
                self::$com['co'] = 'Password or username incorrect';
            }

        }  
        else
        {
            $_SESSION['co'] = false;
            self::$com['co'] = 'Password or username incorrect'; 
            $this->Error();
        }
        $sqlu->closeCursor();
            
    }
	/**
	 * protected function Validation()
	 *
	 * @return Permet après un click d'activer un compte utilisateur
	 */  
    protected function Validation()
    {
        if(!empty(self::$getRcv['id1']))
        {
           //Appel du model
           $this->sql['result'] = self::$com['model']->Validation(self::$getRcv['id1']);
           if($this->sql['result'] == 1)
           {
               self::$com['req'] = 'Validation completed successfully';
               $this->Redirection(ReelDir().'adn',1000); 
           }
           else
           {
               self::$com['req'] = 'An error occurred while validating';
           }
        }
    }
    private function NotEmpty()
    {
        if((empty($_POST['user'])) OR (empty($_POST['pass'])))
        {
            self::$com['req'] = 'At least one field is empty';
            return true;
        }
    }
	/**
	 * protected function Add()
	 *
	 * @return Ajoute un nouvel utilisateur dans la bdd
	 */
    protected function Add()
    {
        if((isset($_POST['ajouter']) AND ($_POST['ajouter'] == 'Ajouter')))
        { 
            $hash = sha1(uniqid('JvKnrQWPsThuJteNQAuH' . mt_rand(), true));
            $this->mess = '<h3>This message was created automatically by mail delivery software.</h3>';
            if((!empty($_POST['user'])) AND (!empty($_POST['pass'])) AND (!empty($_POST['email'])))
            {
                $helper = new Helper();
                if($helper->Email($_POST['email']))
                {
                    self::$com['model']->Add($_POST,$hash,uniqid(null,true));
                    $mess = $helper->MailTextBox('Account activation',$this->mess,'Click here to activate your account',LINK.'/adn/validation/'.$hash);
                    $this->SendEmail($_POST['email'],'Adn@tty.com',$mess,'Account activation','Adn');
                    self::$com['req'] = 'User add success'; 
					$this->Redirection(ReelDir().'adn',3000); 
                }    
                else
                { 
                    self::$com['req'] = 'The email format is invalid';
                    $this->Error();
                }
            }
            else
            {
                $this->Error();
            }
            $resulta->closeCursor();
            
        }
        return self::$com['helper'];
    }
    protected function Inscription()
    {
        if($_SESSION['lang'] == 'fr') 
        {
            self::$com['fr_ins'] = true;
        }
        elseif($_SESSION['lang'] == 'nl')
        {
        	self::$com['nl_ins'] = true;
        }
        return self::$com['helper'];
    }
	/**
	 * protected function InsertSend()
	 *
	 * @return Ajoute un nouvel utilisateur dans la bdd
	 */	
    public function InsertSend()
	{
		if(isset($_POST['ajouter']))
        { 
            $hash = sha1(uniqid('JvKnrQWPsThuJteNQAuH' . mt_rand(), true));
            $this->mess = '<h3>This message was created automatically by mail delivery software.</h3>';
            if((!empty($_POST['username'])) AND (!empty($_POST['password'])) AND (!empty($_POST['email'])) AND (!empty($_POST['addr_facturation'])))
            {
                $helper = new Helper();
                if($helper->Email($_POST['email']))
                {
                    self::$com['model']->Inscription($_POST,$hash,uniqid(null,true),91);
                    $mess = $helper->MailTextBox('Account activation',$this->mess,'Click here to activate your account',LINK.'/adn/validation/'.$hash);
                    $this->SendEmail($_POST['email'],'Adn@tty.com',$mess,'Account activation','Moto-trans-express::Adn');
                    self::$com['req'] = 'User added successfully<br>A mail was sent in your inbox '; 
                    $this->Redirection(ReelDir().'adn',3000);
                }    
                else
                { 
                    self::$com['req'] = 'The email format is invalid';
                }
            }
            else
            {
               self::$com['req'] = 'Required fields (*)';
            }            
        }
	}
	/**
	 * protected function Disconnect()
	 *
	 * @return Detruit la session en cours et renvoie vers la page donnée
	 */
    protected function Disconnect()
    {
        $_SESSION['co'] = false;
        $this->DestroyAll();
		$var = $_SESSION['lang'];
        $this->Redirection(ReelDir().'intro',4);
    }
	/**
	 * protected function BugReport()
	 *
	 * @return Envoie un email au devollopeur
	 */	
	protected function BugReport()
	{
		$lien = htmlentities($_POST['lien']);
        $email = htmlentities($_POST['email']);
		$message = htmlentities(utf8_decode($_POST['message']));
		
		$mess = '<p>Lien du bug : '.$lien.'</p>';
		$mess .= '<p>Email : '.$email.'</p>';
		$mess .= '<p>Message : '.$message.'</p>';
		
		$helper = new Helper();
		if(false !== filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			if(empty($_POST['envois']))
			{
		        if($this->SendEmail('tcyteam@gmail.com','No-reply@tty.com',$mess,$lien,'BugReport Moto-trans-express'))
		        {
				   $helper->TextBox("Message","Your bug has been reported");
				   $this->Redirection(ReelDir().'acceuil',12);
		        }
		        else
		        {
				   $helper->TextBox("Message","can not send the message<br> Retry later");
		        }
			}
		}
        else
	    {
	    	if(isset($_POST['envoyer']))
			{
			   $helper->TextBox("Message","Verify e-mail format");
			}
	    }		
	}
	private function Parametres()
	{
		
	}
	/**
	 * protected function ViewMember()
	 *
	 * @return Affiche et permet de modifier les informations de l'utilisateur courant
	 */
    protected function ViewMember()
    {
        $info = new CommandeModel();
        self::$com['commande'] = $info->ViewClient($_SESSION['user']->uid);
        self::$com['result'] = self::$com['model']->Modifiermember($_SESSION['user']->user); 
		
        if(isset($_POST['update1']))
		{
			if(sha1($_POST['oldpass']) == $_SESSION['user']->pass)
			{
			   self::$com['model']->UpdateMember("pass='".sha1($_POST['newpass'])."'","uid='".$_SESSION['user']->uid."'");
			   $info = new CommandeModel();
               self::$com['commande'] = $info->ViewClient($_SESSION['user']->uid);
               self::$com['result'] = self::$com['model']->Modifiermember($_SESSION['user']->user);
			   echo '<div id="updatedialog">Updated successfully</div>';
			}
		} 
		elseif(isset($_POST['update2']))
        {
        	self::$com['model']->UpdateMember("date_naissance='".$_POST['date_naissance']."',email='".$_POST['email']."', 
        	ville='".$_POST['ville']."',code_postal='".$_POST['code_postal']."',pays='".$_POST['pays']."'","uid='".$_SESSION['user']->uid."'");
			$info = new CommandeModel();
            self::$com['commande'] = $info->ViewClient($_SESSION['user']->uid);
            self::$com['result'] = self::$com['model']->Modifiermember($_SESSION['user']->user);
			echo '<div id="updatedialog">Updated successfully</div>';
        }
		elseif(isset($_POST['update3']))
        {
        	$info->UpdateClient($_POST,$_SESSION['user']->uid);
        	self::$com['commande'] = $info->ViewClient($_SESSION['user']->uid);
            self::$com['result'] = self::$com['model']->Modifiermember($_SESSION['user']->user);
			echo '<div id="updatedialog">Updated successfully</div>';
        }
        elseif(isset($_POST['update4']))
        {
        	if(!empty($_POST['debug_mode']))
			{
        	    $_SESSION['sqltest'] = $_POST['debug_mode'];
			}
            else
			{
				if(empty($_SESSION['sqltest']))
				{
					$_SESSION['sqltest'] = "false";
				}
			}
        }
		
    }
	/**
	 * protected function ViewDroit()
	 *
	 * @return Permet de voir la liste de droits d'un groupe
	 */    
    protected function ViewDroit()
    {
        $droit = new Group();
        self::$com['droit'] = $droit->ViewDroit(); 
        return self::$com['droit']; 
    }
    protected function Del()
    {
    }
    protected function WaitValid()
    {
    	$_SESSION['lang'] = 'fr';
        if(isset($_POST['resend']))
        {
            $helper = new Helper();
            $result = self::$com['model']->WaitValidView($_SESSION['waitvalidemail']);
            if(!empty($result))
            {
                $res = $result->fetch(PDO::FETCH_OBJ);
                $hash = $res->hash_validation;
                $email = $res->email;
                $messa = '<h3>This message was created automatically by mail delivery software.</h3>';
                $mess = $helper->MailTextBox('Account activation',$messa,'Click here to activate your account',LINK.'/adn/validation/'.$hash);
                $this->SendEmail($email,'Tcyteam',$mess,'Account activation',TITRE);
                $_SESSION['waitvalidemail'] = '';
                $this->Redirection(ReelDir().'adn',5000);
            }
            $result->closeCursor();
        }
    }
	/**
	 * protected function Connect()
	 *
	 * @return Page securisée pour les utilisateurs inscrits
	 */	
    protected function Connect()
    {
        $user = $_SESSION['user']->user;
        $pass = $_SESSION['user']->pass;
		
        $info = new CommandeModel();
        self::$com['commande'] = $info->ViewClient($_SESSION['user']->uid);
        $sql = self::$com['model']->TryConnect($user,$pass);
        //si tout correspond
        if($sql== 1)
        {
            $con1  = $sql->fetch(PDO::FETCH_OBJ); 
            if(!empty($con1->hash_validation))
            {
                 $_SESSION['co'] = false;
                 header("Location: ".ReelDir()."adn/waitvalid");
            }
            else 
            {
            	 $_SESSION['sqltest'] = 'false';
	             $_SESSION['co'] = true;
            }
        } 
        $sql->closeCursor(); 
    }
	/**
	 * protected function NewPassword()
	 *
	 * @return Modifie le mot de passe courant après avoir entré l'ancien mot de passe
	 */
    protected function NewPassword()
    {
        if(isset($_POST['update']))
        {
            if((!empty($_POST['newpass'])) AND (!empty($_POST['conpass'])))
            {
                if($_POST['newpass'] == $_POST['conpass'])
                {
                    if(self::$com['model']->HashNewPassword(strtolower(self::$getRcv['id1']),htmlentities($_GET['id2']),$_POST['newpass']))
                    {
                        self::$com['req'] = 'The password has been renewed';
                        header("Location: ".ReelDir()."adn");
                    }
                    else 
                    {
                    	self::$com['req'] = 'Problem occured in server side';
                    }
                }
                else
                {
                    self::$com['req'] = 'Passwords are not the same';
                }
            }
        }
    }
    protected function Test()
    {

    }
	protected function AllTest()
	{
         if(!empty($_GET['q'])) 
         {
         	$var = self::$com['model']->AllTest(htmlentities($_POST['q']));
            $data = $var->fetch(PDO::FETCH_OBJ); 
            self::$com['model'] = json_encode($data);
			$var->closeCursor();
         }
	}
    protected function ModuleInstaller()
    {

    }
    protected function Profil()
    {
        
    }
    protected function LoginReturn()
    {
    	if((isset($_POST['passrecup'])) AND ($_POST['passrecup'] == 'Recuperer'))
    	{
    		if(!empty($_POST['lostpass']))
    		{
    			if(filter_var($_POST['lostpass'], FILTER_VALIDATE_EMAIL))
    			{
    				$this->sql['result'] = self::$com['model']->LostPassCompare($_POST['lostpass']);
                    $result = $this->sql['result']->fetch(PDO::FETCH_OBJ);
                    $helper = new Helper();
                    $bouton = 'www.moto-trans-express.be';
                    $mess = $helper->MailTextBox('Votre login','Login : '.$result->user.'<br> Sachez que le serveur respecte la casse',$bouton,DOMAINE.'adn');
                    $this->SendEmail($result->email,'Adn',$mess,'Votre login',TITRE);
                    self::$com['req'] = 'An email was sent to your inbox';
                    $this->Redirection(ReelDir().'adn',2500);
    			}
    		}
    	}
    }	
	/**
	 * protected function LostPass()
	 *
	 * @return Envoie un lient par email qui permet de renouveler son mot de passe lorsqu'on a perdu celui-ci
	 */	
    protected function LostPass()
    {
        if((isset($_POST['passrecup'])) AND ($_POST['passrecup'] == 'Recuperer'))
        {
            if(!empty($_POST['lostpass']))
            {
                if(filter_var($_POST['lostpass'], FILTER_VALIDATE_EMAIL))
                {
                    $this->sql['result'] = self::$com['model']->LostPassCompare($_POST['lostpass']);
                    $result = $this->sql['result']->fetch(PDO::FETCH_OBJ);
                    $hash = md5(uniqid(rand(), true));
                    $_SESSION['hash_new'] = $hash;
                    $message = 'Please click on the link to enter a new password';
                    if(!empty($result->email))
                    {
                        $_SESSION['waitvalidemail'] = $result->email ;
                        if(self::$com['model']->LostPassInsert($hash,$result->email,$result->email))
                        {
                            $helper = new Helper();
                            $bouton = 'Add new password';
                            $mess = $helper->MailTextBox('Lost password',$message,$bouton,DOMAINE.'adn/newpassword/'.$hash.'/'.$result->user);
                            $this->SendEmail($result->email,'Adn',$mess,'Lost password',TITRE);
                            self::$com['req'] = 'An email was sent to your inbox';
                            $this->Redirection(ReelDir().'adn',5000);
                        }
                        else
                        {
                            self::$com['req'] = 'a problem occurred';
                        }
                        
                    }
                    else
                    {
                        self::$com['req'] = 'Enter a correct email';
                    }   
                       
                }
                else
                {
                    self::$com['req'] = 'Incorrect email format';
                }
            }
            else
            {
                self::$com['req'] = 'The email field is required';
            }
            
        }
    }
}
?>