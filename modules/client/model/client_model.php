<?php
/**
 * User: Oriovaldo Fialho
 * Date: 22/11/16
 * Time: 20:25
 * Abstract: arquivo responsavel por toda a interação dom o Banco de Dados
 */

class client_model {

    public function getDadaClient(){
        $con = connection::connect();
        $sql = "Select clientCod,clientNomeRazaoSocial,
                       CASE clientTipo
                        WHEN 'PJ' THEN 'Pessoa Jurídica'
                        WHEN 'PF' THEN 'Pessoa Física'
                        END as tipo,
                        clientCpfCnpj
                  From client ";
        $result = $con->query($sql)->fetchAll();
        return $result;
    }
    public function getClient($insertIdClient){
        $con = connection::connect();
        $sql = "Select clientCod,clientNomeRazaoSocial,
                       CASE clientTipo
                        WHEN 'PJ' THEN 'Pessoa Jurídica'
                        WHEN 'PF' THEN 'Pessoa Física'
                        END as tipo,
                        clientCpfCnpj,
                        clientTipo
                  From client
                  WHERE clientCod = :clientCod ";
        $result = $con->prepare($sql);
        $result->execute(array(':clientCod' => $insertIdClient));
        $resultSet = $result->fetch();

        return $resultSet;
    }
    public function getContact($insertIdClient){
        $con = connection::connect();
        $sql = "Select *
                  From contact
                  WHERE clientCod = :clientCod ";
        $result = $con->prepare($sql);
        $result->execute(array(':clientCod' => $insertIdClient));
        $resultSet = $result->fetchAll();

        return $resultSet;
    }
    public function getAdress($insertIdClient){
        $con = connection::connect();
        $sql = "Select *
                  From adress
                  WHERE clientCod = :clientCod ";
        $result = $con->prepare($sql);
        $result->execute(array(':clientCod' => $insertIdClient));
        $resultSet = $result->fetchAll();

        return $resultSet;
    }

    public function insert($obj){
        $con = connection::connect();
        $stmt = $con->prepare('INSERT INTO client (clientNomeRazaoSocial,clientTipo,clientNomeFantasia,
                                                   clientCpfCnpj,clientInscricaoEstadual)
                                      VALUES(:clientNomeRazaoSocial,:clientTipo,:clientNomeFantasia,
                                                         :clientCpfCnpj,:clientInscricaoEstadual)');

        $stmt->execute(array(
            ':clientNomeRazaoSocial'    => $obj->getField('clientNomeRazaoSocial',true,'text'),
            ':clientTipo'               => $obj->getField('clientTipo',true,'text'),
            ':clientNomeFantasia'       => $obj->getField('clientNomeFantasia',true,'text'),
            ':clientCpfCnpj'            => $obj->getField('clientCpfCnpj',true,'text'),
            ':clientInscricaoEstadual'  => $obj->getField('clientInscricaoEstadual',true,'text')
        ));

        return $con->lastInsertId();

    }
    public function update($clientCod,$obj){
        $con = connection::connect();
        $stmt = $con->prepare("UPDATE client
                                SET clientNomeRazaoSocial   = :clientNomeRazaoSocial,   clientTipo  = :clientTipo,
                                    clientNomeFantasia      = :clientNomeFantasia,    clientCpfCnpj = :clientCpfCnpj,
                                    clientInscricaoEstadual = :clientInscricaoEstadual
                                WHERE clientCod = :clientCod ");


        $stmt->execute(array(
            ':clientNomeRazaoSocial'    => $obj->getField('clientNomeRazaoSocial',true,'text'),
            ':clientTipo'               => $obj->getField('clientTipo',true,'text'),
            ':clientNomeFantasia'       => $obj->getField('clientNomeFantasia',true,'text'),
            ':clientCpfCnpj'            => $obj->getField('clientCpfCnpj',true,'text'),
            ':clientInscricaoEstadual'  => $obj->getField('clientInscricaoEstadual',true,'text'),
            ':clientCod'  => $clientCod
        ));

        return true;

    }
    public function insertContact($obj){
        $arrayContact = $obj->getField('arrayContact');
        if(!empty($arrayContact)){
            $con = connection::connect();
            $stmt = $con->prepare('INSERT INTO contact (clientCod,contactType,contactValue)
                                      VALUES(:clientCod,:contactType,:contactValue)');
            foreach($arrayContact as $key){
                $stmt->execute(array(
                    ':clientCod'    => $obj->getField('insertIdClient'),
                    ':contactType'  => $obj->getField('contactType'.$key,true,'text'),
                    ':contactValue' => $obj->getField('contactValue'.$key,true,'text')
                ));
            }
            return true;
        }
    }
    public function insertAdress($obj){
        $arrayAddress = $obj->getField('arrayAddress');
        if(!empty($arrayAddress)){
            $con = connection::connect();
            $stmt = $con->prepare('INSERT INTO adress
                                      (clientCod,address,addressNumber,addressZipCode,addressComplement,addressNeighborhood,
                                      addressCity,addressState,addressCountries
                                      )
                                      VALUES
                                      (:clientCod,:address,:addressNumber,:addressZipCode,:addressComplement,:addressNeighborhood,
                                      :addressCity,:addressState,:addressCountries
                                      )');
            foreach($arrayAddress as $key){
                $stmt->execute(array(
                    ':clientCod'                => $obj->getField('insertIdClient'),
                    ':address'                  => $obj->getField('address'.$key,true,'text'),
                    ':addressNumber'            => $obj->getField('addressNumber'.$key,true,'text'),
                    ':addressZipCode'           => $obj->getField('addressZipCode'.$key,true,'text'),
                    ':addressComplement'        => $obj->getField('addressComplement'.$key,true,'text'),
                    ':addressNeighborhood'      => $obj->getField('addressNeighborhood'.$key,true,'text'),
                    ':addressCity'              => $obj->getField('addressCity'.$key,true,'text'),
                    ':addressState'             => $obj->getField('addressState'.$key,true,'text'),
                    ':addressCountries'         => $obj->getField('addressCountries'.$key,true,'text'),
                ));
            }
            return true;
        }
    }

    public function deleteClient($insertIdClient){
        $con = connection::connect();
        $stmtClient = $con->prepare('DELETE FROM client WHERE clientCod = :clientCod ');
        $stmtClient->execute(array(':clientCod' => $insertIdClient));

        return true;
    }
    public function deleteClientDependec($insertIdClient){
        $con = connection::connect();
        $stmtAdress = $con->prepare('DELETE FROM adress WHERE clientCod = :clientCod ');
        $stmtAdress->execute(array(':clientCod' => $insertIdClient));

        $stmtContact = $con->prepare('DELETE FROM contact WHERE clientCod = :clientCod ');
        $stmtContact->execute(array(':clientCod' => $insertIdClient));


        return true;
    }

}