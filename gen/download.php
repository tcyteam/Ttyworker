<?php
$name = $_GET['id1'].'.pdf';
if(file_exists($name))
{
   header("Content-type: application/pdf");
   header("Content-Disposition: attachment; filename=$name");
   readfile("$name"); 
   header("Location: $name.pdf");
}
else 
{
   echo 'Aucun fichier de ce nom';	
}
?>