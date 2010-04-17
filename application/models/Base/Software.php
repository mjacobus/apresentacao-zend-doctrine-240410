<?php

/**
 * Base_Software
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $User
 * @property Doctrine_Collection $UserSoftware
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Base_Software extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('software');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'unsigned' => true,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('User', array(
             'refClass' => 'UserSoftware',
             'local' => 'software_id',
             'foreign' => 'user_id'));

        $this->hasMany('UserSoftware', array(
             'local' => 'id',
             'foreign' => 'software_id'));
    }
}