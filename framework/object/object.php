<?php
/**
 * User: Oriovaldo Fialho
 * Date: 23/11/16
 * Time: 03:49
 * Abstract: arquivo responsavel resgatar os valores das globais, o unico arquivo que vai interagir com globais
 * neste arquivo pode ser feito tbm os tratamentos para inserção no BD
 */

class object {
    private $object;

    public function __construct()
    {
        if(!empty($_POST)){
            foreach($_POST as $key => $value){
                $this->setField($key,$value);
            }
        }
        if(!empty($_GET)){
            foreach($_GET as $key => $value){
                $this->setField($key,$value);
            }
        }
    }

    public function setField($key,$value)
    {
        $this->object[$key] = $value;
    }

    public function getField($key, $returnNull = false, $type = null)
    {
        $value = $this->object[$key];
        if(empty($value)){
            if(!empty($returnNull) && $type == 'text'){
                $value = '';
            }elseif(!empty($returnNull) && $type == 'int'){
                $value = '0';
            }else{
                $value = '';
            }
        }

        return $value;
    }
}