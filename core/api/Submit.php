<?php
class Submit extends Helper
{
    public function Submit($name='sub',$value='Send',$acces='enter;')
    {
        $this->setName['submit'] = $name;
        $this->setText['submit'] = $value;
        $this->setMode['submit'] = $acces;
    }
    /**
    * @access  public
    * @return modifie le texte du dernier objet crée
    */     
    public function SetText($text)
    {
        $this->setText['submit'] = $text;
    }
	public function SetId($id)
    {
        $this->setId['submit'] = $id;
    }
    public function Disabled($v='disabled')
    {
        $this->disabled['submit'] = $v;
    }
    public function Render(&$b='')
    {
        $this->Sub();
        if(!empty($this->submit))
        {
           foreach($this->submit as $cle => $valeur)
           {
              $this->Msg($this->submit[$cle]);
           }
        }
    }
}
?>