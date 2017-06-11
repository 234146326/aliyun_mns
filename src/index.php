<?php
/**
 * =============================================================
 */
require_once(dirname(dirname(dirname(__FILE__))).'/aliyun_mns/mns-autoloader.php');
\think\Route::get('mns/[:moblie]/[:meg]', "\\think\\mns\\MnsController@index");
?>