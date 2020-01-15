<?php
require_once("Autoloader.php");
if(isset($_POST['id']) && isset($_POST['date'])) {
    $FoodRepository = new FoodRepository();
    // new date is created and formatted based on the 'date' $_POST, given by javascript AJAX call to this file
    $date = date_create($_POST['date']);
    $date = date_format($date, "Y-m-d");
    $date .= '%';
    $id = $_POST['id'];
    $time = $FoodRepository->GetFoodTimeByDate($date, $id);
    // array is encoded so it can be returnted to js method
    $cleanTime = json_encode($time);
    print $cleanTime;
}
?>