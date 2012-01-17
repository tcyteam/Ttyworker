<?php
class MessagerieController extends AppController
{
    public function MessagerieController()
    {
        self::$editor = true;
    }
    protected function Index()
    {
        self::$com['mess_view_all'] = $this->ViewAllMessage();
        return self::$com['mess_view_all'];
    }
    public function Get($action)
    {
        $this->$action();
    }
    protected function AddMessage()
    {
        if((isset($_POST['add'])) AND ($_POST['add'] == 'Envoyer'))
        {
            if((isset($_POST['destinataire'])) AND (!empty($_POST['destinataire']))) 
            {
                 if((isset($_POST['editor1'])) AND (!empty($_POST['editor1'])))
                 {
                     self::$com['model']->AddMessage($_POST);
                 } 
            }
        }
        self::$com['ami'] = self::$com['model']->ViewMyMember();
        self::$com['contact'] = self::$com['model']->ViewContact($_SESSION['user']->uid);
        self::$editorOpt = 'minimal';
        self::$com['editor'] = $this->Editor('editor1');
        return self::$com['editor'];
    }
	protected function ViewMessage()
	{
		if(!empty(self::$getRcv['id1']))
		{
		    self::$com['mess_view_one'] = self::$com['model']->ViewMessage($_SESSION['user']->user,self::$getRcv['id1']);
            return self::$com['mess_view_one'];
		}
	}
    protected function MessageEnvoyer()
    {
        
    }
    protected function ViewAllMessage()
    {
        $result = self::$com['model']->ViewMessage($_SESSION['user']->user);
        return $result;
    }
    private function ViewMember()
    {
        self::$com['result'] = self::$com['model']->ViewMember($_SESSION['user']->user); 
        return self::$com['result'];
    }
        
        
}
?>