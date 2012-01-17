<?php
class Form extends Helper
{
    public function Form($name='form',$action='',$id='ids',$enc=false)
    {
        $this->setName['form'] = $name;
        $this->setText['form'] = $action;
        $this->setMode['form'] = $enc;
        $this->setId['form'] = $id;
    }
    public function GetName()
    {
        return $this->setName['form'];
    }
    public function GetAction()
    {
        return $this->setText['form'];
    }
    public function Render(&$b='')
    {
        $this->Formulaire();
        if(!empty($this->form))
        {
           foreach($this->form as $cle => $valeur)
           {
              $this->Msg($this->form[$cle]);
           }
        }
    }
    public function Close($cont='true')
    {
        if(empty($cont))
        {
          $this->Msg('</FORM>');         
        }
    }  
}
?>