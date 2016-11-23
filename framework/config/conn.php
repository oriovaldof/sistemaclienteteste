<?php
/**
 * User: Oriovaldo Fialho
 * Date: 22/11/16
 * Time: 20:02
 * Abstract: classe responsavel por receber configuração BD
 */

class conn {
    /*
        *	Atributos da Classe
        */
    private $User, $Pass, $BD, $Host;

    /**
     *	Método Construtor
     */
    protected function conn()
    {
        //Variaveis de Conexao Local
        $this->setUser("root");
        $this->setPass("enigma0001");
        $this->setBD("sistemaCliente");
        $this->setHost("localhost");

    }

    protected function setUser($Valor)
    {
        $this->User = $Valor;
    }

    protected function getUser()
    {
        return $this->User;
    }

    protected function setPass($Valor)
    {
        $this->Pass = $Valor;
    }

    protected function getPass()
    {
        return $this->Pass;
    }

    protected function setBD($Valor)
    {
        $this->BD = $Valor;
    }

    protected function getBD()
    {
        return $this->BD;
    }

    protected function setHost($Valor)
    {
        $this->Host = $Valor;
    }

    protected function getHost()
    {
        return $this->Host;
    }
}