<?php

namespace Simplercode\Overview\Renderer\Extension;

use Simplercode\Overview\Model;

trait LayoutTrait
{
    /**
     * Model which describes how to render layout, action result
     * will be wrapped inside layout model by default
     * @var Model
     */
    protected $layoutModel;

    /**
     * Variable name which will be available in layout
     * and will contain rendered content of action
     * @var string
     */
    protected $actionModelName = 'content';

    /**
     * Wraps action model in layout model and renders everything
     * @param array|Model $actionResult
     * @return string
     */
    public function action($actionResult)
    {
        if (null === $this->layoutModel)
        {
            throw new \RuntimeException(sprintf('Layout model has to be set before usage of "%s" method on %s!', __METHOD__, __CLASS__));
        }

        $actionModel = $this->prepareActionModelFromActionResult($actionResult);
        $this->layoutModel->addChildren($this->actionModelName, $actionModel);
        $content = $this->render($this->layoutModel);
        return $content;
    }

    /**
     * @param $actionResult
     * @return Model
     */
    public function prepareActionModelFromActionResult($actionResult)
    {
        if (is_array($actionResult))
        {
            if (!isset($actionResult['template']))
            {
                throw new \InvalidArgumentException(sprintf('Array returned from action have to have "template" index set! Available indexes: %s', implode(', ', array_keys($actionResult))));
            }

            $actionModel = new Model($actionResult['template'], $actionResult);

        } elseif ($actionResult instanceof Model)
        {
            $actionModel = $actionResult;

        } else
        {
            $type = is_object($actionResult) ? get_class($actionResult) : gettype($actionResult);
            throw new \InvalidArgumentException(sprintf('Value returned from action have to be array or Model instance, received: %s', $type));
        }

        return $actionModel;
    }

    /**
     * @return Model
     */
    public function getLayoutModel()
    {
        return $this->layoutModel;
    }

    /**
     * @param Model $layoutModel
     * @return $this
     */
    public function setLayoutModel(Model $layoutModel)
    {
        $this->layoutModel = $layoutModel;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAnyLayoutModel()
    {
        return (null !== $this->layoutModel);
    }
}