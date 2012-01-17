<?php
class Table extends Helper
{    
    
    public function Table($id='tab')
    { 
        $this->setId['table'] = $id;
        $this->lineCols = NULL;
    }
    public function Render($name)
    {
        $this->Tab();
        if(!empty($this->table))
        {
           foreach($this->table as $cle => $valeur)
           {
              $this->Msg($this->table[$cle]);
           }
        }
    }
    public function Close()
    {
        $this->Msg('</table>');
    }
}
class Line extends Helper
{
    protected $txt = array();
    protected $ar;
    protected $ari;
        
    public function Line()
    {
        $this->setText['line'] = $this->Alea(4);
    }
    public function Render($name)
    {
        $this->LineCols();
        if(!empty($this->lineCols))
        {
           foreach($this->lineCols as $cle => $valeur)
           {
              $this->Msg($this->lineCols[$cle]);
           }
        }
        $this->Close();
    }
    public function AddCols($value)
    {
        $this->ar = $this->Alea(4); 
        $this->setText['cols'] = $value;
        $this->txt[$this->setText['cols'].$this->ar];
        $this->lineCols[$this->txt[$this->setText['cols'].$this->ar]] = $this->lineCols[$this->txt[$this->setText['cols'].$this->ar]] .'<td>'.$this->setText['cols'].'</td>';
    }
    public function AddTitle($value)
    {
        $this->ari = $this->Alea(4); 
        $this->setText['cols'] = $value;
        $this->txt[$this->setText['cols'].$this->ari];
        $this->lineCols[$this->txt[$this->setText['cols'].$this->ari]] = $this->lineCols[$this->txt[$this->setText['cols'].$this->ari]] .'<th>'.$this->setText['cols'].'</th>';
    }
    public function AddEditCols($nom,$text='')
    {
        $line = new LineEdit($nom,$text);
        $value = $line->Input();
        $this->ar = $this->Alea(4); 
        $this->setText['cols'] = $value;
        $this->txt[$this->setText['cols'].$this->ar];
        $this->lineCols[$this->txt[$this->setText['cols'].$this->ar]] = $this->lineCols[$this->txt[$this->setText['cols'].$this->ar]] .'<td>'.$this->setText['cols'].'</td>';
    }
    public function AddEditTitle($nom,$text='')
    {
        $line = new LineEdit($nom,$text);
        $value = $line->Input();
        $this->ar = $this->Alea(4); 
        $this->setText['cols'] = $value;
        $this->txt[$this->setText['cols'].$this->ari];
        $this->lineCols[$this->txt[$this->setText['cols'].$this->ari]] = $this->lineCols[$this->txt[$this->setText['cols'].$this->ari]] .'<th>'.$this->setText['cols'].'</th>';
    }    
    public function LineCols()
    {
        $this->Msg('<tr>');
    }
    public function Close()
    {
        $this->Msg('</tr>');
    }
   
}
class Link extends Helper
{
    protected $op;
    protected $clo;
    protected $par;
    public function Link($text,$name='',$par='',$id='info')
    {
        $this->setName['link'] = $name;
        $this->setText['link'] = $text;
        $this->setId['link'] = $id;
        $this->par = $par;
        if($this->par == 'li')
        {
           $this->op = '<li>';
           $this->clo = '</li>'; 
        }
        elseif($this->par == 'ul')
        {
           $this->op = '<ul>';
           $this->clo = '</ul>'; 
        }
        
    }
    public function SetName($name)
    {
        $this->setName['link'] = $name;
    }
    public function SetText($text)
    {
        $this->setText['link'] = $text;
    }
    public function SetId($text)
    {
        $this->setId['link'] = $text;
    }
    public function SetMode($text)
    {
        $this->setMode['link'] = $text;
        if($this->par == 'li')
        {
           $this->op = '<li id="'.$this->setMode['link'].'">';
           $this->clo = '</li>'; 
        }
        elseif($this->par == 'ul')
        {
           $this->op = '<ul id="'.$this->setMode['link'].'">';
           $this->clo = '</ul>'; 
        }
    }
    public function Render($name)
    {
        $this->Lin($this->op,$this->clo);
        if(!empty($this->linke))
        {
           foreach($this->linke as $cle => $valeur)
           {
              $this->Msg($this->linke[$cle]);
           } 
        }
    }
}
class Img extends Helper
{
    protected $class = array();
    protected $op;
    protected $clo;
    
