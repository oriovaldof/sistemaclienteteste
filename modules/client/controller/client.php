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

                $html .= '<img src="'.$_SESSION['UrlSite'].'assets/images/mail.png" style="cursor:pointer; margin-right:10px;" alt="Enviar E-mail"  title="Enviar E-mail"   onclick="mailForm(\''.$cod.'\')">';
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
    case "mailForm":
        include_once($_SESSION['DirSis'].'modules/client/model/client_model.php');
        $client                 = new client_model();
        $obj                    = new object();
        $arrayReturn            = array();

        try{
            $insertIdClient =  (int)$obj->getField('clientCod');
            $html    = '';
            if(!empty($insertIdClient) && ($insertIdClient > 0)){
                $arrayReturn = $client->getClient($insertIdClient);
                $rsContact      = $client->getContact($insertIdClient, 'EM');

                if(!empty($rsContact)){
                    $html    .= '<form id="FormMail">';
                    $html    .= '<table class="table">';
                    $html    .= '<tr>
                                <td>
                                    Cliente
                                </td>
                                <td>
                                     '.$arrayReturn['clientNomeRazaoSocial'].'
                                </td>
                            </tr>';




                    $html    .= '<tr>
                                <td>
                                    E-mail:
                                </td>
                                <td>    ';

                    $html    .='<div class="checkbox">
                                    <label>
                                      <input type="checkbox" id="sendAll" name="sendAll" value="'.$insertIdClient.'"> Enviar Para Todos
                                    </label>
                                </div>';
                    $arrayType = array();
                    $arrayType['TL'] = 'Telefone';
                    $arrayType['EM'] = 'E-mail';
                    foreach($rsContact as $dadaContact){
                        $cod            =  $dadaContact['contactCod'];

                        $html    .='<div class="checkbox">
                                    <label>
                                      <input type="hidden" id="arrayContact['.$cod.']" name="arrayContact['.$cod.']"  value="'.$cod.'">
                                      <input type="checkbox" id="sendMail'.$cod.'" name="sendMail'.$cod.'" class="classCheck" value="'.$dadaContact['contactValue'].'"> '.$dadaContact['contactValue'].'
                                    </label>
                                </div>';

                    }
                    $html .='  </td>
                            </tr>';

                    $html    .= '<tr>
                                <td>
                                    Mensagem
                                </td>
                                <td>
                                    <div class="x_panel">
                                    <div class="x_content">
                                    <div id="alerts"></div>
                                     <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                                        <div class="btn-group">
                                          <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                          <ul class="dropdown-menu">
                                          <li><a data-edit="fontName Serif" style="font-family:Serif">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:Sans">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:Arial">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:Arial Black">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:Courier">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:Courier New">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:Comic Sans MS">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:Helvetica">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:Impact">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:Lucida Grande">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:Lucida Sans">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:Tahoma">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:Times">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:Times New Roman">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:Verdana">Verdana</a></li></ul>
                                        </div>

                                        <div class="btn-group">
                                          <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size" aria-expanded="false"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                          <ul class="dropdown-menu">
                                            <li>
                                              <a data-edit="fontSize 5">
                                                <p style="font-size:17px">Huge</p>
                                              </a>
                                            </li>
                                            <li>
                                              <a data-edit="fontSize 3" class="">
                                                <p style="font-size:14px">Normal</p>
                                              </a>
                                            </li>
                                            <li>
                                              <a data-edit="fontSize 1" class="btn-info">
                                                <p style="font-size:11px">Small</p>
                                              </a>
                                            </li>
                                          </ul>
                                        </div>

                                        <div class="btn-group">
                                          <a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                          <a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                          <a class="btn" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                          <a class="btn" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                        </div>

                                        <div class="btn-group">
                                          <a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                          <a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="fa fa-list-ol"></i></a>
                                          <a class="btn" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                          <a class="btn" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                        </div>

                                        <div class="btn-group">
                                          <a class="btn btn-info" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                          <a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                          <a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                          <a class="btn" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                        </div>

                                        <div class="btn-group">
                                          <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="fa fa-link"></i></a>
                                          <div class="dropdown-menu input-append">
                                            <input class="span2" placeholder="URL" type="text" data-edit="createLink">
                                            <button class="btn" type="button">Add</button>
                                          </div>
                                          <a class="btn" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                        </div>

                                        <div class="btn-group">
                                          <a class="btn" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="fa fa-picture-o"></i></a>
                                          <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 40px; height: 34px;">
                                        </div>

                                        <div class="btn-group">
                                          <a class="btn" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                          <a class="btn" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                        </div>
                                      </div>
                                      <div id="editor" class="editor-wrapper placeholderText" contenteditable="true"><div><br></div></div>
                                      <textarea name="descr" id="descr" style="display:none;"></textarea>
                                    </div>
                                    </div>
                                </td>
                            </tr>';


                    $html    .= '<tr>
                                <td></td>
                                <td>
                                     <button type="button" class="btn btn-primary" onclick="returnGrid()">Voltar</button>
                                     <button type="button" class="btn btn-success" onclick="sendMail()">Enviar</button>
                                </td>
                            </tr>';

                    $html    .= '</table>';
                    $html    .= '</form>';
                    $arrayReturn['returnHtml']  = $html;
                    $arrayReturn['action']  = 'S';
                    $arrayReturn['Message'] = 'Registro removido com Sucesso';
                }else{
                    $arrayReturn['action']  = 'N';
                    $arrayReturn['Message'] = 'O Cliente não possue E-mail Cadastrado!';
                }




            }else{
                $arrayReturn['action']  = 'N';
                $arrayReturn['Message'] = 'Não foi carregar os dados registro';
            }

        }catch (Exception $e){
            $arrayReturn['action']  = 'N';
            $arrayReturn['Message'] = 'Ocorreu um erro inesperado por favor tente mais tarde';

        }
        echo json_encode($arrayReturn);
        break;
    case "sendMail":
        include_once($_SESSION['DirSis'].'modules/client/model/client_model.php');
        $client                 = new client_model();
        $obj                    = new object();
        $arrayReturn            = array();
        $arrayReturn['action']  = 'N';
        $arrayReturn['Message'] = 'Não foi possivel remover o registro';

        try{
            $arrayContact =  $obj->getField('arrayContact');
            $arrayEmail = array();
            if(!empty($arrayContact)){
               foreach($arrayContact as $key){
                    $email = $obj->getField('sendMail'.$key);
                    if(!empty($email)){
                        $arrayEmail[$email] = $email;
                    }
                }
            }
            $sendAll   =   $obj->getField('sendAll');
            if(!empty($sendAll)){
                $rsContact      = $client->getContact($sendAll, 'EM');
                if(!empty($rsContact)){
                    foreach($rsContact as $dadaContact){
                        $email = $dadaContact['contactValue'];
                        $arrayEmail[$email] = $email;
                    }
                }
            }


            if(!empty($arrayEmail)){
                $message    =  $obj->getField('editor');

                // Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
                require_once($_SESSION['DirSis']."framework/PHPMailer/PHPMailerAutoload.php");

                $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = $_SESSION['email'];                 // SMTP username
                $mail->Password = $_SESSION['passMail'];                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                $mail->setFrom($_SESSION['email'], 'Sistema Cliente');
                foreach($arrayEmail as $key => $email){
                    $mail->addAddress($email);               // Name is optional
                }


                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = 'Contato Sistema Cliente';
                $mail->Body    = $message;


                if ($mail->send()) {
                    $arrayReturn['action']  = 'S';
                    $arrayReturn['Message'] = 'E-mail enviado com Sucesso';
                } else {
                    $arrayReturn['action']  = 'N';
                    //$arrayReturn['Message'] = $mail->ErrorInfo;
                    $arrayReturn['Message'] = 'Não foi possivel enviar o E-mail, por favor tente Novamente!';
                   // echo "Não foi possível enviar o e-mail.";
                   // echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
                }
            }else{
                $arrayReturn['action']  = 'N';
                $arrayReturn['Message'] = 'Deve exiistir pelo menos 1 e-mail selecionado';
            }




        }catch (Exception $e){
            //$arrayReturn['Message'] = $e->getMessage();
            $arrayReturn['Message'] = 'Ocorreu um erro inesperado por favor tente mais tarde';

        }
        echo json_encode($arrayReturn);
        break;
}