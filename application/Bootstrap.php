<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Inicia o Doctrine
     * @return Doctrine_Manager
     */
    protected function _initDoctrine()
    {

        $this->getApplication()->getAutoloader()
                ->pushAutoloader(array('Doctrine_Core', 'modelsAutoload'));

        //spl_autoload_register(array('Doctrine', 'autoload'));
        //spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));

        //sfYaml loader, para o doctrine saber como ler os arquivos no formato yaml
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->pushAutoloader(array('Doctrine', 'autoload'));
        $loader->registerNamespace('sfYaml')->pushAutoloader(array('Doctrine', 'autoload'), 'sfYaml');


        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(
                Doctrine_Core::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_CONSERVATIVE
        );
        $manager->setAttribute(
                Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true
        );
        $manager->setAttribute(
                Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, false
        );
        $manager->setAttribute(
                Doctrine_Core::ATTR_VALIDATE, Doctrine_Core::VALIDATE_ALL
        );

        $option = $this->getOption('doctrine');
        $dsn = $option['dsn'];

        $conn = Doctrine_Manager::connection($dsn, 'doctrine');
        $conn->setAttribute(Doctrine_Core::ATTR_USE_NATIVE_ENUM, true);

        //forća utf8
        try {
            $manager->setCollate('utf8_unicode_ci');
            $manager->setCharset('utf8');
            //caso o banco ainda nao tenha sido criado, resulta em uma excecao
            $conn->execute('SET names UTF8');
        }catch(Exception $e) {

        }

        $path = $option['models_path'];
        Doctrine_Core::loadModels($path);
        Doctrine_Core::setModelsDirectory($path);

        return $conn;
    }

}

