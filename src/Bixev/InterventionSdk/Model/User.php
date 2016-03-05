<?php

namespace Bixev\InterventionSdk\Model;

class User extends AbstractModel
{

    public $user_id;
    public $user_email;
    public $user_name;
    protected $_properties = array('user_id', 'user_email', 'user_name');

}