<?php
/**
 * =============================================================
 */

//兼容新版本5.1
Route::get('mns/[:moblie]', "\\think\\mns\\MnsController@index");
Log::write('新版本Thinkphp5.1','notice');

?>