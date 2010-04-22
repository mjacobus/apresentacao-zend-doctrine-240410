<?php

class AjaxController extends Zend_Controller_Action
{
    
    public function obterCidadesAction()
    {
        $stateID = $this->getRequest()->getParam('estadoID');
        $cities = City::getCitiesByState($stateID);
        $this->_helper->json($cities->toArray());
    }
}

