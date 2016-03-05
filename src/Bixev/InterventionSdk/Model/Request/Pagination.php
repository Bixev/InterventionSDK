<?php

namespace Bixev\InterventionSdk\Model\Request;

class Pagination extends AbstractRequest
{
    public $limit = 10;
    public $page = 1;

    protected $_properties = ['limit', 'page'];

}