    public function Img($src,$id,$par='')
    {
        $this->setText['img'] = $src;
        $this->setName['img'] = $this->Alea(5);
        $this->setId['img'] = $id;
        $this->class = $this->setId['img'];
        if($par == 'li')
        {
           $this->op = '<li>';
           $this->clo = '</li>'; 
        }
        elseif($par == 'ul')
        {
           $this->op = '<ul>';
           $this->clo = '</ul>'; 
        }
    }
    public function Render($name)
    {
        $this->img[$this->objCourant->setName['img'].$name] = $this->op.'<img src="'.$this->setText['img'].'" id="'.$this->setId['img'].'" class="'.$this->class.'" />'.$this->clo;
        foreach($this->img as $cle => $valeur)
        {
            $this->Msg($this->img[$cle]);
        } 
    } 
}
class ErrorDisplay extends Helper
{
    public function ErrorDisplay($text)
    {
        $this->setText['error'] = $text;
        $this->setName['error'] = $this->Alea(5);
    }
    public function Render()
    {
        $this->error[$this->objCourant->setName['error']] = $this->setText['error'];
        if(!empty($this->setText['error'])){ $br = '<br>';}
        foreach($this->error as $cle => $valeur)
        {
            $this->Msg($br.$this->error[$cle]);
        } 
    }
}
class Radio extends Helper
{
    protected $br;
    public function Radio($name,$id="",$br=false)
    {
        $this->setName['radio'] = $name;
        $this->setId['radio'] = $id;
        if($br)
        {
            $this->br = '<br>';
        }
    }
    public function AddValue($value,$titre)
    {
        $this->ar = $this->Alea(4); 
        $this->setText['radio'] = $value;
        $this->setLabel['text'.$this->ar] = $titre;
        if(!empty($this->setId['radio']))
        {
            $id='id="'.$this->setId['radio'].'"';
        }
        if($_POST[$this->setName['radio']] == $this->setText['radio'])
        {
            $checked = 'checked';
        }
        else
        {
            $checked = '';
        }
        $this->txt[$this->setText['radio'].$this->ar];
        $this->radio[$this->txt[$this->setText['radio'].$this->ar]] = $this->radio[$this->txt[$this->setText['radio'].$this->ar]].ucfirst($this->setLabel['text'.$this->ar]).' <input type="radio" name="'.$this->setName['radio'].'" '.$id.' value="'.$this->setText['radio'].'"'.$checked.'>'.$this->br;
    }
    public function SetName($name)
    {
        $this->setName['radio'] = $name;
    }
    public function SetText($text)
    {
        $this->setText['radio'] = $text;
    }
    public function SetId($id)
    {
        $this->setId['radio'] = $id;
    } 
    public function SetLabel($for)
    {
        $this->setLabel['text'] = $for;   
    } 
    public function ReadOnly($v)
    {
        $this->readOnly['radio'] = $v;
    }
    public function Disabled($v)
    {
        $this->disabled['radio'] = $v;
    }
    public function Render(&$b)
    {
        if(!empty($this->radio))
        {
           foreach($this->radio as $cle => $valeur)
           {
              $this->Msg($this->radio[$cle]);
           }
        }
    }
}
class CheckBox extends Helper
{
    protected $br;
    public function CheckBox($name,$id="",$br=false)
    {
        $this->setName['checkbox'] = $name;
        $this->setId['checkbox'] = $id;
        if($br)
        {
            $this->br = '<br>';
        }
    }
    public function AddValue($value,$titre)
    {
        $this->ar = $this->Alea(4); 
        $this->setText['checkbox'] = $value;
        $this->setLabel['text'.$this->ar] = $titre;
        if(!empty($this->setId['checkbox']))
        {
            $id='id="'.$this->setId['checkbox'].'"';
        }
        if(isset($_POST[$this->setName['checkbox']]))
        {
            $checked = 'checked';
        }
        else
        {
            $checked = '';
        }       
        $this->txt[$this->setText['checkbox'].$this->ar];
        $this->checkbox[$this->txt[$this->setText['checkbox'].$this->ar]] = $this->checkbox[$this->txt[$this->setText['radio'].$this->ar]].ucfirst($this->setLabel['text'.$this->ar]).' <input type="checkbox" name="'.$this->setName['checkbox'].'" '.$id.' value="'.$this->setText['checkbox'].'"'.$checked.'>'.$this->br;
    }
    public function SetName($name)
    {
        $this->setName['checkbox'] = $name;
    }
    public function SetText($text)
    {
        $this->setText['checkbox'] = $text;
    }
    public function SetId($id)
    {
        $this->setId['checkbox'] = $id;
    } 
    public function SetLabel($for)
    {
        $this->setLabel['checkbox'] = $for;   
    } 
    public function ReadOnly($v)
    {
        $this->readOnly['checkbox'] = $v;
    }
    public function Disabled($v)
    {
        $this->disabled['checkbox'] = $v;
    }
    public function Render(&$b)
    {
        if(!empty($this->checkbox))
        {
           foreach($this->checkbox as $cle => $valeur)
           {
              $this->Msg($this->checkbox[$cle]);
           }
        }
    }
}
class Select extends Helper
{
    protected $txt = array();
    protected $ar;
    protected $ari;
    protected $selected;
    protected $multiple;
    
