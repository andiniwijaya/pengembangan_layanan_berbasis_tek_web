<?php

function redirect($url){
    header("Location: $url");
    exit;
}

function auth(){
    if(!isset($_SESSION['user'])){
        redirect("/?url=auth/login");
    }
}