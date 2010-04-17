<?php 
 
class Zend_View_Helper_BaseUrl 
{
    /**
     *
     * @param string $url
     * @return string
     */
    function baseUrl($url = '')
    { 
        $fc = Zend_Controller_Front::getInstance();
        return $fc->getBaseUrl() . $url;
    } 
} 