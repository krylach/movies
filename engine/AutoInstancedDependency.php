<?php

namespace Engine;
use Symfony\Component\HttpFoundation\Request;

class AutoInstancedDependency
{
    const FIND_OF_MODEL_METHOD = 'find';

    private \ReflectionMethod $method;
    private array $data = [];

    public function __construct(\ReflectionMethod $method, array &$data)
    {
        $this->method = $method;
        $this->data = $data;
    }

    private function scanParameter(\ReflectionParameter $parameter)
    {
        if (!$parameter->hasType()) {
            return false;
        }
        
        $class = $parameter->getType();
        $class = "$class";

        if (!class_exists($class)) {
            return false;
        }

        if ($class === Request::class) {
            return Request::createFromGlobals();
        }

        if (get_parent_class($class) === Model::class) {
            $dependyValues = [];
            if (isset($this->data[$parameter->getName()])) {
                $dependyValues[] = $this->data[$parameter->getName()];
                unset($this->data[$parameter->getName()]);
            }
            
            if (!empty($dependyValues)) {
                $model = call_user_func_array([$class, self::FIND_OF_MODEL_METHOD], $dependyValues);
                
                if ($model) {
                    return $model;
                }
            }
        }
        
        return new $class;
    }

    /**
     * @param \ReflectionParameter $parameter
     */
    public function execute(): Collection
    {
        $collection = collect([]);
        if (!$this->method->getParameters()) {
            return $collection;
        }

        foreach ($this->method->getParameters() as $parameter) {
            if ($element = $this->scanParameter($parameter)) {
                $collection->add($element);
            }
        }

        return $collection;
    }
}
