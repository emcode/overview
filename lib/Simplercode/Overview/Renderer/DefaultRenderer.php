<?php

namespace Simplercode\Overview\Renderer;

use Simplercode\Overview\Renderer\Extension;

class DefaultRenderer extends PhpTemplateRenderer
{
    use Extension\LayoutTrait;
    use Extension\ServiceLocatorTrait;
}