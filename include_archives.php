<?php
//define arquivo de sessao
$_SESSION['DirSis']     = dirname(__FILE__).'/';
$_SESSION['UrlSite']    = 'http://localhost/sistemateste/sistema/';
$_SESSION['email']      = 'sistemaclienteteste@gmail.com';
$_SESSION['passMail']   = 'enigma0001';

//efetua includes necessarios
include_once($_SESSION['DirSis'].'framework/connection/connection.php');
include_once($_SESSION['DirSis'].'framework/object/object.php');

?>