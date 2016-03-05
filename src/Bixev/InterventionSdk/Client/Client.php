<?php

namespace Bixev\InterventionSdk\Client;

class Client
{

    use \Bixev\InterventionSdk\Traits\LoggerTrait;

    /**
     * @var string|null
     */
    protected $_autoconfigUrl;

    /**
     * @var \Bixev\InterventionSdk\Model\Routes\Routes
     */
    protected $_routes;

    public function __construct($autoconfigUrl = null, \Bixev\InterventionSdk\Logger\LoggerInterface $logger = null)
    {
        $this->_autoconfigUrl = $autoconfigUrl;
        $this->_routes = new \Bixev\InterventionSdk\Model\Routes\Routes();
        $this->setLogger($logger);
    }

    public function setAutoconfigUrl($autoconfigUrl)
    {
        $this->_autoconfigUrl = $autoconfigUrl;
    }

    protected function processAutoConfig()
    {
        if ($this->_autoconfigUrl === null) {
            throw new \Bixev\InterventionSdk\Exception('No autoconfigUrl given');
        }
        $this->log('*** Processing autoconfig ***');
        $this->log('Given url : ' . $this->_autoconfigUrl);

        $curlClient = new \Bixev\InterventionSdk\Client\Curl($this->_autoconfigUrl, \Bixev\InterventionSdk\Client\Curl::METHOD_GET, [], [], $this->_logger);
        $response = $curlClient->exec();

        $this->log('Autoconfig response :');
        $this->log($response);

        if (!is_array($response) || !isset($response['routes'])) {
            throw new \Bixev\InterventionSdk\Exception('Invalid autoconfig response');
        }
        foreach ($response['routes'] as $identifier => $route) {
            try {
                $routeModel = new \Bixev\InterventionSdk\Model\Routes\Route();
                $routeModel->identifier = $identifier;
                $routeModel->hydrate($route);
                $this->_routes[] = $routeModel;
            } catch (\Exception $e) {
                // silent error : do not add invalid route
            }
        }

        $this->log('Autoconfig processed ' . count($this->_routes) . ' routes');

    }

    protected function getRoute($routeIdentifier)
    {
        if (count($this->_routes) == 0) {
            $this->processAutoConfig();
        }
        $route = $this->_routes->findByIdentifier($routeIdentifier);
        if ($route === null) {
            throw new \Bixev\InterventionSdk\Exception('Forbidden route with identifier "' . $routeIdentifier . '"');
        }

        return $route;
    }

    /**
     * @param $routeIdentifier
     * @param \Bixev\InterventionSdk\Model\AbstractModel|null $model
     * @return mixed
     * @throws \Bixev\InterventionSdk\Exception
     */
    public function call($routeIdentifier, \Bixev\InterventionSdk\Model\AbstractModel $model = null)
    {
        $this->log('*** Client call ***');
        $this->log('Route identifier : ' . $routeIdentifier);
        $this->log('Model : ' . ($model !== null ? $model->getIdentifier() : 'none'));

        $route = $this->getRoute($routeIdentifier);

        if ($model !== null) {
            $model->replaceRouteFields($route);
        }

        $fields = [];
        if ($route->model !== null) {
            if (
                $model === null
                || $route->model != $model->getIdentifier()
            ) {
                throw new \Bixev\InterventionSdk\Exception('Route identified by "' . $route->identifier . '" requires sending model "' . $route->model . '"');
            }
            if ($route->send_as !== null) {
                $fields[$route->send_as] = $model->toArray();
            } else {
                $fields = $model->toArray();
            }
        }
        $curlClient = new \Bixev\InterventionSdk\Client\Curl($route->url, $route->method, [], $fields, $this->_logger);
        $response = $curlClient->exec();
        $this->log('Api response :');
        $this->log($response);

        return $response;
    }

    /**
     * @return \Bixev\InterventionSdk\Model\Routes\Routes
     */
    public function getRoutes()
    {
        return $this->_routes;
    }

}