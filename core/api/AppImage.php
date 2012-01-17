<?php 
/**
 * AppImage : simple connexion controller
 * 
 * @author Yannick Martins
 * @license Creative Commons By
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 */
class AppImage extends AppController
{
   public function AppImage()
   {
   
   
   }
   //Cette fonction permet d'uploader les formats d'images png, gif, jpg, jpeg
   // Puis les transfère dans le dossier dir1
   public function AjouterImage($name,$dir="index")
   {
       $dir1 = 'application/public/pics_id/'.$dir.'/';
       $dossier = $dir1;
       $fichier = basename($_FILES['image']['name']);
       // on vérifie maintenant l'extension
       $extensions = array('.png', '.gif', '.jpg', '.jpeg');
       // récupère la partie de la chaine à partir du dernier . pour connaître l'extension.
       $extension = strrchr($_FILES['image']['name'], '.');
       //Ensuite on teste
       if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
       {
         $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
       } 
       elseif(move_uploaded_file($_FILES['image']['tmp_name'], $dossier.$name.$extension )) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
       {
         echo 'Upload effectué avec succès !';
       }
       else //Sinon (la fonction renvoie FALSE).
       {
         echo 'Echec de l\'upload !';
       }
     }	 
     //cette fonction permet d'afficher les images se trouvant dans le dossier file ci-dessous 
     public function AfficherMinImage($id,$x,$y,$dir)
     {
       if(!empty($id))
       { 
	     AppImage::redimage('application/public/pics_id/'.$dir.'/'.htmlentities($id),$x,$y,$dir);
	     AppController::$tab['image'] = '<img src="'.AppImage::DirName().$dir.'/'.htmlentities($id).'">';
       }
       else
       {
         AppController::$tab['image'] = 'L\'image n\'a pu être chargée, verifier votre id';
       } 
	   return AppController::$tab['image'];
     }
    /*
    Permet de redimensionner une image
   */    
	 public function redimage($file,$x,$y,$red) 
	 { 
       $size = getimagesize($file);
       if ($size) 
	   {
         if ($size['mime']=='image/jpeg') 
		 {
            $img_big = imagecreatefromjpeg($file); # On ouvre l'image d'origine
            $img_new = imagecreate($x, $y);
            # création de la miniature
            $img_mini = imagecreatetruecolor($x, $y)
            or   $img_mini = imagecreate($x, $y);
            // copie de l'image, avec le redimensionnement.
            imagecopyresized($img_mini,$img_big,0,0,0,0,$x,$y,$size[0],$size[1]);
            imagejpeg($img_mini,$file );
         }
         elseif ($size['mime']=='image/png') 
		 {
            $img_big = imagecreatefrompng($file); # On ouvre l'image d'origine
            $img_new = imagecreate($x, $y);
            # création de la miniature
            $img_mini = imagecreatetruecolor($x, $y)
            or   $img_mini = imagecreate($x, $y);
            // copie de l'image, avec le redimensionnement.
            imagecopyresized($img_mini,$img_big,0,0,0,0,$x,$y,$size[0],$size[1]);
            imagepng($img_mini,$file );
        }
        elseif ($size['mime']=='image/gif') 
		{
            $img_big = imagecreatefromgif($file); # On ouvre l'image d'origine
            $img_new = imagecreate($x, $y);
            # création de la miniature
            $img_mini = imagecreatetruecolor($x, $y)
            or   $img_mini = imagecreate($x, $y);
            // copie de l'image, avec le redimensionnement.
            imagecopyresized($img_mini,$img_big,0,0,0,0,$x,$y,$size[0],$size[1]);
            imagegif($img_mini,$file );
         }
      }
     }	  
   protected function DirName()
   {	 
       if(isset($_GET['do']))
	   {
         $var = '../../';
	   }
	   elseif(isset($_GET['action']))
	   {
		 $var = '../';
	   }
	   else
	   {
	     $var = '';
	   }
	   return $var;
     }
}
?>