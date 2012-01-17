<?php
class ContactController extends AppController
{
    public function ContactController()
    {
        
    }
    public function Index()
    {
        self::$com['ami'] = self::$com['model']->ViewMember();
        self::$com['contact'] = self::$com['model']->Viewcontact($_SESSION['user']->uid);
    }
    /*
      Dependance module messagerie
    */
    protected function AddMessage()
    {
        self::$com['view'] = Tty::ModuleDepend('messagerie');
        $messagerie = new MessagerieController();
        $messagerie->Get('addmessage');
    }   
    public function AddContact()
    {
        
    }
    public function ViewContact()
    {
        
    }
    public function ViewMember()
    {
        
    }
    public function ViewContactList()
    {
        
    }
    public function DeleteContact()
    {
        
    }
    public function DeleteContactList()
    {
        
    }
}
?>