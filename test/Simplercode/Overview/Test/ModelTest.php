<?php

namespace Simplercode\Overview\Test;

use PHPUnit_Framework_TestCase;
use Simplercode\Overview\Model;

class ModelTest extends PHPUnit_Framework_TestCase
{
    public function testTemplateCanBeSetViaConstructor()
    {
        $templateName = 'test/template';
        $model = new Model($templateName);
        $this->assertTrue($model->hasAnyTemplate());
        $this->assertEquals($model->getTemplate(), $templateName);
    }

    public function testTemplateCanBeSetViaSetter()
    {
        $templateName = 'test/template';
        $model = new Model();
        $model->setTemplate($templateName);
        $this->assertTrue($model->hasAnyTemplate());
        $this->assertEquals($model->getTemplate(), $templateName);
    }

    public function testVariablesCanBeSetViaConstructor()
    {
        $variables = array(
            'firstName' => 'firstValue',
            'secondName' => 'secondValue',
        );

        $model = new Model(null, $variables);
        $this->assertTrue($model->hasAnyVariables());
        $this->assertEquals($variables, $model->getVariables());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCannotAddChildWithSameName()
    {
        $parent = new Model();
        $parent->addChild('exampleChild', new Model());
        $parent->addChild('exampleChild',  new Model());
    }

    public function testChildModelCanReplacedByNewOne()
    {
        $parent = new Model();
        $parent->addChild('exampleChild', new Model('firstTemplate'));
        $parent->setChild('exampleChild',  new Model('secondTemplate'));
        $child = $parent->getChildByName('exampleChild');
        $this->assertEquals('secondTemplate', $child->getTemplate());
    }

    public function testCanAddChildModelToParent()
    {
        $children = array(
            'firstChild' => new Model(),
            'secondChild' => new Model(),
            'thirdChild' => new Model(),
        );

        $parent = new Model();
        $this->assertFalse($parent->hasAnyChildren());

        foreach ($children as $name => $child)
        {
            $parent->addChild($name, $child);
        }

        $this->assertTrue($parent->hasAnyChildren());
        $this->assertEquals($parent->getChildren(), $children);
    }


    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage cannot be removed, it does not exist
     */
    public function testCannotRemoveNonExistingChildModelFromParent()
    {
        $children = array(
            'someChild' => new Model(),
            'anotherChild' => new Model()
        );

        $parent = new Model();
        $parent->setChildren($children);
        $parent->removeChildByName('noneExistingChildName');
    }

    public function testCanRemoveExistingChildModelFromParent()
    {
        $children = array(
            'someChild' => new Model('some/template'),
            'anotherChild' => new Model('another/template')
        );

        $parent = new Model();
        $parent->setChildren($children);
        $removedChild = $parent->removeChildByName('someChild');

        $this->assertEquals('some/template', $removedChild->getTemplate());
        $this->assertCount(1, $parent->getChildren());
        $this->assertArrayNotHasKey('someChild', $parent->getChildren());
        $this->assertArrayHasKey('anotherChild', $parent->getChildren());
    }


    public function testSingleVariableCanBeSetByName()
    {
        $model = new Model();
        $model->setVariable('variableName', 'abcde');
        $this->assertEquals(array('variableName' => 'abcde'), $model->getVariables());
    }

    public function testSingleVariableCanBeUnsetByName()
    {
        $model = new Model();
        $model->setVariables(array('en' => 'hello', 'es' => 'ola', 'fr' => 'bonjour'));
        $model->unsetVariable('es');
        $this->assertEquals(array('en' => 'hello', 'fr' => 'bonjour'), $model->getVariables());
    }
}