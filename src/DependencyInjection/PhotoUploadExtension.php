<?php


namespace FreedomSex\PhotoUploadBundle\DependencyInjection;


use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

use Symfony\Component\Yaml\Yaml;


class PhotoUploadExtension extends Extension implements PrependExtensionInterface
{

    public function loadServices(ContainerBuilder $container, $filename = 'services.yaml')
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $this->loadServices($container);
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('photo_upload_bundle.quality', $config['quality']);
        $container->setParameter('photo_upload_bundle.width', $config['width']);
        $container->setParameter('photo_upload_bundle.height', $config['height']);

        $definition = $container->getDefinition('upload_file_namer');
        if (isset($config['namer'])) {
            $definition->setClass($config['namer']);
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        // Load `parameters` from services.yaml
        $this->loadServices($container);
        $resolvingBag = $container->getParameterBag(); // '%params%' in config/* files

        $preload = $this->loadBundleConfig('liip_imagine');
        $preload = $resolvingBag->resolveValue($preload);
        $container->prependExtensionConfig('liip_imagine', $preload);

        $preload = $this->loadBundleConfig('vich_uploader');
        $preload = $resolvingBag->resolveValue($preload);
        $container->prependExtensionConfig('vich_uploader', $preload);
    }

    public function loadBundleConfig($name)
    {
        $fileLocator = new FileLocator(__DIR__ . '/../../config/packages');
        $file = $fileLocator->locate("$name.yaml");
        return Yaml::parseFile($file)[$name];
    }


}