    public function Select($titre,$multiple)
    {
        $this->setName['select'] = $titre;
        $this->setMode['select'] = $multiple;
    }
    public function AddOption($value,$titre,$selected='selected')
    {
        $this->ar = $this->Alea(4); 
        $this->setText['option'] = $value;
        $this->setName['option'] = $titre;
        $this->txt[$this->setText['option'].$this->ar];
        if($_POST[$this->setName['select']] == $this->setText['option'])
        {
            $this->selected = 'selected';
        }
        elseif(!empty($selected))
        {
            $this->selected='selected';
        }
        else
        {
            $this->selected = '';
        }
        if($this->setMode['select']){$this->multiple = 'MULTIPLE';}else{$this->multiple = '';}
        $this->select[$this->txt[$this->setText['option'].$this->ar]] = $this->select[$this->txt[$this->setText['option'].$this->ar]] .'<option value="'.$this->setText['option'].'" '.$this->selected.' '.$this->multiple.' '.$this->readOnly['select'].' '.$this->disabled['select'].'>'.$this->setName['option'].'</option>';
    }
    /**$
    * @access  public
    * @return modifie le texte du label du dernier objet crée
    */  
    public function SetLabel($for)
    {
        $this->setLabel['text'] = $for;   
    } 
    public function ReadOnly($v)
    {
        $this->readOnly['select'] = $v;
    }
    public function Disabled($v)
    {
        $this->disabled['select'] = $v;
    }
    public function Render(&$line='')
    {
        $this->Selection();
        if(!empty($this->select))
        {
           foreach($this->select as $cle => $valeur)
           {
              $this->Msg($this->select[$cle]);
           }
        }
          $this->Close();
    }
    private function Selection()
    {
        $this->Msg('<label for="'.$this->setLabel['select'].'">'.$this->setLabel['text'].'</label><select name="'.$this->setName['select'].'">');
    }
    public function close()
    {
        $this->Msg('</select>');
    }
}       
?>