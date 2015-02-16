<?php

class CustomLog{
  static public function newLog($message) {
 
        $logFile = sfConfig::get('sf_log_dir').'/custom_logs.log';
        $custom_log = new sfFileLogger(new sfEventDispatcher(), array('file' => $logFile));
        $custom_log->info($message);
 
  }  
}

/*
 * Para escribir un nuevo log en cualquier parte del código:
 * 
 * CustomLog::newLog("Escribimos un nuevo log");
 */