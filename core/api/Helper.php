<?php
/**
* @class Helper
*/ 
class Helper extends Tty
{
    protected $lineEdit = array();
    protected $email;
    protected $date;
    protected $label = array();
    protected $submit = array();
    protected $textArea = array();
    protected $form = array();
    protected $table = array();
    protected $linke = array();
    protected $error = array();
    protected $img = array();
    protected $lineCount;
    protected $obj;
    protected $POST;
    protected $objForm;
    protected $objBox;
    protected $objArea;
    protected $objTable;
    protected $objLine;
    protected $objCols;
    protected $objSelect;
    protected $objRadio;
    protected $objCheck;
    protected $cols;
    protected $col;
    protected $line;
    protected $select;
    protected $radio;
    protected $checkbox;
    protected $alea;
    protected $required = array();
    protected $masq = array();
    protected $defval = array();
    protected $setText = array();
    protected $setMode = array();
    protected $setName = array();
    protected $setId = array();
    protected $setLabel = array();
    protected $readOnly = array();
    protected $disabled = array();
    protected $selected = array();
    protected $objCourant = array();

    public function Helper()
    {

    }
    /**
    * @method Form() 
    * @access  public
    * @return cr�e un formulaire unique
    * @todo gerer les type radio,selection
    */ 
    public function Form($name='formulaire',$action='',$id='ids',$enc=false)
    {  
        if(empty($action))
        {
            $action = $this->ModExists();
        }
        if($enc)
        {
            $crypt = 'ENCTYPE="x-www-form-urlencoded';
        }
        else
        {
            $crypt = '';
        }    
        $this->objCourant = NULL;
        $this->objCourant[$name] = new Form($name,$action,$id,$enc);
        $this->objForm = $this->objCourant[$name];
        return $this->objCourant[$name];
    }
    /**
    * @method Label() 
    * @access  public
    * @return cr�e un text associe � un LineEdit
    */ 
    public function Label($for)
    {
        $this->Label[$this->objCourant->setName['lineEdit']] = '<label for="'.$for.'"></label>';
    }
    /**
    * @method LineEdit($setName='lineName',$text='',$id='lineId',$setMode ='text',$readonly='',$disabled='')
    * @access  public
    * @return cr�e une ligne de texte Editable
    */ 
    public function LineEdit($setName='lineName',$text='',$id='lineId',$setMode ='text',$readonly='',$disabled='')
    {
        $this->objCourant[$setName] = new LineEdit($setName,$text,$id,$setMode,$readonly,$disabled);
        $this->obj = $this->objCourant[$setName];
        return $this->objCourant[$setName];
    }
    /**
    * @method TextArea($setName,$id='',$text='',$readonly='',$disabled='')
    * @access  public
    * @return cr�e une zone de texte editable
    */ 
    public function TextArea($setName,$id='',$text='',$readonly='',$disabled='')
    {
        $this->objCourant[$setName] = new TextArea($setName,$id,$text,$readonly,$disabled);
        $this->obj = $this->objCourant[$setName];
        return $this->objCourant[$setName];
    } 
    /**
    * @method Table($id='tab') 
    * @access  public
    * @return cr�e une tableau unique
    */ 
    public function Table($id='tab')
    {
        $this->objCourant[$id] = new Table($id);
        $this->objTable = $this->objCourant[$id];
        return $this->objCourant[$id];
    }
    /**
    * @method Select($name) 
    * @access  public
    * @return cr�e une nouvelle liste
    */ 
    public function Select($name,$mutiple=false)
    {
        $select =  new Select($name,$multiple);
        $this->objCourant[$name] = $select;
        $this->objSelect = $select;
        $this->objSelect->setText['select'];
        return $this->objCourant[$name];
    }
    /**
    * @method Radio($name,$value,$id="") 
    * @access  public
    * @return cr�e un bouton radio
    */ 
    public function Radio($name,$id="",$br=false)
    {
        $radio =  new Radio($name,$id,$br);
        $this->objCourant[$name] = $radio;
        $this->obj = $this->objCourant[$name];
        return $this->objCourant[$name];
    }
    /**
    * @method CheckBox($name,$value,$id="") 
    * @access  public
    * @return cr�e une checkbox
    */ 
    public function CheckBox($name,$id="",$br=false)
    {
        $checkbox=  new CheckBox($name,$id,$br);
        $this->objCourant[$name] = $checkbox;
        $this->obj = $this->objCourant[$name];
        return $this->objCourant[$name];
    }
    /**
    * @method Submit($name='sub',$value='Send') 
    * @access  public
    * @return cr�e un pushButton
    */ 
    public function Submit($name='sub',$value='Send',$acces='enter')
    {
        $this->objCourant[$name] = new Submit($name,$value,$acces);
        $this->obj = $this->objCourant[$name];
        return $this->objCourant[$name];
    }
    /**
    * @method Link($text,$name) 
    * @access  public
    * @return Ajoute un nouveau lien 
    */ 
    public function Link($text,$name,$par='',$id='info')
    {
        $this->alea = $this->Alea(5);
        $this->objCourant[$this->alea] = new Link($text,$name,$par,$id);
        $this->obj = $this->objCourant[$this->alea];
        return $this->objCourant[$this->alea];
    }
    /**
    * @method ErrorDisplay($text) 
    * @access  public
    * @return Ajoute du texte dans le dom
    */ 
    public function ErrorDisplay($text)
    {
        $this->alea = $this->Alea(5);
        $this->objCourant[$this->alea] = new ErrorDisplay($text);
        $this->obj = $this->objCourant[$this->alea];
        return $this->objCourant[$this->alea]; 
    }
    public function MailTextBox($titre,$message,$bouton='',$lien='#')
    {
       $mess = '<table cellspacing="0" cellpadding="10" border="0" height="250"style="border:1px solid #36393D;">';
       $mess = $mess.'<tr><th width="600" style="background-color:#c54b40;color:white;';
       $mess = $mess.'border-bottom:1px solid #c54b40;height:12%;font-size:20px;text-align:left;">'.$titre.'</th></tr>';
       $mess = $mess.'<tr><td width="600" height="250" style="height:78%;"><p style="margin:auto;position:absolute;top:10%;">'.$message.'</p>';
       $mess = $mess.'<a href="'.$lien.'" style="margin:auto;width:40%;height:27px;border:1px solid #c54b40;'; 
       $mess = $mess.'background-color:#c54b40;color:white;text-decoration:none;display:block;">';
       $mess = $mess.$bouton.'</a></td></tr>';
       $mess = $mess.'</table>';
       return $mess;
    }
    public function TextBox($titre,$message,$return=false)
    {
        $var = '<div id="textbox">
                <div id="textboxtitre">'.$titre.'</div>'.
                '<div id="textboxmessage">'.$message.'</div></div>';
                if($return)
                {
                    return $var;
                }
                else
                {
                    $this->Msg($var);
                }

    }
    /**
    * @method Img(src,id)
    * @access  public
    * @return Ajoute une image � l'ecran'
    */
    public function Img($src,$id,$par='')
    {
        $this->alea = $this->Alea(5);
        $this->objCourant[$this->alea] = new Img($src,$id,$par);
        $this->obj = $this->objCourant[$this->alea];
        return $this->objCourant[$this->alea];   
    }
    protected function Lin($op,$clo)
    {
        $this->linke[$this->objCourant->setName['link']] = $op.'<a href="'.$this->setText['link'].'" class="'.$this->setId['link'].'">'.$this->setName['link'].'</a>'.$clo;
    }
    //Redeclare toutes les possibilit�s d'un formulaire
    protected function Formulaire()
    {
        $this->form[$this->objCourant->setName['form']] = '<FORM ID="'.$this->setId['form'].'" NAME="'.$this->setName['form'].'" METHOD="POST" ACTION="'.$this->setText['form'].'" '.$this->setMode['form'].'>';
    }
    protected function Sub()
    {
        $this->submit[$this->objCourant->setName['submit']] = '<input name="'.$this->setName['submit'].'" type="submit" value="'.$this->setText['submit'].'" id="'.$this->setId['submit'].'" accesskey="'.$this->setMode['submit'].'" '.$this->disabled['submit'].'>';
    }
    protected function Tab()
    {  
        $this->table[$this->objCourant->setId['table']] = '<table id="'.$this->setId['table'].'">';
    }
    //Redeclare toutes les possibilit�s d'une input
    protected function Input()
    {
        $this->lineEdit[$this->objCourant->setName['lineEdit']] = '<label for="'.$this->setLabel['lineEdit'].'">'.$this->setLabel['text'].'</label><input type="'.$this->setMode['lineEdit'].'" name="'.$this->setName['lineEdit'].'" value="'.$this->setText['lineEdit'].'" id="'.$this->setId['lineEdit'].'" '.$this->required['lineEdit'].' masq="'.$this->masq['lineEdit'].'" defval="'.$this->defval['lineEdit'].'" '.$this->readOnly['lineEdit'].' '.$this->disabled['lineEdit'].'>';
        return $this->lineEdit[$this->objCourant->setName['lineEdit']] ;  
    } 
    protected function Area()
    {
        $this->textArea[$this->objCourant->setName['textArea']] = '<label for="'.$this->setLabel['textArea'].'">'.$this->setLabel['text'].'</label><textarea name="'.$this->setName['textArea'].'" id="'.$this->setId['textArea'].'" '.$this->readOnly['textArea'].' '.$this->disabled['textArea'].'>'.$this->setText['textArea'].'</textarea>';
        return $this->textArea[$this->objCourant->setName['textArea']]; 
    }
    public function SetLabel($for)
    {
        $this->obj->SetLabel(ucfirst($for));
    } 
    public function ReadOnly()
    {
        $this->obj->ReadOnly('readonly');
    }
    /**
    * @method GetAction() 
    * @access  public
    * @return Donne le nom de l'action courante'
    */ 
    public function GetAction()
    {
        return $this->objForm->GetAction();
    }
    public function GetName()
    {
        return $this->objForm->GetName();
    }
    public function Disabled()
    {
        $this->obj->Disabled('disabled');
    }
    public function SetText($text)
    {
        $this->obj->SetText($text);
    }
    public function SetMode($mode)
    {
        $this->obj->SetMode($mode);
    }     
    public function SetName($name)
    {
        $this->obj->SetName($name);
    }
    //Ajoute une ligne � un tableau
    public function Line($text='h')
    {
        $line =  new Line($this->alea);
        $this->alea = $line->setText['line'];
        $this->objCourant[$this->alea] = $line;
        $this->objLine = $line;
        $this->objLine->setText['line'];
        return $this->objCourant[$this->alea];
    }
    public function AddEditCols($setName='lineName',$text='',$id='lineId',$setMode ='text',$readonly='',$disabled='')
    {
        $this->objLine->AddEditCols($setName,$text,$id,$setMode,$readonly,$disabled);
    }       
    public function AddEditTitle($setName='lineName',$text='',$id='lineId',$setMode ='text',$readonly='',$disabled='')
    {
        $this->objLine->AddEditTitle($setName,$text,$id,$setMode,$readonly,$disabled);
    }  
    public function AddCols($value)
    {
        $this->objLine->AddCols($value);
    }
    public function AddValue($value,$titre)
    {
        $this->obj->AddValue($value,$titre);
    }
    public function AddOption($value,$titre,$selected='')
    {
        $this->objSelect->AddOption($value,$titre,$selected);
    }
    public function AddTitle($value)
    {
        $this->objLine->AddTitle($value);
    }    
    public function SetId($id)
    {
        $this->obj->SetId($id);
    } 

