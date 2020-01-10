<?php
require_once("Autoloader.php");
if(isset($_POST['id']) && isset($_POST['date'])) {
    $FoodRepository = new FoodRepository();
    $date = date_create($_POST['date']);
    $date = date_format($date, "Y-m-d");
    $date .= '%';
    $id = $_POST['id'];
    $time = $FoodRepository->GetFoodTimeByDate($date, $id);
    $cleanTime = json_encode($time);
    print $cleanTime;
}
?>