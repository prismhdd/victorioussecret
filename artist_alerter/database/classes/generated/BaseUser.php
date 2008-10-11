<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseUser extends Doctrine_Record
{
  public function setTableDefinition()
  {
    $this->setTableName('users');
    $this->hasColumn('user_id', 'integer', 8, array('type' => 'integer', 'length' => 8, 'primary' => true, 'sequence' => 'user'));
    $this->hasColumn('email_address', 'string', 100, array('type' => 'string', 'length' => '100', 'notnull' => true));
    $this->hasColumn('password', 'string', null, array('type' => 'string', 'fixed' => true, 'notnull' => true));
    $this->hasColumn('first_name', 'string', 50, array('type' => 'string', 'length' => '50', 'notnull' => true));
    $this->hasColumn('last_name', 'string', 50, array('type' => 'string', 'length' => '50'));
  }

}