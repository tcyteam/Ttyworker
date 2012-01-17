<?php
class IntroController extends AppController
{
    public function IntroController()
	{
		$this->droit['index'] = 'public';
		$this->droit['test'] = 'public';
	}
	public function Index()
	{
        $this->GetNews('*','','article order by date_creation asc limit 0, 5');
	}
	public function Test()
	{
		
	}


}
?>