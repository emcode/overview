<?php

namespace Simplercode\Overview\Renderer\Extension;

trait ServiceLocatorTrait
{
    /**
     * @var \ArrayAccess
     */
    protected $serviceLocator;

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        if (null === $this->serviceLocator)
        {
            throw new \RuntimeException('ServiceLocator has to be set to use "has" method on renderer!');
        }

        return isset($this->serviceLocator[$name]);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        if (null === $this->serviceLocator)
        {
            throw new \RuntimeException('ServiceLocator has to be set to use "get" method on renderer!');
        }

        $something = $this->serviceLocator[$name];
        return $something;
    }

    /**
     * @return \ArrayAccess
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param \ArrayAccess $serviceLocator
     * @return $this
     */
    public function setServiceLocator(\ArrayAccess $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAnyServiceLocator()
    {
        return (null !== $this->serviceLocator);
    }
}