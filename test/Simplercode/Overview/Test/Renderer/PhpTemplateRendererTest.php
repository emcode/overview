<?php

namespace Simplercode\Overview\Test\Renderer;

use PHPUnit_Framework_TestCase;
use Simplercode\Overview\Model;
use Simplercode\Overview\Renderer\PhpTemplateRenderer;

class PhpTemplateRendererTest extends PHPUnit_Framework_TestCase
{
    public function testTemplateMapCanBeSetViaConstructor()
    {
        $map = array(
            'some/template/alias' => 'some/path/to/file',
            'other/template/alias' => 'other/path/to/file'
        );

        $renderer = new PhpTemplateRenderer($map);
        $this->assertTrue($renderer->hasAnyTemplateMap());
        $this->assertEquals($renderer->getTemplateMap(), $map);
    }

    public function testTemplateWithoutVariablesCanBeRendered()
    {
        $map = array(
            'title-partial' => __DIR__ . '/Fixtures/title-example.phtml'
        );

        $renderer = new PhpTemplateRenderer($map);
        $model = new Model('title-partial');
        $output = $renderer->render($model);
        $this->assertInternalType('string', $output);
        $this->assertEquals($output, '<h1>Some cool title</h1>');
    }

    public function testTemplateWithVariablesCanBeRendered()
    {
        $map = array(
            'person-partial' => __DIR__ . '/Fixtures/person-example.phtml'
        );

        $renderer = new PhpTemplateRenderer($map);
        $model = new Model('person-partial', array(
            'firstName' => 'John',
            'lastName' => 'Smith',
            'role' => 'Programmer',
        ));

        $output = $renderer->render($model);
        $this->assertInternalType('string', $output);
        $this->assertStringStartsWith('<section>', $output);
        $this->assertContains('<li>First name: John</li>', $output);
        $this->assertContains('<li>Last name: Smith</li>', $output);
        $this->assertContains('<li>Role: Programmer</li>', $output);
        $this->assertStringEndsWith('</section>', $output);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Template "some-template" is not configured in template map
     */
    public function testNotRegisteredTemplateCannotBeRendered()
    {
        $renderer = new PhpTemplateRenderer();
        $this->assertFalse($renderer->hasAnyTemplateMap());
        $model = new Model('some-template');
        $renderer->render($model);
    }
}