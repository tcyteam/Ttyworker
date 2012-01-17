<?php
class Cache
{
    protected $fichier;
	protected $url;
	
	public function Cache()
	{
		$this->Render();		
	}
    /**
    * @access  protected
    * @return Capte le lien envoyer par le navigateur et le renome en md5 puis le garde dans une variable
    * protected function Controller()
    */ 
    protected function Controller()
    {
        $this->url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 	
        $this->fichier = md5($this->url).'.cache';
       					
        return $this->fichier;
    }
    /**
    * @access  protected
    * @return verifie que le fichier n'a pas depasser 1 heure sinon il redefinie un nouvel appel
    * protected function Render()
    */     
    protected function Render()
    {       
        $cache = 'cache/'.$this->Controller();
        $fichier_cache_existe = ( @file_exists($cache) ) ? @filemtime($cache) : 0;       
        $expire = time() -3600 ; // valable une heure
        if($fichier_cache_existe > time() - $expire) 
        {
           @readfile($cache);
           exit();
        }
        else
        {
           ob_start();
           //Init core
           $controller = new FrontController();
           $page = ob_get_contents();
           ob_end_clean();
           #file_put_contents($cache, $page);
           echo $page;
        }    	
	
     }    
}
?>