<?php
/**
 * User: Oriovaldo Fialho
 * Date: 22/11/16
 * Time: 20:03
  * Abstract: classe de conexao PDO utilizando padrao singleton
 */
include_once($_SESSION['DirSis'].'framework/config/conn.php');
class connection extends conn{

    private static $Instance, $Link;

    private function __construct()
    {
        //Instancia variaveis de conexao
        parent::conn();

        try {
            self::$Link  = new PDO('mysql:host=' . parent::getHost() . ';dbname=' . parent::getBD(), parent::getUser(), parent::getPass());

            self::$Link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$Link->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
        }

    }

    public static function connect()
    {
        if (!isset(self::$Link))
        {
            try
            {
                new connection();
            }
            catch(Exception $E)
            {
                exit($E->getMessage());
            }
        }

        return self::$Link;
    }




}