    public function Required($var=false)
    {
        $this->obj->Required($var);
    }
    public function Masq($var)
    {
        $this->obj->Masq($var);
    }
    public function DefVal($var)
    {
        $this->obj->DefVal($var);
    }
    /**
    * @access  private
    * @return Verifie si les carat�res entr�s correspend au type num�rique
    */ 
    private function Num($nbr)
    {
        if($this->setMode['lineEdit'] == 'num')
        {
           $ret = $this->Number($nbr);
           return $ret;
        }   
    }
    /**
    * @access  public
    * @return Verifie si les carat�res entr�s correspend au type chaine de caractere
    */ 
    public function Text($text)
    {
        if($this->setMode['lineEdit'] == 'text')
        {
           $ret = $this->Alpha($text);
           return $ret;
        }       
    }
    /**
    * @access  public
    * @return Verifie si les carat�res entr�s correspend au type email
    */ 
    public function Email($mail)
    {
        $atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';   // caract�res autoris�s avant l'arobase
        $domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)'; // caract�res autoris�s apr�s l'arobase (nom de domaine)
                                       
        $regex = '/^' . $atom . '+' .   // Une ou plusieurs fois les caract�res autoris�s avant l'arobase
        '(\.' . $atom . '+)*' .         // Suivis par z�ro point ou plus
                                        // s�par�s par des caract�res autoris�s avant l'arobase
        '@' .                           // Suivis d'un arobase
        '(' . $domain . '{1,63}\.)+' .  // Suivis par 1 � 63 caract�res autoris�s pour le nom de domaine
                                        
