<?php

namespace Bixev\InterventionSdk\Model\Response;

class Interventions extends \Bixev\InterventionSdk\Model\Response\AbstractResponse
{

    protected $_properties = [];

    /**
     * @var \Bixev\InterventionSdk\Model\Interventions
     */
    public $interventions;

    /**
     * @var \Bixev\InterventionSdk\Model\Response\Pagination
     */
    public $pagination;

    /**
     * @var \Bixev\InterventionSdk\Model\Request\Interventions
     */
    public $search;

    public function __construct(array $data = null)
    {
        $this->interventions = new \Bixev\InterventionSdk\Model\Interventions();
        $this->pagination = new \Bixev\InterventionSdk\Model\Response\Pagination();
        parent::__construct($data);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $return = parent::toArray();
        if (!empty($this->interventions)) {
            if (!($this->interventions instanceof \Bixev\InterventionSdk\Model\Interventions)) {
                throw new \Bixev\InterventionSdk\Exception('invalid interventions instance (must be instanceof \Bixev\InterventionSdk\Model\Interventions');
            }
            $return['interventions'] = $this->interventions->toArray();
        }
        if (!empty($this->pagination)) {
            if (!($this->pagination instanceof \Bixev\InterventionSdk\Model\Response\Pagination)) {
                throw new \Bixev\InterventionSdk\Exception('invalid pagination instance (must be instanceof \Bixev\InterventionSdk\Model\Response\Pagination');
            }
            $return['pagination'] = $this->pagination->toArray();
        }
        if (!empty($this->search)) {
            if (!($this->search instanceof \Bixev\InterventionSdk\Model\Request\Interventions)) {
                throw new \Bixev\InterventionSdk\Exception('invalid search instance (must be instanceof \Bixev\InterventionSdk\Model\Request\Interventions');
            }
            $return['search'] = $this->search->toArray();
        }

        return $return;
    }

    public function hydrate(array $data = [])
    {
        parent::hydrate($data);
        if (isset($data['interventions'])) {
            $this->interventions = new \Bixev\InterventionSdk\Model\Interventions();
            if (!is_array($data['interventions'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "interventions"');
            }
            $this->interventions->hydrate($data['interventions']);
        }
        if (isset($data['pagination'])) {
            $this->pagination = new \Bixev\InterventionSdk\Model\Response\Pagination();
            if (!is_array($data['pagination'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "pagination"');
            }
            $this->pagination->hydrate($data['pagination']);
        }
        if (isset($data['search'])) {
            $this->search = new \Bixev\InterventionSdk\Model\Request\Interventions();
            if (!is_array($data['search'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "search"');
            }
            $this->search->hydrate($data['search']);
        }
    }


}