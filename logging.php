<?php

define("DEFAULT_LOG","logs/default.log");

define("ADMIN_LOGIN_LOG","logs/Admin_logs/admin_access.log");
define("ADMIN_ADD_LOG","logs/Admin_logs/admin_add.log");
define("ADMIN_UPDATE_LOG","logs/Admin_logs/admin_update.log");
define("ADMIN_DELETE_LOG","logs/Admin_logs/admin_delete.log");
define("ADMIN_APPROVE_LOG","logs/Admin_logs/admin_approve.log");

define("USER_LOGIN_LOG","logs/User_logs/access.log");
define("USER_ADDCAT_LOG","logs/User_logs/add.log");
define("USER_UPDATECAT_LOG","logs/User_logs/update.log");
define("USER_DELETE_LOG","logs/User_logs/delete.log");
define("USER_UPDATE_LOG","logs/User_logs/update.log");
define("USER_BORROW_LOG","logs/User_logs/borrow.log");
define("USER_ADD_CARD","logs/User_logs/card.log");

define("ADMIN_LOGIN_LOG_ERR","logs/Admin_logs/error_admin_access.log");
define("ADMIN_ADD_LOG_ERR","logs/Admin_logs/error_admin_add.log");
define("ADMIN_UPDATE_LOG_ERR","logs/Admin_logs/error_admin_update.log");
define("ADMIN_DELETE_LOG_ERR","logs/Admin_logs/error_admin_delete.log");
define("ADMIN_APPROVE_LOG_ERR","logs/Admin_logs/error_admin_approve.log");

define("USER_LOGIN_LOG_ERR","logs/User_logs/error_access.log");
define("USER_ADDCAT_LOG_ERR","logs/User_logs/error_add.log");
define("USER_UPDATECAT_LOG_ERR","logs/User_logs/error_update.log");
define("USER_DELETE_LOG_ERR","logs/User_logs/error_delete.log");
define("USER_UPDATE_LOG_ERR","logs/User_logs/error_update.log");
define("USER_BORROW_LOG_ERR","logs/User_logs/error_borrow.log");
define("USER_ADD_CARD_ERR","logs/User_logs/error_card.log");

function write_log( $logfile='',$message) {
  
  if($logfile == '') {
   
    if (defined(DEFAULT_LOG) == TRUE) {
        $logfile = DEFAULT_LOG;
    }
   
    else {
        error_log('No log file defined!',0);
        return array(status => false, message => 'No log file defined!');
    }
  } 
  if( ($time = $_SERVER['REQUEST_TIME']) == '') {
    $time = time();
  }
  
  $date = date("Y-m-d H:i:s", $time);
  $message_with_time= $message."  ". $date ;
  $handle= fopen($logfile,'a');
  fwrite($handle,$message_with_time);
  fclose($handle);
}
?>
