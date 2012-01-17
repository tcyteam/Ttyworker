<?php 
class CommentaireController extends AppController
{
	public function CommentaireController()
	{
		
	}
	public function Index()
	{
        
	}
	protected function AddComment()
	{
		if((isset($_POST['nom'])) AND (isset($_POST['email'])) AND (isset($_POST['comment'])))
		{
			self::$com['model']->AddComment($_POST['nom'],$_POST['email'],$_POST['comment']);
			$this->Redirection('index',0);
		}	
	}		
	public function Widget()
	{
		$nombreDeMessagesParPage = 20; // Essayez de changer ce nombre pour voir :o)
		self::$com['Countcomments'] = self::$com['model']->CountComment();
        // On récupère le nombre total de messages
        $donnees = self::$com['Countcomments']->fetch(PDO::FETCH_OBJ);
        $totalDesMessages = $donnees;
		self::$com['Countcomments']->closeCursor();
        $nombreDePages  = ceil($totalDesMessages / $nombreDeMessagesParPage);
		if((isset(self::$getRcv['id1'])) AND (self::$getRcv['id1'])) 
        {
            $page = self::$getRcv['id1']; // On récupère le numéro de la page indiqué dans l'adresse (livreor.php?page=4)
		}
        else // La variable n'existe pas, c'est la première fois qu'on charge la page
        {
            $page = 1; // On se met sur la page 1 (par défaut)
        }
		$premierMessageAafficher = ($page - 1) * $nombreDeMessagesParPage;
		$reponse = self::$com['model']->Read('*','','commentaire',$premierMessageAafficher,$nombreDeMessagesParPage);
		if(!empty($reponse))
		{
			echo '<h3>Commentaires</h3></br></br>'	;
		    while ($comment = $reponse->fetch(PDO::FETCH_OBJ))
            {
                echo '<div id="comment-name">Le ..... par <strong>' . $comment->nom . '</strong></div><div id="comment-body">' . $comment->comment . '</div>';
            }
		    $reponse->closeCursor();
		}
		echo '<div id="comment-page">Page : ';
        for ($i = 1 ; $i <= $nombreDePages ; $i++)
        {
            echo '<a href="commentaire/wiew/' . $i . '">' . $i . '</a>';
        }
		echo '</div>';
	}		
}	

?>