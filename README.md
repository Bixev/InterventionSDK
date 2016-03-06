# Installation

It's recommended that you use Composer to install InterventionSDK.

```bash
composer require bixev/intervention-sdk "~1.0"
```

This will install SDK and all required dependencies.

so each of your php scripts need to require composer autoload file

```php
<?php

require 'vendor/autoload.php';
```

# Usage

Available services are 

* Intervention (search, create, update, read)
* InterventionType (getAvailable)
* ScheduleWizard (getSlots)

## API init

Initialize api with your access url

```php
$autoconfigUrl = 'https://api.intervention.bixev.com/connectors/XXX/YYYYYYYYY';
```

```php
$bixevInterventionAPI = \Bixev\InterventionSdk\InterventionApi::init($autoconfigUrl);
```

## Intervention service

You can access services directly from the api `$bixevInterventionAPI->services`

```php
$interventionService = $bixevInterventionAPI->services->newServiceIntervention();
```

### Search interventions

Retrieve the `SearchInput` object to set all-what-you-need input parameters

```php
$searchInput = $interventionService->newSearchInput();
$searchInput->status = \Bixev\InterventionSdk\Model\Intervention::STATUS_PENDING;
```

Use the `search` method on the `interventionService` to get your interventions

```php
$result = $interventionService->search($searchInput);
```

Returned result is instance of `\Bixev\InterventionSdk\Model\Response\Interventions`

```php
echo $results->pagination->returned . " results returned\n";
foreach ($results->interventions as $intervention) {
    echo "Intervention cref : " . $intervention->cref . "\n";
}
```

All in one to search interventions :

```php
// initialize api
$autoconfigUrl = 'https://api.intervention.bixev.com/connectors/XXX/YYYYYYYYY';
$bixevInterventionAPI = \Bixev\InterventionSdk\InterventionApi::init($autoconfigUrl);
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
```

### Read/Create/Update intervention

Instanciate new `intervention model`

```php
$intervention = $bixevInterventionAPI->models->newModelIntervention();
```

`cref` field is required (to set or retrieve unique intervention informations), this is `YOUR intervention unique identifier`

```php
$intervention->cref = 'myCustomInterventionReference';
```

#### Read intervention data

```php
$result = $interventionService->read($intervention);
```

_Intervention is find by cref_

#### Create or update intervention

If needed you can instanciate new `customer model`. `customer type/reference` fields are required as unique identifier

```php
$intervention->customer = $bixevInterventionAPI->models->newModelCustomer();
$intervention->customer->type = \Bixev\InterventionSdk\Model\Customer::CUSTOMER_TYPE_COMPANY;
$intervention->customer->reference = 'customerReference';
```

Create :

```php
$result = $interventionService->create($intervention);
```

_If intervention with cref already exists, it is updated_

Update :

```php
$result = $interventionService->update($intervention);
```

_Intervention is find by cref_

Intervention and customer fields are available from corresponding classes. They are :

```
$intervention->cref // unique identifier
$intervention->reference
$intervention->address
$intervention->address_additional
$intervention->comment
$intervention->duration // seconds
$intervention->scheduled_start_at // ISO 8601 format, can be set by $intervention->setScheduledStart($date)
$intervention->custom_fields // associative array of $key => $value additional fields

$customer->reference
$customer->type
$customer->name
$customer->address
$customer->address_additional
$customer->phone
$customer->mobile
$customer->email
$customer->comment
```

## InterventionType service

you can retrieve your available `intervention types`. If you have multiple ones, creating intervention will required which one you want.

```php
$interventionTypeService = $bixevInterventionAPI->services->newServiceInterventionType();
$result = $interventionTypeService->getAvailable();
```

## Schedule wizard service

__To get available assignment slots, use `ScheduleWizard` !!!__

Retrieve the `ScheduleWizardInput` object to set all-what-you-need input parameters

```php
$scheduleWizardService = $bixevInterventionAPI->services->newServiceScheduleWizard();
$scheduleWizardInput = $scheduleWizardService->newWizardInput();
$scheduleWizardInput->address = '7 rue de la Dordogne Toulouse';
```

Use the `getSlots` method on the `scheduleWizardService` to get available slots

```php
$result = $scheduleWizardService->getSlots($scheduleWizardInput);
```

Returned result is instance of `\Bixev\InterventionSdk\Model\Response\ScheduleWizard\ScheduleWizard`

```php
echo count($result) . ' dates returned' . "\n";
echo 'best slot : ';
$bestSlot = $result->getBestSlot();
if ($bestSlot === null) {
    echo "No slot available";
} else {
    echo "Best slot : " . $bestSlot->date;
}
```

Schedule Wizard get options are :

```php
$scheduleWizardInput->address
$scheduleWizardInput->date_min // ISO 8601 format, can be set by $intervention->setDateMin($date)
$scheduleWizardInput->date_max // ISO 8601 format, can be set by $intervention->setDateMax($date)
```

# Log

You can use a logger object within this sdk. It has just to implement `\Bixev\LightLogger\LoggerInterface`

```php
class MyLogger implements \Bixev\LightLogger\LoggerInterface
{
    public function log($log)
    {
        print_r($log);
    }
}
```

Then pass it to your api initialization :

```php
$logger = new MyLogger;
$bixevInterventionAPI = \Bixev\InterventionSdk\InterventionApi::init($autoconfigUrl, $logger);
```

# Override routes

You're able to force routes the sdk use to connect to the api (no use of autoconfig, or override)

Routes are on client level :

```php
$client = $bixevInterventionAPI->getClient();
$routes = $client->getRoutes();
```

So you can simply set your own set of routes. A route must extend `\Bixev\InterventionSdk\Model\Routes\Route`

```php
$route = new \Bixev\InterventionSdk\Model\Routes\Route;
$route->identifier = \Bixev\InterventionSdk\Model\Routes\Route::IDENTIFIER_INTERVENTION_LIST;
$route->method = \Bixev\InterventionSdk\Client\Curl::METHOD_GET;
$route->url = 'http://mycutomdomain/mycutomroute';
$routes[] = $route;
```
