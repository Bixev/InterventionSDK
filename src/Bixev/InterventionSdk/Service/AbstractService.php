<?php

namespace Bixev\InterventionSdk\Service;

abstract class AbstractService
{

    /**
     * @var \Bixev\InterventionSdk\Client\Client
     */
    protected $_client;

    /**
     * @param \Bixev\InterventionSdk\Client\Client $client
     */
    public function __construct(\Bixev\InterventionSdk\Client\Client $client = null)
    {
        if ($client !== null) {
            $this->setClient($client);
        }
    }

    /**
     * @param \Bixev\InterventionSdk\Client\Client $client
     */
    public function setClient(\Bixev\InterventionSdk\Client\Client $client)
    {
        $this->_client = $client;
    }

    protected function _callClient($routeIdentifier, \Bixev\InterventionSdk\Model\AbstractModel $model = null)
    {
        if ($this->_client === null) {
            throw new \Bixev\InterventionSdk\Exception('Client not set');
        }

        return $this->_client->call($routeIdentifier, $model);
    }
}