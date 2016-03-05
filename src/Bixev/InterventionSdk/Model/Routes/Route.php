<?php

namespace Bixev\InterventionSdk\Model\Routes;

class Route extends \Bixev\InterventionSdk\Model\AbstractModel
{
    const IDENTIFIER_INTERVENTION_TYPE_LIST = 'intervention-type.list';
    const IDENTIFIER_INTERVENTION_LIST = 'intervention.list';
    const IDENTIFIER_INTERVENTION_READ = 'intervention.read';
    const IDENTIFIER_INTERVENTION_CREATE = 'intervention.create';
    const IDENTIFIER_INTERVENTION_UPDATE = 'intervention.update';
    const IDENTIFIER_INTERVENTION_REPORT_READ = 'intervention.report.read';
    const IDENTIFIER_INTERVENTION_REPORT_CREATE = 'intervention.report.create';
    const IDENTIFIER_INTERVENTION_REPORT_UPDATE = 'intervention.report.update';
    const IDENTIFIER_AUTOCONFIG = 'autoconfig';
    const IDENTIFIER_SCHEDULE_WIZARD = 'schedule-wizard';

    protected $_routeIdentifiers = [
        self::IDENTIFIER_INTERVENTION_TYPE_LIST,
        self::IDENTIFIER_INTERVENTION_LIST,
        self::IDENTIFIER_INTERVENTION_READ,
        self::IDENTIFIER_INTERVENTION_CREATE,
        self::IDENTIFIER_INTERVENTION_UPDATE,
        self::IDENTIFIER_INTERVENTION_REPORT_READ,
        self::IDENTIFIER_INTERVENTION_REPORT_CREATE,
        self::IDENTIFIER_INTERVENTION_REPORT_UPDATE,
        self::IDENTIFIER_AUTOCONFIG,
        self::IDENTIFIER_SCHEDULE_WIZARD,
    ];

    public $identifier;
    public $method = \Bixev\InterventionSdk\Client\Curl::METHOD_GET;
    public $url;
    public $model;
    public $send_as;

    protected $_properties = ['identifier', 'method', 'url', 'model', 'send_as'];

    protected function checkContent(array $data = null)
    {
        if ($data !== null && $this->identifier === null && !isset($data['identifier'])) {
            throw new \Bixev\InterventionSdk\Exception('required route.identifier');
        }
        if ($data === null && $this->identifier === null) {
            throw new \Bixev\InterventionSdk\Exception('required route.identifier');
        }
        if ($data !== null && $this->identifier === null && array_search($data['identifier'], $this->_routeIdentifiers) === false) {
            throw new \Bixev\InterventionSdk\Exception('invalid route.identifier');
        }
        if ($data === null && array_search($this->identifier, $this->_routeIdentifiers) === false) {
            throw new \Bixev\InterventionSdk\Exception('invalid route.identifier');
        }
    }

}