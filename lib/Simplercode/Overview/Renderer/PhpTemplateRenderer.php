<?php

namespace Simplercode\Overview\Renderer;

use Simplercode\Overview\Model;

class PhpTemplateRenderer
{
    /**
     * @var array
     */
    protected $templateMap;

    /**
     * @param array $templateMap
     */
    public function __construct(array $templateMap = null)
    {
        if (null !== $templateMap)
        {
            $this->templateMap = $templateMap;

        } else
        {
            $this->templateMap = array();
        }
    }

    /**
     * @param string|Model $template
     * @param array $templateVariables
     * @return string
     * @throws \Exception
     */
    public function render($template, array $templateVariables = null)
    {
        if ($template instanceof Model)
        {
            $templateVariables = $this->prepareTemplateVariables($template);
            $templateName = $template->getTemplate();

        } else
        {
            $templateName = $template;
        }

        if (!isset($this->templateMap[$templateName]))
        {
            throw new \InvalidArgumentException(sprintf('Template "%s" is not configured in template map of renderer', $templateName));
        }

        unset($template);

        if (null !== $templateVariables)
        {
            extract($templateVariables);
        }

        unset($templateVariables);

        $templatePath = $this->templateMap[$templateName];

        try {

            ob_start();
            $includeReturn = include $templatePath;
            $content = ob_get_clean();

        } catch (\Exception $ex)
        {
            ob_end_clean();
            throw $ex;
        }

        if ($includeReturn === false && empty($content))
        {
            throw new \UnexpectedValueException(sprintf(
                '%s: Unable to render template "%s" (alias: %s); file include failed',
                __METHOD__,
                $templatePath,
                $templateName
            ));
        }

        return $content;
    }

    protected function renderChildModels(Model $model)
    {
        $renderedChildren = array();
        $children = $model->getChildren();

        foreach($children as $name => $childModel)
        {
            $renderedChildren[$name] = $this->render($childModel);
        }

        return $renderedChildren;
    }

    public function prepareTemplateVariables(Model $model)
    {
        if ($model->hasAnyChildren())
        {
            $renderedChildren = $this->renderChildModels($model);

        } else
        {
            $renderedChildren = array();
        }

        if ($model->hasAnyVariables())
        {
            $templateVariables = $model->getVariables();

        } else
        {
            $templateVariables = array();
        }

        $variables = array_merge($templateVariables, $renderedChildren);
        return $variables;
    }

    /**
     * @return array
     */
    public function getTemplateMap()
    {
        return $this->templateMap;
    }

    /**
     * @param array $templateMap
     * @return $this
     */
    public function setTemplateMap($templateMap)
    {
        $this->templateMap = $templateMap;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAnyTemplateMap()
    {
        return !empty($this->templateMap);
    }

    /**
     * @param $templateName
     * @return bool
     */
    public function isTemplateRegistered($templateName)
    {
        return isset($this->templateMap[$templateName]);
    }
}