<?php
require_once("Autoloader.php");
if(isset($_POST['Email'])) {
    $OrderRepository = new OrderRepository();
    
    $OrderCode = $OrderRepository->CheckMail($_POST["Email"]);
    if($OrderCode != ""){
        echo $OrderCode;
    }
    else{
        echo false;
    }
}
?>