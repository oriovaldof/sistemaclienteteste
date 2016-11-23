<?php
session_start();
include_once('../../../include_archives.php');
/**
 * User: Oriovaldo Fialho
 * Date: 22/11/16
 * Time: 23:16
 * Abstract: arquivo responsavel pelo controller das chamadas Ajax
 */



switch ($_GET['Op'])
{
    case "grid":
        include_once($_SESSION['DirSis'].'modules/client/model/client_model.php');
        $client = new client_model();

        $resultSet = $client->getDadaClient();
        $html = '';
        if(empty($resultSet)){
            $html .= '<tr><td colspan="4">Nenhum Resultado foi encontrado</td></tr>';
        }else{
            foreach($resultSet as $dada){
                $cod            =  $dada['clientCod'];
                $html .= '<tr>
                            <td>'.$dada['clientNomeRazaoSocial'].'</td>
                            <td>'.$dada['tipo'].'</td>
                            <td>'.$dada['clientCpfCnpj'].'</td>
                            <td>';

                $html .= '<img src="'.$_SESSION['UrlSite'].'assets/images/preview.png" style="cursor:pointer; margin-right:10px;" alt="Alterar o Registro"  title="Alterar o Registro"  onclick="vis(\''.$cod.'\')">';
                $html .= '<img src="'.$_SESSION['UrlSite'].'assets/images/edit.png" style="cursor:pointer; margin-right:10px;" alt="Alterar o Registro"  title="Alterar o Registro"  onclick="edit(\''.$cod.'\')">';
                $html .= '<img src="'.$_SESSION['UrlSite'].'assets/images/close.png" style="cursor:pointer; margin-right:10px;" alt="Remover o Registro"  title="Remover o Registro"  onclick="deleter(\''.$cod.'\')">';
                $html .= '  </td>
                         </tr>';
            }
        }
        echo $html;
        break;
    case "vis":
        include_once($_SESSION['DirSis'].'modules/client/model/client_model.php');
        $client                 = new client_model();
        $obj                    = new object();
        $arrayReturn            = array();

        try{
            $insertIdClient =  (int)$obj->getField('clientCod');
            $html    = '';
            if(!empty($insertIdClient) && ($insertIdClient > 0)){
                $arrayReturn = $client->getClient($insertIdClient);

                $html    .= '<table class="table">';
                $html    .= '<tr>
                                <td>
                                    Cliente<br/>
                                    '.$arrayReturn['clientNomeRazaoSocial'].'
                                </td>
                            </tr>';
                $html    .= '<tr>
                                <td>
                                    Tipo<br/>
                                    '.$arrayReturn['tipo'].'
                                </td>
                            </tr>';
                $html    .= '<tr>
                                <td>
                                    CPF/CNPJ<br/>
                                    '.$arrayReturn['clientCpfCnpj'].'
                                </td>
                            </tr>';


                $rsContact      = $client->getContact($insertIdClient);
                if(!empty($rsContact)){
                    $html    .= '<tr>
                                <td>
                                    Contato<br/>';
                    $arrayType = array();
                    $arrayType['TL'] = 'Telefone';
                    $arrayType['EM'] = 'E-mail';
                    foreach($rsContact as $dadaContact){
                        $cod            =  $dadaContact['contactCod'];
                        $type           =  $dadaContact['contactType'];

                        if($type =="TL"){
                            $html    .=   $arrayType[$type].':'.$dadaContact['contactValue'].'<br/>';
                        }else{
                            $html    .=   $arrayType[$type].':<a href="mailto:'.$dadaContact['contactValue'].'" target="_top"><img src="'.$_SESSION['UrlSite'].'assets/images/mail.png" style="cursor:pointer; margin-right:10px;" alt="Enviar E-mail"  title="Enviar E-mail" >'.$dadaContact['contactValue'].'</a><br/>';
                        }

                    }
                    $html .='  </td>
                            </tr>';
                }
                $html .= '';

                $rsAdress                       = $client->getAdress($insertIdClient);
                if(!empty($rsAdress)){
                    $html    .= '<tr>
                                <td>
                                    Endereço<br/>';
                    foreach($rsAdress as $dadaAdress){
                        $cod            =  $dadaAdress['adressCod'];


                        $html .=   '<div class="col-md-4 col-sm-4 col-xs-12" id="divAddress'.$cod.'" style="background:#EDEDED; margin-top: 15px; margin-right: 15px; margin-left: 15px;">

                                            <div class="form-group">
                                                <label class="control-label" for="address'.$cod.'">Endereço:</label>
                                                <br/>
                                                <div>
                                                    '.$dadaAdress['address'].'
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressNumber'.$cod.'">Numero:</label>
                                                <br/>
                                                <div>
                                                    '.$dadaAdress['addressNumber'].'
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressZipCode'.$cod.'">CEP:</label>
                                                <br/>
                                                <div>
                                                    '.$dadaAdress['addressZipCode'].'
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressComplement'.$cod.'">Complemento:</label>
                                                <br/>
                                                <div>
                                                    '.$dadaAdress['addressComplement'].'
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressNeighborhood'.$cod.'">Bairro:</label>
                                                <br/>
                                                <div>
                                                    '.$dadaAdress['addressNeighborhood'].'
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressCity'.$cod.'">Cidade:</label>
                                                <br/>
                                                <div>
                                                    '.$dadaAdress['addressCity'].'
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressState'.$cod.'">Estado:</label>
                                                <br/>
                                                <div>
                                                    '.$dadaAdress['addressState'].'
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressCountries'.$cod.'">País:</label>
                                                <br/>
                                                <div>
                                                    '.$dadaAdress['addressCountries'].'
                                                </div>
                                            </div>
                                        </div>';
                    }
                    $html .='  </td>
                            </tr>';
                }
                $html    .= '<tr>
                                <td>
                                     <button type="button" class="btn btn-primary" onclick="returnGrid()">Voltar</button>
                                </td>
                            </tr>';

                $html    .= '</table>';

                $arrayReturn['returnHtml']  = $html;
                $arrayReturn['action']  = 'S';
                $arrayReturn['Message'] = 'Registro removido com Sucesso';
            }else{
                $arrayReturn['action']  = 'N';
                $arrayReturn['Message'] = 'Não foi carregar os dados registro';
            }

        }catch (Exception $e){
            //$arrayReturn['Message'] = $e->getMessage();
            $arrayReturn['action']  = 'N';
            $arrayReturn['Message'] = 'Ocorreu um erro inesperado por favor tente mais tarde';

        }
        echo json_encode($arrayReturn);
        break;
    case "edit":
        include_once($_SESSION['DirSis'].'modules/client/model/client_model.php');
        $client                 = new client_model();
        $obj                    = new object();
        $arrayReturn            = array();

        try{
            $insertIdClient =  (int)$obj->getField('clientCod');

            if(!empty($insertIdClient) && ($insertIdClient > 0)){
                $arrayReturn = $client->getClient($insertIdClient);

                $htmlContact    = '';
                $rsContact      = $client->getContact($insertIdClient);
                if(!empty($rsContact)){
                    foreach($rsContact as $dadaContact){
                        $cod            =  $dadaContact['contactCod'];
                        $type           =  $dadaContact['contactType'];
                        $selectedTL     =   '';
                        $selectedEM     =   '';
                        if($type == "TL"){
                            $selectedTL     =   ' selected ';
                            $classphone     =   ' classContactPhone ';
                        }else{
                            $selectedEM     =   ' selected ';
                            $classphone     =   '';
                        }

                        $htmlContact    .=   '<div class="col-md-4 col-sm-4 col-xs-12" id="divContact'.$cod.'" style="background:#EDEDED; margin-top: 15px; margin-right: 15px; margin-left: 15px;">
                                <div class="btContact"><img src="'.$_SESSION['UrlSite'].'assets/images/close.png" onclick="removeContact(\''.$cod.'\')"  alt="Remover Contato"  title="Remover Contato"></div>
                                <input id="arrayContact['.$cod.']" name="arrayContact['.$cod.']" class="form-control" type="hidden" value="'.$cod.'">
                                <div class="form-group">
                                    <label class="control-label for="contactType'.$cod.'">Tipo</label>
                                    <br/>
                                    <div>
                                        <select class="form-control" id="contactType'.$cod.'" name="contactType'.$cod.'" onchange="confContactValue(\''.$cod.'\')">
                                            <option value="TL" '.$selectedTL.'>Telefone</option>
                                            <option value="EM" '.$selectedEM.'>E-mail</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="contactValue'.$cod.'"><span id="spanContactValue'.$cod.'">Telefone:</span></label>
                                    <br/>
                                    <div>
                                        <input id="contactValue'.$cod.'" name="contactValue'.$cod.'" class="'.$classphone.' form-control  col-md-7 col-xs-12" type="text" value="'.$dadaContact['contactValue'].'" onchange="validaFormContact(\''.$cod.'\')">
                                    </div>
                                </div>
                            </div>';
                    }
                }
                $arrayReturn['htmlContact']     = $htmlContact;
                $htmlAdress                     = '';
                $rsAdress                       = $client->getAdress($insertIdClient);
                if(!empty($rsAdress)){
                    foreach($rsAdress as $dadaAdress){
                        $cod            =  $dadaAdress['adressCod'];


                    $htmlAdress    .=   '<div class="col-md-4 col-sm-4 col-xs-12" id="divAddress'.$cod.'" style="background:#EDEDED; margin-top: 15px; margin-right: 15px; margin-left: 15px;">
                                            <div class="btContact"><img src="'.$_SESSION['UrlSite'].'assets/images/close.png" onclick="removeAddress(\''.$cod.'\')"  alt="Remover Endereço"  title="Remover Endereço"></div>
                                            <input id="arrayAdress['.$cod.']" name="arrayAddress['.$cod.']" class="form-control" type="hidden" value="'.$cod.'">
                                            <div class="form-group">
                                                <label class="control-label" for="address'.$cod.'">Endereço:</label>
                                                <br/>
                                                <div>
                                                    <input id="address'.$cod.'" name="address'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text" value="'.$dadaAdress['address'].'">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressNumber'.$cod.'">Numero:</label>
                                                <br/>
                                                <div>
                                                    <input id="addressNumber'.$cod.'" name="addressNumber'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text" value="'.$dadaAdress['addressNumber'].'">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressZipCode'.$cod.'">CEP:</label>
                                                <br/>
                                                <div>
                                                    <input id="addressZipCode'.$cod.'" name="addressZipCode'.$cod.'" class="classaddressZipCode form-control  col-md-7 col-xs-12" type="text" value="'.$dadaAdress['addressZipCode'].'">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressComplement'.$cod.'">Complemento:</label>
                                                <br/>
                                                <div>
                                                    <input id="addressComplement'.$cod.'" name="addressComplement'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text" value="'.$dadaAdress['addressComplement'].'">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressNeighborhood'.$cod.'">Bairro:</label>
                                                <br/>
                                                <div>
                                                    <input id="addressNeighborhood'.$cod.'" name="addressNeighborhood'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text" value="'.$dadaAdress['addressNeighborhood'].'">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressCity'.$cod.'">Cidade:</label>
                                                <br/>
                                                <div>
                                                    <input id="addressCity'.$cod.'" name="addressCity'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text" value="'.$dadaAdress['addressCity'].'">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressState'.$cod.'">Estado:</label>
                                                <br/>
                                                <div>
                                                    <input id="addressState'.$cod.'" name="addressState'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text" value="'.$dadaAdress['addressState'].'">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="addressCountries'.$cod.'">País:</label>
                                                <br/>
                                                <div>
                                                    <input id="addressCountries'.$cod.'" name="addressCountries'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text" value="'.$dadaAdress['addressCountries'].'">
                                                </div>
                                            </div>
                                        </div>';
                    }
                }
                $arrayReturn['htmlAdress']  = $htmlAdress;

                $arrayReturn['action']  = 'S';
                $arrayReturn['Message'] = 'Registro removido com Sucesso';
            }else{
                $arrayReturn['action']  = 'N';
                $arrayReturn['Message'] = 'Não foi carregar os dados registro';
            }

        }catch (Exception $e){
            //$arrayReturn['Message'] = $e->getMessage();
            $arrayReturn['action']  = 'N';
            $arrayReturn['Message'] = 'Ocorreu um erro inesperado por favor tente mais tarde';

        }
        echo json_encode($arrayReturn);
        break;
    case "delete":
        include_once($_SESSION['DirSis'].'modules/client/model/client_model.php');
        $client                 = new client_model();
        $obj                    = new object();
        $arrayReturn            = array();
        $arrayReturn['action']  = 'N';
        $arrayReturn['Message'] = 'Não foi possivel remover o registro';
        $con                    = connection::connect();

        $con->beginTransaction();
        try{
            $insertIdClient =  (int)$obj->getField('clientCod');

            if(!empty($insertIdClient) && ($insertIdClient > 0)){
                $client->deleteClientDependec($insertIdClient);
                $client->deleteClient($insertIdClient);
                $con->commit();
                $arrayReturn['action']  = 'S';
                $arrayReturn['Message'] = 'Registro removido com Sucesso';
            }

        }catch (Exception $e){
            //$arrayReturn['Message'] = $e->getMessage();
            $arrayReturn['Message'] = 'Ocorreu um erro inesperado por favor tente mais tarde';
        $con->rollBack();
        }
        echo json_encode($arrayReturn);
        break;
    case "registerClient":
        include_once($_SESSION['DirSis'].'modules/client/model/client_model.php');
        $client                 = new client_model();
        $obj                    = new object();
        $arrayReturn            = array();
        $arrayReturn['action']  = 'N';
        $con                    = connection::connect();

        $con->beginTransaction();
        try{
            $insertIdClient = $client->insert($obj);
            $obj->setField('insertIdClient',$insertIdClient);

            $client->insertContact($obj);
            $client->insertAdress($obj);


            $con->commit();
            $arrayReturn['action']  = 'S';
            $arrayReturn['Message'] = 'Registro Gravado com Sucesso';
        }catch (Exception $e){
            //$arrayReturn['Message'] = $e->getMessage();
            $arrayReturn['Message'] = 'Ocorreu um erro inesperado por favor tente mais tarde';
            $con->rollBack();
        }
        echo json_encode($arrayReturn);
        break;
    case "updatClient":
        include_once($_SESSION['DirSis'].'modules/client/model/client_model.php');
        $client                 = new client_model();
        $obj                    = new object();
        $arrayReturn            = array();
        $arrayReturn['action']  = 'N';
        $con                    = connection::connect();

        $con->beginTransaction();
        try{
            $id         = (int)$obj->getField('Id');
            $clientCod  = (int)$obj->getField('clientCod');

            if(!empty($id) && !empty($clientCod)){
               if($id == $clientCod){
                   $client->update($clientCod,$obj);
                   $client->deleteClientDependec($clientCod);

                   $obj->setField('insertIdClient',$clientCod);
                   $client->insertContact($obj);
                   $client->insertAdress($obj);

                   $arrayReturn['action']  = 'S';
                   $arrayReturn['Message'] = 'Registro Alterado com Sucesso';

               }else{
                   $arrayReturn['action']  = 'N';
                   $arrayReturn['Message'] = 'Erro ao Alterar o Registro';
               }
            }else{
                $arrayReturn['action']  = 'N';
                $arrayReturn['Message'] = 'Erro ao Alterar o Registro';
            }



            $con->commit();

        }catch (Exception $e){
            $arrayReturn['Message'] = $e->getMessage();
           // $arrayReturn['Message'] = 'Ocorreu um erro inesperado por favor tente mais tarde';
            $con->rollBack();
        }
        echo json_encode($arrayReturn);
        break;
    case "addContact":
        $cod            =  mt_rand(9,999);
        $arrayReturn    = array();
        $html           =   '<div class="col-md-4 col-sm-4 col-xs-12" id="divContact'.$cod.'" style="background:#EDEDED; margin-top: 15px; margin-right: 15px; margin-left: 15px;">
                                <div class="btContact"><img src="'.$_SESSION['UrlSite'].'assets/images/close.png" onclick="removeContact(\''.$cod.'\')"  alt="Remover Contato"  title="Remover Contato"></div>
                                <input id="arrayContact['.$cod.']" name="arrayContact['.$cod.']" class="form-control" type="hidden" value="'.$cod.'">
                                <div class="form-group">
                                    <label class="control-label for="contactType'.$cod.'">Tipo</label>
                                    <br/>
                                    <div>
                                        <select class="form-control" id="contactType'.$cod.'" name="contactType'.$cod.'" onchange="confContactValue(\''.$cod.'\')">
                                            <option value="TL">Telefone</option>
                                            <option value="EM">E-mail</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="contactValue'.$cod.'"><span id="spanContactValue'.$cod.'">Telefone:</span></label>
                                    <br/>
                                    <div>
                                        <input id="contactValue'.$cod.'" name="contactValue'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text" onchange="validaFormContact(\''.$cod.'\')">
                                    </div>
                                </div>
                            </div>';
        $arrayReturn['returnHtml']  = $html;
        $arrayReturn['returnCod']   = $cod;

        echo json_encode($arrayReturn);


        break;
    case "addAddress":
        $cod            =  mt_rand(9,999);
        $arrayReturn    = array();
        $html           =   '<div class="col-md-4 col-sm-4 col-xs-12" id="divAddress'.$cod.'" style="background:#EDEDED; margin-top: 15px; margin-right: 15px; margin-left: 15px;">
                                <div class="btContact"><img src="'.$_SESSION['UrlSite'].'assets/images/close.png" onclick="removeAddress(\''.$cod.'\')"  alt="Remover Endereço"  title="Remover Endereço"></div>
                                <input id="arrayAdress['.$cod.']" name="arrayAddress['.$cod.']" class="form-control" type="hidden" value="'.$cod.'">
                                <div class="form-group">
                                    <label class="control-label" for="address'.$cod.'">Endereço:</label>
                                    <br/>
                                    <div>
                                        <input id="address'.$cod.'" name="address'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="addressNumber'.$cod.'">Numero:</label>
                                    <br/>
                                    <div>
                                        <input id="addressNumber'.$cod.'" name="addressNumber'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="addressZipCode'.$cod.'">CEP:</label>
                                    <br/>
                                    <div>
                                        <input id="addressZipCode'.$cod.'" name="addressZipCode'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="addressComplement'.$cod.'">Complemento:</label>
                                    <br/>
                                    <div>
                                        <input id="addressComplement'.$cod.'" name="addressComplement'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="addressNeighborhood'.$cod.'">Bairro:</label>
                                    <br/>
                                    <div>
                                        <input id="addressNeighborhood'.$cod.'" name="addressNeighborhood'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="addressCity'.$cod.'">Cidade:</label>
                                    <br/>
                                    <div>
                                        <input id="addressCity'.$cod.'" name="addressCity'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="addressState'.$cod.'">Estado:</label>
                                    <br/>
                                    <div>
                                        <input id="addressState'.$cod.'" name="addressState'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="addressCountries'.$cod.'">País:</label>
                                    <br/>
                                    <div>
                                        <input id="addressCountries'.$cod.'" name="addressCountries'.$cod.'" class="form-control  col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                            </div>';
        $arrayReturn['returnHtml']  = $html;
        $arrayReturn['returnCod']   = $cod;

        echo json_encode($arrayReturn);
        break;

}