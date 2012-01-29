<?php
Interface News
{
	public function News();
	public function ReadNews();
	public function AddNews($titre='',$auteur='',$area='',$table='',$imgLink='',$vidLink='');
	public function UpdatNews($titre='',$auteur='',$area='',$table='',$imgLink='',$vidLink='');
	public function ViewNewsList();
	public function NewsAdd();
	public function GetNews($attr='*',$close='',$table='');
	public function NewsUpdate();
	public function DelNews($close,$table='');
	public function SetNews($attr='',$close='',$table='');
	public function Verification($titre,$texte,$niv=false,$auteur,$imglien,$vidlien);
}
?>