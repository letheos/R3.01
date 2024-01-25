<?php
/**
 * @author Massy Benjamin
 * Controller de la déconnexion
 */
session_start();
session_destroy();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();


header("Location: ../View/PageConnexion.php");
exit();
?>
