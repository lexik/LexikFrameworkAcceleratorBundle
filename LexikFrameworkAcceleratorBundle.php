<?php

namespace Lexik\Bundle\FrameworkAcceleratorBundle;

use Lexik\Bundle\FrameworkAcceleratorBundle\DependencyInjection\Compiler\AcceleratorCollectorCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class LexikFrameworkAcceleratorBundle
 * @package Lexik\Bundle\FrameworkAcceleratorBundle
 */
class LexikFrameworkAcceleratorBundle extends Bundle
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
