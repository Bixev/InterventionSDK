<?php

namespace Bixev\InterventionSdk\Model\Response\ScheduleWizard;

class ScheduleWizard extends \Bixev\InterventionSdk\Model\AbstractCollection
{

    /**
     * @return ScheduleWizardDate
     */
    public function offsetGet($offset)
    {
        return parent::offsetGet($offset);
    }

    /**
     * @return ScheduleWizardDate
     */
    public function current()
    {
        return parent::current();
    }

    public function offsetSet($offset, $value)
    {
        if (!($value instanceof ScheduleWizardDate)) {
            throw new \Bixev\InterventionSdk\Exception('trying to set non valid element');
        }
        parent::offsetSet($offset, $value);
    }

    public function hydrate(array $data = [])
    {
        foreach ($data['dates'] as $value) {
            $date = new ScheduleWizardDate();
            $date->hydrate($value);
            $this[] = $date;
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $return = [
            'dates' => [],
        ];
        foreach ($this as $data) {
            $return['dates'][] = $data->toArray();
        }

        return $return;
    }

    public function getBestSlot()
    {
        $bestSlot = null;
        $relevance = 0;
        foreach ($this as $date) {
            foreach ($date as $slot) {
                if ($slot->available && $slot->relevance > $relevance) {
                    $bestSlot = $slot;
                    $relevance = $slot->relevance;
                }
            }
        }

        return $bestSlot;
    }
}