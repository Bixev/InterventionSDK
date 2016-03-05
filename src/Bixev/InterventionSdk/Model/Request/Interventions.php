<?php

namespace Bixev\InterventionSdk\Model\Request;

class Interventions extends AbstractRequest
{
    const MODEL_IDENTIFIER = 'intervention.search';

    /**
     * @var mixed : string or array of strings
     */
    public $cref;

    /**
     * @var mixed : string or array of strings
     */
    public $reference;
    public $light_model = true;

    /**
     * @var \Bixev\InterventionSdk\Model\Request\Pagination
     */
    public $pagination;

    /**
     * @var \Bixev\InterventionSdk\Model\InterventionTypes
     */
    public $intervention_types;

    /**
     * @var string date (ISO 8601) eg : 2004-02-12T15:19:21+00:00
     */
    public $scheduled_start_at_min;

    /**
     * @var string date (ISO 8601) eg : 2004-02-12T15:19:21+00:00
     */
    public $scheduled_start_at_max;

    /**
     * @var string date (ISO 8601) eg : 2004-02-12T15:19:21+00:00
     */
    public $appointment_at_min;

    /**
     * @var string date (ISO 8601) eg : 2004-02-12T15:19:21+00:00
     */
    public $appointment_at_max;

    public $without_scheduled_start;
    public $without_appointment;

    /**
     * @var string @see \Bixev\InterventionSdk\Model\Intervention::STATUS_ ...
     */
    public $status;

    protected $_properties = ['cref', 'light_model', 'reference', 'scheduled_start_at_min', 'scheduled_start_at_max', 'appointment_at_min', 'appointment_at_max', 'status', 'intervention_types', 'without_scheduled_start', 'without_appointment'];

    public function __construct(array $data = null)
    {
        $this->pagination = new Pagination;
        parent::__construct($data);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $return = parent::toArray();
        if (!empty($this->intervention_types)) {
            if (!($this->intervention_types instanceof \Bixev\InterventionSdk\Model\InterventionTypes)) {
                throw new \Bixev\InterventionSdk\Exception('invalid intervention_types instance (must be instanceof \Bixev\InterventionSdk\Model\InterventionTypes');
            }
            $return['intervention_types'] = $this->intervention_types->toArray();
        }
        $return['pagination'] = $this->pagination->toArray();

        return $return;
    }

    public function hydrate(array $data = [])
    {
        parent::hydrate($data);
        if (isset($data['intervention_types'])) {
            $this->intervention_types = new \Bixev\InterventionSdk\Model\InterventionTypes();
            if (!is_array($data['intervention_types'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "intervention_types"');
            }
            $this->intervention_types->hydrate($data['intervention_types']);
        }
        if (isset($data['pagination'])) {
            if (!is_array($data['pagination'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "pagination"');
            }
            $this->pagination->hydrate($data['pagination']);
        } else {
            if (isset($data['page'])) {
                $this->pagination->page = $data['page'];
            }
            if (isset($data['limit'])) {
                $this->pagination->limit = $data['limit'];
            }
        }
    }

    protected function checkContent(array $data = null)
    {
        $dateFields = ['scheduled_start_at_min', 'scheduled_start_at_max', 'appointment_at_min', 'appointment_at_max'];
        $this->checkDateFields($dateFields);

        $stringOrStringArrays = ['cref', 'reference', 'status'];
        foreach ($stringOrStringArrays as $stringOrStringArray) {
            if (isset($data[$stringOrStringArray]) && is_array($data[$stringOrStringArray])) {
                foreach ($data[$stringOrStringArray] as $val) {
                    if (!is_string($val)) {
                        throw new \Bixev\InterventionSdk\Exception($stringOrStringArray . ' must be string typed');
                    }
                }
            }
            if ($this->$stringOrStringArray !== null && is_array($this->$stringOrStringArray)) {
                foreach ($this->$stringOrStringArray as $val) {
                    if (!is_string($val)) {
                        throw new \Bixev\InterventionSdk\Exception($stringOrStringArray . ' must be string typed');
                    }
                }
            }
        }

    }

}