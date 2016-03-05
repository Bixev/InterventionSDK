<?php

namespace Bixev\InterventionSdk\Service;

class InterventionType extends AbstractService
{

    /**
     * @param \Bixev\InterventionSdk\Model\Request\Interventions|null $searchModel
     * @return \Bixev\InterventionSdk\Model\Response\Interventions
     * @throws \Bixev\InterventionSdk\Exception
     */
    public function getAvailable()
    {
        $result = $this->_callClient(\Bixev\InterventionSdk\Model\Routes\Route::IDENTIFIER_INTERVENTION_TYPE_LIST);
        if (!is_array($result) || !isset($result['interventionTypes'])) {
            throw new \Bixev\InterventionSdk\Exception('Invalid get response');
        }

        return new \Bixev\InterventionSdk\Model\InterventionTypes($result['interventionTypes']);
    }


}