        $domain . '{2,63}$/i';          
        
        // test de l'adresse e-mail
        if (preg_match($regex, $mail)) {
            return true;
        } else {
            return false;
        } 
    }
    /**
    * @access  private
    * @return Verifie si les carat�res entr�s correspend au type date
    */ 
    public function Date()
    {
        if((preg_match('/^(\d\d\d\d)-(\d\d?)-(\d\d?)$/', $date)) OR (preg_match('/^(\d\d?)-(\d\d?)-(\d\d\d\d)$/', $date)))
        {
            return true;
        } 
        else
        {
            return false;
        }
    }
    //affiche tout les �l�ments d�clar�
    public function Rend($name='')
    {
        if(!empty($this->objCourant))
        {
          foreach($this->objCourant as $cle => $valeur)
          {
             $this->objCourant[$cle]->Render($name);
          } 
        }
        if(!empty($this->objTable))
        {
            $this->objTable->Close();
        }
        $this->objCourant = NULL;
    }
    //affiche tout les �l�ments d�clar�
    public function Render($name='')
    {
        if(!empty($this->objCourant))
        {
          foreach($this->objCourant as $cle => $valeur)
          {
             $this->objCourant[$cle]->Render($name);
          } 
        }
        if(!empty($this->objTable))
        {
            $this->objTable->Close();
        }
        if(!empty($this->objForm))
        {
            $this->objForm->Close($name);
        }
        $this->objCourant = NULL;
    }
}    
?>