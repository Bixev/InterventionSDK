<?php

namespace Bixev\InterventionSdk\Model;

class Intervention extends AbstractModel
{
    const MODEL_IDENTIFIER = 'intervention';
    const STATUS_PENDING = 'pending';
    const STATUS_AUTOASSIGN_PENDING = 'autoassign_pending';
    const STATUS_CANCELED = 'canceled';
    const STATUS_TERMINATED = 'terminated';

    public $id;
    public $cref;
    public $is_light_model;
    public $reference;
    public $title;
    public $address;
    public $address_additional;
    public $priority;
    public $pdf_b64;

    /**
     * @var int duration in seconds
     */
    public $duration;

    /**
     * @var string date (ISO 8601) eg : 2004-02-12T15:19:21+00:00
     */
    public $scheduled_start_at;

    /**
     * @var string date (ISO 8601) eg : 2004-02-12T15:19:21+00:00
     */
    public $scheduled_end_at;

    /**
     * @var string date (ISO 8601) eg : 2004-02-12T15:19:21+00:00
     */
    public $appointment_at;
    public $comment;
    public $status = self::STATUS_PENDING;

    protected $_properties = ['id', 'cref', 'is_light_model', 'reference', 'title', 'address', 'address_additional', 'priority', 'duration', 'scheduled_start_at', 'scheduled_end_at', 'appointment_at', 'comment', 'status', 'pdf_b64'];

    /**
     * @var InterventionType
     */
    public $intervention_type;

    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var InterventionAssignments
     */
    public $assignments;

    /**
     * @var InterventionReport
     */
    public $report;

    /**
     * @var InterventionCustomFields
     */
    public $custom_fields;

    /**
     * @return array
     */
    public function toArray()
    {
        $return = parent::toArray();
        if (!empty($this->intervention_type)) {
            if (!($this->intervention_type instanceof InterventionType)) {
                throw new \Bixev\InterventionSdk\Exception('invalid intervention_type instance (must be instanceof \Bixev\InterventionSdk\InterventionType');
            }
            $return['intervention_type'] = $this->intervention_type->toArray();
        }
        if (!empty($this->customer)) {
            if (!($this->customer instanceof Customer)) {
                throw new \Bixev\InterventionSdk\Exception('invalid customer instance (must be instanceof \Bixev\InterventionSdk\Customer');
            }
            $return['customer'] = $this->customer->toArray();
        }
        if (!empty($this->assignments)) {
            if (!($this->assignments instanceof InterventionAssignments)) {
                throw new \Bixev\InterventionSdk\Exception('invalid assignments instance (must be instanceof \Bixev\InterventionSdk\InterventionAssignments');
            }
            $return['assignments'] = $this->assignments->toArray();
        }
        if (!empty($this->report)) {
            if (!($this->report instanceof InterventionReport)) {
                throw new \Bixev\InterventionSdk\Exception('invalid report instance (must be instanceof \Bixev\InterventionSdk\InterventionReport');
            }
            $return['report'] = $this->report->toArray();
        }
        if (!empty($this->custom_fields)) {
            if (!($this->custom_fields instanceof InterventionCustomFields)) {
                throw new \Bixev\InterventionSdk\Exception('invalid custom_fields instance (must be instanceof \Bixev\InterventionSdk\InterventionCustomFields');
            }
            $return['custom_fields'] = $this->custom_fields->toArray();
        }

        return $return;
    }

    public function hydrate(array $data = [])
    {
        parent::hydrate($data);
        if (isset($data['intervention_type'])) {
            $this->intervention_type = new InterventionType;
            if (!is_array($data['intervention_type'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "intervention_type"');
            }
            $this->intervention_type->hydrate($data['intervention_type']);
        }
        if (isset($data['customer'])) {
            $this->customer = new Customer;
            if (!is_array($data['customer'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "customer"');
            }
            $this->customer->hydrate($data['customer']);
        }
        if (isset($data['assignments'])) {
            $this->assignments = new InterventionAssignments;
            if (!is_array($data['assignments'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "assignments"');
            }
            $this->assignments->hydrate($data['assignments']);
        }
        if (isset($data['report'])) {
            $this->report = new InterventionReport;
            if (!is_array($data['report'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "report"');
            }
            $this->report->hydrate($data['report']);
        }
        if (isset($data['custom_fields'])) {
            $this->custom_fields = new InterventionCustomFields;
            if (!is_array($data['custom_fields'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "custom_fields"');
            }
            $this->custom_fields->hydrate($data['custom_fields']);
        }
    }

    protected function checkContent(array $data = null)
    {
        $dateFields = ['scheduled_start_at', 'scheduled_end_at', 'appointment_at'];
        $this->checkDateFields($dateFields);
    }

    public function replaceRouteFields(Routes\Route $route)
    {
        $url = $route->url;
        if ($this->cref !== null) {
            $url = str_replace(':interventionId', $this->cref, $url);
        }

        $route->url = $url;
    }

    public function setScheduledStart(\DateTime $date)
    {
        $this->scheduled_start_at = $date->format('c');
    }

    public function setScheduledEnd(\DateTime $date)
    {
        $this->scheduled_end_at = $date->format('c');
    }

    public function setScheduledAppointment(\DateTime $date)
    {
        $this->appointment_at = $date->format('c');
    }
}