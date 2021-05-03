<?php

/**
 * ########################
 * ###   APPLICATION    ###
 * ########################
 */
const CONF_CONTAINER_CONFIG = __DIR__ . '/../../../services.yaml';
const CONF_LOG_FILE =  __DIR__ . '/../../../logs/log.log';

/**
 * ########################
 * ###   STATEMENTS CM  ###
 * ########################
 */

 /**
  * Reads CM queries located in the default 'resources' folder
  *
  * @param string $queryName
  * @return string|null
  */
 function file_get_string_sql(string $queryName): ? string
 {    
    $path = __DIR__ . "/../Resources/{$queryName}.sql";
    if(file_exists($path)){
        return file_get_contents($path);
    } else return null;
 }