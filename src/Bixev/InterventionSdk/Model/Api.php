<?php

namespace Bixev\InterventionSdk\Model;

class Api
{

    use \Bixev\LightLogger\LoggerTrait;
    use \Bixev\InterventionSdk\Traits\ClientTrait;

    public function __construct($client = null, \Bixev\LightLogger\LoggerInterface $logger = null)
    {
        $this->setClient($client);
        $this->setLogger($logger);
    }

    public function newModelIntervention()
    {
        return new Intervention();
    }

    public function newModelCustomer()
    {
        return new Customer();
    }

}