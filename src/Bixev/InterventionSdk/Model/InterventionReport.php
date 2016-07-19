<?php

namespace Bixev\InterventionSdk\Model;

class InterventionReport extends AbstractModel
{
    const MODEL_IDENTIFIER = 'intervention.report';
    const STATUS_OK = 'ok';
    const STATUS_KO = 'ko';
    static protected $STATUS_ALLOWED = [
        self::STATUS_OK,
        self::STATUS_KO,
    ];

    public $reported_at;
    public $comment;
    public $status;
    public $start_at;
    public $end_at;
    public $pdf_b64;
    public $withPdf;

    protected $_properties = array('comment', 'status', 'reported_at', 'start_at', 'end_at', 'pdf_b64', 'withPdf');

    /**
     * @var Intervention
     */
    public $intervention;

    /**
     * @var InterventionReportCustomFields
     */
    public $custom_fields;

    /**
     * @return array
     */
    public function toArray()
    {
        $return = parent::toArray();
        if ($this->intervention !== null) {
            if (!($this->intervention instanceof Intervention)) {
                throw new \Bixev\InterventionSdk\Exception('invalid intervention instance (must be instanceof \Bixev\InterventionSdk\Intervention');
            }
            $return['intervention'] = $this->intervention->toArray();
        }
        if ($this->custom_fields !== null) {
            if (!($this->custom_fields instanceof InterventionReportCustomFields)) {
                throw new \Bixev\InterventionSdk\Exception('invalid custom_fields instance (must be instanceof \Bixev\InterventionSdk\InterventionReportCustomFields');
            }
            $return['custom_fields'] = $this->custom_fields->toArray();
        }

        return $return;
    }

    public function hydrate(array $data = array())
    {
        parent::hydrate($data);
        if (isset($data['intervention'])) {
            $this->intervention = new Intervention;
            if (!is_array($data['intervention'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "intervention"');
            }
            $this->intervention->hydrate($data['intervention']);
        }
        if (isset($data['custom_fields'])) {
            $this->custom_fields = new InterventionReportCustomFields;
            if (!is_array($data['custom_fields'])) {
                throw new \Bixev\Rest\Exception\Rest\E400BadRequest('Invalid parameter "custom_fields"');
            }
            $this->custom_fields->hydrate($data['custom_fields']);
        }
    }

    protected function checkContent(array $data = null)
    {
        if (isset($data['status']) && !in_array($data['status'], static::$STATUS_ALLOWED)) {
            throw new \Bixev\Rest\Exception\Rest\E400BadRequest(
                'Invalid parameter "status", has to be one of' . implode(',', static::$STATUS_ALLOWED)
            );
        }
    }
}