<?php

namespace Simplercode\Overview;

class Model
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    protected $variables;

    /**
     * @var Model[]
     */
    protected $children;

    /**
     * @param null $template alias of template, alias have to be registered in Renderer
     * @param array $variables Variables which will be available during template rendering
     */
    public function __construct($template = null, array $variables = null)
    {
        $this->children = array();

        if (null !== $template)
        {
            $this->template = $template;
        }

        if (null !== $variables)
        {
            $this->variables = $variables;
        }
    }

    /**
     * @return string|null
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string|null $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAnyTemplate()
    {
        return (null !== $this->template);
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param array $variables
     * @return $this
     */
    public function setVariables($variables)
    {
        $this->variables = $variables;
        return $this;
    }

    /**
     * @param $name string
     * @param $value mixed
     * @return $this
     */
    public function setVariable($name, $value)
    {
        $this->variables[$name] = $value;
        return $this;
    }

    /**
     * @param $name string
     * @return $this
     */
    public function unsetVariable($name)
    {
        unset($this->variables[$name]);
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAnyVariables()
    {
        return !empty($this->variables);
    }

    /**
     * @param $name
     * @param Model $childModel
     * @return $this
     */
    public function addChild($name, Model $childModel)
    {
        if (isset($this->children[$name]))
        {
            throw new \InvalidArgumentException(sprintf('Children view model with name "%s" cannot be added, it already exists!',  $name));
        }

        $this->children[$name] = $childModel;
        return $this;
    }

    /**
     * @param $name
     * @param Model $childModel
     * @return $this
     */
    public function setChild($name, Model $childModel)
    {
        $this->children[$name] = $childModel;
        return $this;
    }
    
    /**
     * @return Model[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Model[] $children
     * @return $this
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAnyChildren()
    {
        return !empty($this->children);
    }

    /**
     * @param $name
     * @return Model
     */
    public function removeChildByName($name)
    {
        if (!isset($this->children[$name]))
        {
            throw new \InvalidArgumentException(sprintf('Children view model with name "%s" cannot be removed, it does not exist!',  $name));
        }

        $child = $this->children[$name];
        unset($this->children[$name]);
        return $child;
    }


    /**
     * @param $name
     * @return Model
     */
    public function getChildByName($name)
    {
        if (!isset($this->children[$name]))
        {
            throw new \InvalidArgumentException(sprintf('Children view model with name "%s" cannot be retrieved, it does not exist!',  $name));
        }

        return $this->children[$name];
    }
}