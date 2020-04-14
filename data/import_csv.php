<?php
if(isset($_POST["submit"]))
{
$host="localhost"; // nom de l'hôte.
$db_user="root"; // nom de l'utilisateur
$db_password="0000"; // mot de passe de la bdd
$db='prospect'; // nom de la bdd
$con=mysqli_connect($host,$db_user,$db_password,$db);
// verification de la connexion
if (mysqli_connect_errno())
{
  echo "Nous n'avons pas pu vous connecter à MySQL: " . mysqli_connect_error();
}

echo $filename=$_FILES["file"]["name"];
$ext=substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));

//verification que le fichier sois bien au format CSV
if($ext=="csv")
{
  $file = fopen($filename, "r");
         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
         {
            $sql = "INSERT into tableName(name,email,address) values('$emapData[0]','$emapData[1]','$emapData[2]')";
            mysqli_query($con, $sql);
         }
         fclose($file);
         echo "Le fichier CSV a bien été importé.";
}
else {
    echo "Erreur : s'il vous plaît ne chargez que des fichiers au format CSV";
}
}
?>
