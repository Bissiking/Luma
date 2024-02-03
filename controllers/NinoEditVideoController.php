<?php

class NinoEditVideoController {
    public function show() {
        if(isset($_GET['page']) && $_GET['page'] == "new"){
           require_once './website/nino/edit_v2.php'; 
        }else{
           require_once './website/nino/edit.php'; 
        }
    }
}