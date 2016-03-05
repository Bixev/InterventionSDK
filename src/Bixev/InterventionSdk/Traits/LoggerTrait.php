<?php
namespace Bixev\InterventionSdk\Traits;

trait LoggerTrait
{

    /**
     * @var \Bixev\InterventionSdk\Logger\LoggerInterface
     */
    protected $_logger;

    /**
     * @param \Bixev\InterventionSdk\Logger\LoggerInterface $logger
     */
    public function setLogger(\Bixev\InterventionSdk\Logger\LoggerInterface $logger = null)
    {
        $this->_logger = $logger;
    }

    /**
     * @param mixed $log
     */
    protected function log($log)
    {
        if ($this->_logger !== null) {
            $this->_logger->log($log);
        }
    }

}