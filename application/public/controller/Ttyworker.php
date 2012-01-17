<?php
class TtyWorkerController extends AppController
{
	public function TtyWorkerController()
	{
		$this->droit['index'] = 'public';
		$this->droit['article'] = 'public';
	}
	public function Index()
	{		
		$this->GetNews('*','','article order by id desc');
	}
	public function Article()
	{
		$this->GetNews('*','','article order by date_creation asc limit 0, 5');
	}
}
?>