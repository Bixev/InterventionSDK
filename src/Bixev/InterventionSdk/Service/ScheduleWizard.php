<?php

namespace Bixev\InterventionSdk\Service;

class ScheduleWizard extends AbstractService
{
    public function newWizardInput()
    {
        return new \Bixev\InterventionSdk\Model\Request\ScheduleWizard();
    }

    public function getSlots(\Bixev\InterventionSdk\Model\Request\ScheduleWizard $scheduleWizardInput)
    {
        if ($scheduleWizardInput->address === null) {
            throw new \Bixev\InterventionSdk\Exception('Required address for schedule wizard request');
        }
        $result = $this->_callClient(\Bixev\InterventionSdk\Model\Routes\Route::IDENTIFIER_SCHEDULE_WIZARD, $scheduleWizardInput);
        if (!is_array($result) || !isset($result['result'])) {
            throw new \Bixev\InterventionSdk\Exception('Invalid schedule wizard response');
        }

        return new \Bixev\InterventionSdk\Model\Response\ScheduleWizard\ScheduleWizard($result['result']);

    }

}