<?php

namespace Bixev\InterventionSdk\Model\Response\ScheduleWizard;

class ScheduleWizardSlot extends \Bixev\InterventionSdk\Model\Response\AbstractResponse
{
    public $date;
    public $time;
    public $magnetTime;
    public $available = false;
    public $unavailableReason = '';
    public $userId;
    public $relevance;
    public $relevanceClass;

    protected $_properties = array('date', 'time', 'magnetTime', 'available', 'unavailableReason', 'userId', 'relevance', 'relevanceClass');

    protected function checkContent(array $data = null)
    {
        $dateFields = ['date'];
        $this->checkDateFields($dateFields);
    }
}