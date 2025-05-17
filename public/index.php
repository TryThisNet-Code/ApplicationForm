<?php
    require_once __DIR__ . '/../src/controller/applicationController.php';

    $controller = new ApplicationFormController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $controller->saveApplication();
    }else{
        $controller->showFiveApplicants();
    }
?>