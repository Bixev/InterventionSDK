<?php

namespace Bixev\InterventionSdk\Model\Response;

class Pagination extends AbstractResponse
{
    public $totalcount = 0;
    public $page = 1;
    public $pages = 0;
    public $returned = 0;

    protected $_properties = ['totalcount', 'page', 'pages', 'returned'];

}