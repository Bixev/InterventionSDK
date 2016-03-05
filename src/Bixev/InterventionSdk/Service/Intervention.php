<?php

namespace Bixev\InterventionSdk\Service;

class Intervention extends AbstractService
{
    public function newSearchInput()
    {
        return new \Bixev\InterventionSdk\Model\Request\Interventions();
    }

    /**
     * @param \Bixev\InterventionSdk\Model\Request\Interventions|null $searchModel
     * @return \Bixev\InterventionSdk\Model\Response\Interventions
     * @throws \Bixev\InterventionSdk\Exception
     */
    public function search(\Bixev\InterventionSdk\Model\Request\Interventions $searchModel = null)
    {
        if ($searchModel === null) {
            $searchModel = new \Bixev\InterventionSdk\Model\Request\Interventions();
        }
        $result = $this->_callClient(\Bixev\InterventionSdk\Model\Routes\Route::IDENTIFIER_INTERVENTION_LIST, $searchModel);
        if (!is_array($result) || !isset($result['result'])) {
            throw new \Bixev\InterventionSdk\Exception('Invalid search response');
        }

        return new \Bixev\InterventionSdk\Model\Response\Interventions($result['result']);
    }

    public function create(\Bixev\InterventionSdk\Model\Intervention $interventionModel)
    {
        $result = $this->_callClient(\Bixev\InterventionSdk\Model\Routes\Route::IDENTIFIER_INTERVENTION_CREATE, $interventionModel);
        if (!is_array($result) || !isset($result['intervention'])) {
            throw new \Bixev\InterventionSdk\Exception('Invalid intervention creation response');
        }

        return new \Bixev\InterventionSdk\Model\Intervention($result['intervention']);
    }

    public function update(\Bixev\InterventionSdk\Model\Intervention $interventionModel)
    {
        if($interventionModel->cref === null){
            throw new \Bixev\InterventionSdk\Exception('Required parameter intervention.cref to update intervention');
        }
        $result = $this->_callClient(\Bixev\InterventionSdk\Model\Routes\Route::IDENTIFIER_INTERVENTION_UPDATE, $interventionModel);
        if (!is_array($result) || !isset($result['intervention'])) {
            throw new \Bixev\InterventionSdk\Exception('Invalid intervention update response');
        }

        return new \Bixev\InterventionSdk\Model\Intervention($result['intervention']);
    }

    public function read(\Bixev\InterventionSdk\Model\Intervention $interventionModel)
    {
        if($interventionModel->cref === null){
            throw new \Bixev\InterventionSdk\Exception('Required parameter intervention.cref to update intervention');
        }
        $result = $this->_callClient(\Bixev\InterventionSdk\Model\Routes\Route::IDENTIFIER_INTERVENTION_READ, $interventionModel);
        if (!is_array($result) || !isset($result['intervention'])) {
            throw new \Bixev\InterventionSdk\Exception('Invalid intervention get response');
        }

        return new \Bixev\InterventionSdk\Model\Intervention($result['intervention']);
    }

}