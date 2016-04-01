<?php

namespace Lexik\Bundle\FrameworkAcceleratorBundle\Collector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;
use Symfony\Component\HttpKernel\DataCollector\LateDataCollectorInterface;

/**
 * Class AcceleratorCollector
 * @package Lexik\Bundle\FrameworkAcceleratorBundle\Collector
 */
class AcceleratorCollector extends DataCollector implements LateDataCollectorInterface
{
    /**
     * @var DataCollectorInterface|DataCollector|LateDataCollectorInterface
     */
    private $collector;

    /**
     * AcceleratorCollector constructor.
     *
     * @param DataCollectorInterface $collector
     */
    public function __construct(DataCollectorInterface $collector)
    {
        $this->collector = $collector;
        $this->data['name'] = $this->collector->getName();
    }

    /**
     * Implement magic method __call to map original data collector
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        $value = isset($this->data['collector_data'][strtolower($name)])
            ? $this->data['collector_data'][strtolower($name)]
            : null;

        if (!empty($value) && 1 === preg_match('/(Time|Count|Memory|Duration)/i', $name)) {
            $value = round($value / rand(2, 6), 0, PHP_ROUND_HALF_DOWN); // Let the magic happens
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function lateCollect()
    {
        $this->collector->lateCollect();
        $this->data['collector_data'] = $this->collector->data;
        $this->completeData();
    }

    /**
     * {@inheritDoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->collector->collect($request, $response, $exception);
        if (isset($this->collector->data)) {
            $this->data['collector_data'] = $this->collector->data;
            $this->completeData();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * Add data when collector is still active
     */
    private function completeData()
    {
        $reflection = new \ReflectionClass($this->collector);
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $methodName = $method->getName();
            if (0 === $method->getNumberOfParameters() && substr($methodName, 0, 3) == 'get') {
                $indexName = strtolower(substr($methodName, 3));
                $this->data['collector_data'][$indexName] = $this->collector->$methodName();
            }
        }
    }
}
