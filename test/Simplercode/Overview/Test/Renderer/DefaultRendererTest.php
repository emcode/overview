<?php

namespace Simplercode\Overview\Test\Renderer;

use PHPUnit_Framework_TestCase;
use Simplercode\Overview\Model;
use Simplercode\Overview\Renderer\DefaultRenderer;
use Simplercode\Overview\Renderer\PhpTemplateRenderer;

class DefaultRendererTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DefaultRenderer
     */
    protected $renderer;

    public function setUp()
    {
        $this->renderer = new DefaultRenderer();
        $this->renderer->setTemplateMap(array(
            'some/layout' => __DIR__ . '/Fixtures/layout-example.phtml',
            'some/action' => __DIR__ . '/Fixtures/action-example.phtml'
        ));

        $layoutModel = new Model('some/layout');
        $this->renderer->setLayoutModel($layoutModel);
    }

    public function testActionTemplateIsRenderedInsideLayoutInContentVariable()
    {
        $actionModel = new Model('some/action');
        $html = $this->renderer->action($actionModel);
        $this->assertInternalType('string', $html);
        $this->assertStringStartsWith('<layout>', $html);
        $this->assertContains('<action>This is action content</action>', $html);
        $this->assertStringEndsWith('</layout>', $html);
    }
}