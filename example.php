<?php
// ASSUMING COMPOSER AUTOLOADING IS USED HERE
// (no need to require anything by hand)



// API INIT

$autoconfigUrl = 'https://api.intervention.bixev.com/connectors/XXX/YYYYYYYYY';
$bixevInterventionAPI = \Bixev\InterventionSdk\InterventionApi::init($autoconfigUrl);



// SEARCH INTERVENTIONS

// get service
$interventionService = $bixevInterventionAPI->services->newServiceIntervention();
// get input
$searchInput = $interventionService->newSearchInput();
$searchInput->status = \Bixev\InterventionSdk\Model\Intervention::STATUS_PENDING;
// call method
$result = $interventionService->search($searchInput);
// process results
echo $results->pagination->returned . " results returned\n";
foreach ($results->interventions as $intervention) {
    echo "Intervention cref : " . $intervention->cref . "\n";
}



// CREATE INTERVENTION

$intervention = $bixevInterventionAPI->models->newModelIntervention();
$intervention->cref = 'myNewCustomInterventionReference';
$intervention->address = 'Toulouse';
$intervention->customer = $bixevInterventionAPI->models->newModelCustomer();
$intervention->customer->type = \Bixev\InterventionSdk\Model\Customer::CUSTOMER_TYPE_COMPANY;
$intervention->customer->name = 'my best customer';
$intervention->customer->reference = 'customerReference';
$result = $interventionService->create($intervention);



// UPDATE INTERVENTION

$intervention = $bixevInterventionAPI->models->newModelIntervention();
$intervention->cref = 'myNewCustomInterventionReference';
$intervention->address = 'Paris';
$result = $interventionService->update($intervention);



// GET INTERVENTION

$intervention = $bixevInterventionAPI->models->newModelIntervention();
$intervention->cref = 'myCustomInterventionReference';
$result = $interventionService->read($intervention);



// GET AVAILABLE INTERVENTION TYPES

$interventionTypeService = $bixevInterventionAPI->services->newServiceInterventionType();
$result = $interventionTypeService->getAvailable();



// GET AVAILABLE ASSIGNMENT SLOTS

$scheduleWizardService = $bixevInterventionAPI->services->newServiceScheduleWizard();
$scheduleWizardInput = $scheduleWizardService->newWizardInput();
$scheduleWizardInput->address = '7 rue de la Dordogne Toulouse';
$result = $scheduleWizardService->getSlots($scheduleWizardInput);
echo count($result) . ' dates returned' . "\n";
echo 'best slot : ';
$bestSlot = $result->getBestSlot();
if ($bestSlot === null) {
    echo "No slot available";
} else {
    echo "Best slot : " . $bestSlot->date;
}
