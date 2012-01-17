<?php
class ContactModel extends AppModel
{
    public function ContactModel()
    {
        
    }
    public function ViewMember($uid='')
    {
        if(!empty($uid))
        {
            $query = "uid=".$uid;
        }
        else
        {
            $query = '';
        }
        $result = AppModel::Read('*',$query,'adn');
        return $result;
    }
    public function ViewContact($uid)
    {
        $query = "uid=".$uid;
        $result = AppModel::Read('*',$query,'contact');
        return $result;
    }
}
?>