<?php
//inclusion du fichier de configuration de l'application
//Controller principal de l'api
require_once('core/config/infos.php');
require_once('application/config/appConf.php');

/**
* class FrontController
* @copyright TtyWorker 2011 by Martins Yannick
* @licence http://creativecommons.org/licenses/by-nd/3.0/deed.fr
* @version  1.0
*/
class FrontController extends AppController
{
    public function FrontController()
    {
        $this->Init();
    }
}
//Implemente l'objet FrontController
$cache = new Cache();
?>