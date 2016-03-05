<?php

namespace Bixev\InterventionSdk\Model\Response\ScheduleWizard;

class ScheduleWizardDate extends \Bixev\InterventionSdk\Model\AbstractCollection
{
    public $date;
    protected $_properties = array('date');

    /**
     * @return ScheduleWizardSlot
     */
    public function offsetGet($offset)
    {
        return parent::offsetGet($offset);
    }

    /**
     * @return ScheduleWizardSlot
     */
    public function current()
    {
        return parent::current();
    }

    public function offsetSet($offset, $value)
    {
        if (!($value instanceof ScheduleWizardSlot)) {
            throw new \Bixev\InterventionSdk\Exception('trying to set non valid element');
        }
        parent::offsetSet($offset, $value);
    }

    public function hydrate(array $data = array())
    {
        if (isset($data['date'])) {
            $this->date = $data['date'];
        }
        foreach ($data['slots'] as $value) {
            $slot = new ScheduleWizardSlot();
            $slot->hydrate($value);
            $this[] = $slot;
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $return = array(
            'slots' => array(),
        );
        if ($this->date !== null) {
            $return['date'] = $this->date;
        }
        foreach ($this as $data) {
            $return['slots'][] = $data->toArray();
        }
        return $return;
    }

    protected function checkContent(array $data = null)
    {
        $dateFields = ['date'];
        $this->checkDateFields($dateFields);
    }

}