
<style type="text/css">
    input {
        width: 600px;
    }
    pre.command {
        float: right;
        padding: 30px;
    }
    body {
        background:black;
        color:green;
        color:green;
    }
    div.form {
        width:600px;
    }
</style>

<div>
    <h1><?php echo $exception ?></h1>

    <?php echo $trace ?>
    <pre>
    </pre>
</div>

<div align="padding: 50px; width:800px;">
    <div class="form">
        <form method="POST">

            Enviroment: <br />
            <input name="enviroment" type="text" value="<?php echo $_POST['enviroment']?>"/>
            <br />

            Dsn (with no password): <br />
            <input name="dsn" type="text" value="<?php echo $_POST['dsn']?>"/><br />

            Dsn Password: <br />
            <input name="password" type="password"/><br />

            Args: <br />
            <input name="args" type="text" value="<?php echo $_POST['args']?>"/><br />

            <input name="go" type="submit" value="Go!"/>
        </form>
    </div>
    <div>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $post = $_POST;
    define('BASE_PATH', realpath(dirname(__FILE__) . '/../../'));
    define('APPLICATION_PATH', BASE_PATH . '/application');

    // Include path
    set_include_path(
        '.'
        . PATH_SEPARATOR . BASE_PATH . '/library'
        . PATH_SEPARATOR . get_include_path()
    );


    // Define application environment
    define('APPLICATION_ENV', ($post['enviroment']) ? $post['enviroment'] :'development');

    require_once 'Zend/Application.php';
     $application = new Zend_Application(
        APPLICATION_ENV,
        APPLICATION_PATH . '/configs/application.ini'
    );

    $application->bootstrap();

    $config = $application->getOption('doctrine');
    if($post['dsn']) {
        $dsn = $post['dsn'];
        
        if ($post['password']) {
            $parts = explode('@',$post['dsn']);
            $dsn = $parts[0] . ':' . $post['password'] . '@' . $parts[1];
        }
        $config['dsn'] = $dsn;
    }

    
    $cli = new Doctrine_Cli($config);

    require_once 'sfYaml/sfYaml.php';

    try {
        $args = array('doctrine');
        if (count($post['args'])) {
            $argsTmp = explode(" ",$post['args']);
            foreach($argsTmp as $arg) {
                $args[] = trim($arg);
            }
            $args[] =  'force';
        }
        echo '<pre>';
        $cli->run($args);
        echo "</pre>";
    } catch(Exception $e) {
        $exception =  $e->getMessage();
        $trace = $e->getTrace();
        echo "</pre>";
    }


}//if post

?>
    </div>
</div>