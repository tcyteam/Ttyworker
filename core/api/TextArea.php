<?php
/**
* @abstract class TextArea
* @copyright TtyWorker 2011 by Martins Yannick
* @licence http://creativecommons.org/licenses/by-nd/3.0/deed.fr
* @version  0.0.1
*/
class TextArea extends Helper
{
    /**
    * @method TextArea() 
    * @access  protected
    * @return crée une zone editable
    * @todo gerer l'ensemble des modifications:
    */ 
    public function TextArea($name='area',$id='editor1',$text='',$readonly='',$disabled='')
    {
        
        if(isset($_POST[$name]))
        {
            $this->setText['textArea'] = $_POST[$name];
            $this->setName['textArea'] = $name;
            $this->setId['textArea'] = $id;
            $this->readOnly['textArea'] = $readonly;
            $this->disabled['textArea'] = $disabled;
        }
        else
        {
            $this->setName['textArea'] = $name;
            $this->setText['textArea'] = $text;
            $this->setId['textArea'] = $id;
            $this->readOnly['textArea'] = $readonly;
            $this->disabled['textArea'] = $disabled;
        }
    }
    /**
    * @method SetText() 
    * @access  protected
    * @return modifie le texte entré dans la zone editable
    * @todo gerer l'ensemble des modifications:
    * model, controller,session,bdd,cache,cron
    */ 
    public function SetText($text)
    {
        $this->setText['textArea'] = $text;
    }
    /**$
    * @access  public
    * @return modifie le texte du label du dernier objet crée
    */  
    public function SetLabel($for)
    {
        $this->setLabel['text'] = $for;  
        $this->setLabel['textArea'] = $this->setName['textArea'];
    } 
    public function SetId($id)
    {
        $this->setId['textArea'] = $id;
    }  
    public function ReadOnly()
    {
        $this->readOnly['textArea'] = 'readOnly';
    }
    public function Disabled()
    {
        $this->disabled['textArea'] = 'disabled';
    }
    public function Render($name)
    {
        $this->Area();
        if(!empty($this->textArea))
        {
           foreach($this->textArea as $cle => $valeur)
           {
              $this->Msg($this->textArea[$cle].'<br>');
           }
        }
    }
}
?>