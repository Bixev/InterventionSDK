<?php
namespace Bixev\InterventionSdk\Traits;

trait ClientTrait
{

    /**
     * @var \Bixev\InterventionSdk\Client\Client
     */
    protected $_client;

    /**
     * @param \Bixev\InterventionSdk\Client\Client $client
     */
    public function setClient(\Bixev\InterventionSdk\Client\Client $client)
    {
        $this->_client = $client;
    }

    /**
     * @return \Bixev\InterventionSdk\Client\Client
     */
    public function getClient()
    {
        return $this->_client;
    }

}