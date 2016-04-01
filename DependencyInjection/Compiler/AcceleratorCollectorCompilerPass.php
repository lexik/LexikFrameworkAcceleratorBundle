<?php

namespace Lexik\Bundle\FrameworkAcceleratorBundle\DependencyInjection\Compiler;

use Lexik\Bundle\FrameworkAcceleratorBundle\Collector\AcceleratorCollector;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AcceleratorCollectorCompilerPass
 * @package Lexik\Bundle\FrameworkAcceleratorBundle\DependencyInjection\CompilerPass
 */
class AcceleratorCollectorCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $collectors = $container->findTaggedServiceIds('data_collector');
        foreach ($collectors as $collector => $collectorArguments) {
            $definition = $container->getDefinition($collector);

            if (
                !empty($definition->getTag('kernel.event_subscriber')) ||
                !empty($definition->getTag('kernel.event_listener')) ||
                in_array($collector, array_merge([
                    'data_collector.form',
                    'data_collector.dump',
                    'data_collector.config',
                    'data_collector.ajax',
                    'data_collector.exception',
                    'data_collector.security',
                    'swiftmailer.data_collector',
                    'data_collector.doctrine',
                    'doctrine_mongodb.odm.data_collector.standard',
                    'doctrine_mongodb.odm.data_collector.pretty',
                    'sonata.block.data_collector',
                    'api_caller.data_collector',
                    'bazinga_geocoder.data_collector',
                ], $container->getParameter('lexik_accelerator.ignore_data_collector')))
            ) {
                continue;
            }

            $accelerator = new Definition();
            $container->setDefinition($collector.'.accelerator', $accelerator);
            $accelerator
                ->setDecoratedService($collector)
                ->setArguments([new Reference($collector.'.accelerator.inner')])
                ->setClass(AcceleratorCollector::class);

            $originalTag = $definition->getTag('data_collector');
            foreach ($originalTag as $tagAttributes) {
                $accelerator->addTag('data_collector', $tagAttributes);
            }
        }
    }
}
