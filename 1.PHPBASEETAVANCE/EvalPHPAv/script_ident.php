<?php
session_start();
include('connexion_bdd.php');
$db = connexionBase(); // Appel de la fonction de connexion
var_dump($_GET);
if (isset($_GET['valider'])) {
   $uti_ident = $_GET['uti_ident'];
   $uti_mdp = MD5($_GET["uti_mdp"]);
   if (!empty($uti_ident) & !empty($uti_mdp)) {
      if ($uti_ident == "jarditou" and $uti_mdp = "jARDiT0u") {
         header("location: ../listeA.php");
         exit;
      } else {
         $ident = "SELECT * FROM utilisateur WHERE uti_ident=\"$uti_ident\"";
         var_dump($ident);
         $result = $db->query($ident);
         $client = $result->fetch();
         var_dump($client);
         $uti_ident_db = $client["uti_ident"];
         $uti_mdp_db = $client["uti_mdp"];
         if ($uti_ident_db == $uti_ident) {
            if ($uti_mdp_db == $uti_mdp) {
               $_SESSION["identification"] = "$uti_ident";
               header('Location:listeC.php');
               exit;
            } else {
               $_SESSION["msg"] = "Mot de passe invalide!";
               header('Location: form_ident.php');
            }
         } else {
            //message erreur mot de passe :
            $_SESSION["msg"] = "Identifiant invalide !";
            header('Location:form_ident.php');
         };
      };
   };
};
