<?php

namespace Lexik\Bundle\AcceleratorBundle;

use Lexik\Bundle\AcceleratorBundle\DependencyInjection\Compiler\AcceleratorCollectorCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class LexikAcceleratorBundle
 * @package Lexik\Bundle\AcceleratorBundle
 */
class LexikAcceleratorBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AcceleratorCollectorCompilerPass());
    }
}
