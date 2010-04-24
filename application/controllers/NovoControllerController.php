<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NovoControllerController
 *
 * @author marcelo
 */
class NovoControllerController  extends Zend_Controller_Action {
    //put your code here

   public function mensagemAction()
    {
       $nome =  $this->getRequest()->getParam('nome', false);
       $sobrenome = $this->getRequest()->getParam('sobrenome', 'marcelo');
        $mensagem = 'Ola ' . $nome . ' ' . $sobrenome .  ', tudo bem?';

        $this->view->mensagem = $mensagem;
       
   }

}