<?php

$usernameregex = "/^[a-zA-Z\d]+$/";
$passwordregex = "/^[a-zA-Z0-9]+.{9}/";
$emailregex = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/"; 
$nricregex = "/^[STFG]\d{7}[A-Z]$/"; 
$dobregex = "/^(0[1-9]|[12][0-9]|3[01])[- -.](0[1-9]|1[012])[- -.](19|20)\d\d$/"; 


$cardnameregex = "/^[a-zA-Z ]+$/"; 
$cardregex = "/^(\d{4}[- ]){3}\d{4}|\d{16}$/"; 
$cvcregex = "/^[0-9]{3,3}$/"; 
$expiryregex = "/(0[1-9]|10|11|12)\/[0-9]{2}$/"; 


$objnameregex = "/^[a-zA-Z\d ]+$/";
$descregex = "/^[a-zA-Z\d ]+$/"; 
$imageregex = "/^[a-zA-Z\d _\.\-]+$/"; 
$cpointregex = "/^[a-zA-Z\d ]+$/"; 
$cdayregex = "/^[0-9]+$/"; 


function checkusername($string){
    $usernameregex = "/^[a-zA-Z\d]+$/"; 
    if (preg_match($usernameregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

function checkpassword($string){
    $passwordregex = "/^[a-zA-Z0-9]+.{9}/"; 
    if (preg_match($passwordregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

function checkemail($string){
    $emailregex = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/"; 
    if (preg_match($emailregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}


function checknric($string){
    $nricregex = "/^[STFG]\d{7}[A-Z]$/"; 
    if (preg_match($nricregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

function checkdob($string){
    $dobregex = "/^(0[1-9]|[12][0-9]|3[01])[- -.](0[1-9]|1[012])[- -.](19|20)\d\d$/"; 
    if (preg_match($dobregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}


function checkcardname($string){
    $cardnameregex = "/^[a-zA-Z ]+$/"; 
    if (preg_match($cardnameregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

function checkcard($string){
    $cardregex = "/^(\d{4}[- ]){3}\d{4}|\d{16}$/" ;
    if (preg_match($cardregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

function checkcvc($string){
    $cvcregex = "/^[0-9]{3,3}$/"; 
    if (preg_match($cvcregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

function checkexpiry($string){
    $expiryregex = "/(0[1-9]|10|11|12)\/[0-9]{2}$/"; 
    if (preg_match($expiryregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}


function checkobjname($string){
    $objnameregex = "/^[a-zA-Z\d ]+$/"; 
    if (preg_match($objnameregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

function checkdesc($string){
    $descregex = "/^[a-zA-Z\d ]+$/"; 
    if (preg_match($descregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

function checkimg($string){
    $imageregex = "/^[a-zA-Z\d _\.\-]+$/";
    if (preg_match($imageregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

function checkcpoint($string){
    $cpointregex = "/^[a-zA-Z\d ]+$/"; 
    if (preg_match($cpointregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

function checkcday($string){
    $cdayregex = "/^[0-9]+$/"; 
    if (preg_match($cdayregex, $string)) {
        return True;
    }
    else {
        return False;
    }
}

?>
