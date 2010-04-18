<?php

/**
 * User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class User extends Base_User
{
    /**
     * Constante que define a url de edicao de um registro User
     */
    const URL_EDIT =  '/cadastro/editar/id/';
    
    /**
     * Constante que define a url de exclusao de um registro User
     */
    const URL_DEL =  '/cadastro/excluir/id/';


    /**
     * Retorna a url de edicao de um vivente
     * @return string
     */
    public function getEditUrl()
    {
        return self::URL_EDIT . $this->id;
    }

    /**
     * Retorna a url de edicao de um vivente
     * @return string
     */
    public function getDeleteUrl()
    {
        return self::URL_DEL . $this->id;
    }

    /**
     * Seta a data de nascimento no formato do banco
     * @param string $value
     */
    public function setBirthday($value)
    {
        $date = new Zend_Date($value, 'dd/MM/YYYY');
        $this->_set('birthday', $date->toString('YYYY-MM-dd'));
    }
    /**
     * Retorna a string no formato dd/mm/yyyy
     * @return string
     */
    public function getBirthday()
    {
        $date = new Zend_Date($this->_get('birthday'),  'YYYY-MM-dd');
        return $date->toString('dd/MM/YYYY');
    }


}