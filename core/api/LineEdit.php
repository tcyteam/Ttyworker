<?php
class LineEdit extends Helper
{
    public function LineEdit($setName='lineName',$text='',$id='lineId',$setMode ='text',$readonly='',$disabled='',$required='required=true')
    {
        if(isset($_POST[$setName]))
        {
            $this->setText['lineEdit'] = $_POST[$setName];
            $this->setName['lineEdit'] = $setName;
            $this->setMode['lineEdit'] = $setMode;
            $this->setId['lineEdit'] = $id;   
            $this->readOnly['lineEdit'] = $readonly;
            $this->required['lineEdit'] = $required;
            $this->disabled['lineEdit'] = $disabled;
        }
        else
        {
            $this->setName['lineEdit'] = $setName;
            $this->setMode['lineEdit'] = $setMode;
            $this->setText['lineEdit'] = $text;
            $this->setId['lineEdit'] = $id;
            if(empty($this->setLabel['lineEdit']))
            {
                $this->setLabel['lineEdit'] = $this->setName['lineEdit'];
            }    
            $this->readOnly['lineEdit'] = $readonly;
            $this->required['lineEdit'] = $required;
            $this->disabled['lineEdit'] = $disabled;
        }
    }
    /**
    * @access  public
    * @return modifie le texte du dernier objet crée
    */     
    public function SetText($text)
    {
        $this->setText['lineEdit'] = $text;
    }
    /**
    * @access  public
    * @return modifie le mode du dernier objet crée
    */      
    public function SetMode($mode)
    {
        $this->setMode['lineEdit'] = $mode;   
    }
    /**
    * @access  public
    * @return modifie le nom du dernier objet crée
    */  
    public function SetName($name)
    {
        $this->setName['lineEdit'] = $name;
    }
    public function SetId($id)
    {
        $this->setId['lineEdit'] = $id;
    }   
    public function Required($req)
    {
    	if($req == false)
		{
			$var = '';
		}
		else 
		{
		    $var = 'required="'.$req.'"';
		}
        $this->required['lineEdit'] = $var;
    }
    public function Masq($req)
    {
        $this->masq['lineEdit'] = $req;
    }
    public function DefVal($req)
    {
        $this->defval['lineEdit'] = $req;
    }
    public function AccessKey($key)
    {
        
    }
    /**$
    * @access  public
    * @return modifie le texte du label du dernier objet crée
    */  
    public function SetLabel($for)
    {
        $this->setLabel['text'] = $for;   
    } 
    public function ReadOnly($v='readonly')
    {
        $this->readOnly['lineEdit'] = $v;
    }
    public function Disabled($v='disabled')
    {
        $this->disabled['lineEdit'] = $v;
    }
    public function Render(&$b)
    {
        $this->Input();
        if(!empty($this->lineEdit))
        {
           foreach($this->lineEdit as $cle => $valeur)
           {
              $this->Msg($this->lineEdit[$cle].'<br>');
           }
        }
    }
}
?>