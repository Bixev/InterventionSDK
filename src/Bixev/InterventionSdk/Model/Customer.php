<?php

namespace Bixev\InterventionSdk\Model;

class Customer extends AbstractModel
{

    const CUSTOMER_TYPE_COMPANY = 'company';
    const CUSTOMER_TYPE_INDIVIDUAL = 'individual';

    public $id;
    public $reference;
    public $type;
    public $name;
    public $address;
    public $address_additional;
    public $phone;
    public $mobile;
    public $comment;
    public $email;
    protected $_properties = array('id', 'reference', 'type', 'name', 'address', 'address_additional', 'phone', 'mobile', 'comment', 'email');

}