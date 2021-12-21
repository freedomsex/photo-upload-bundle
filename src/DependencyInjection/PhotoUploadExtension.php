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
//    public function getAlias()
//    {
//        return 'photo_upload';
//    }


    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');

        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('photo_upload_bundle.quality', $config['quality']);
        $container->setParameter('photo_upload_bundle.width', $config['width']);
        $container->setParameter('photo_upload_bundle.height', $config['height']);

        $definition = $container->getDefinition('upload_file_namer');
        if (isset($config['namer'])) {
            $definition->setClass($config['namer']);
        }
//
//        $definition = $container->getDefinition('refresh_token.generator');
//        $definition->setProperty('tokenLifetime', $config['refresh_ttl']);
    }

//    public function process(ContainerBuilder $container)
//    {
//        $configs = $container->getExtensionConfig($this->getAlias());
//        //    Если нужно например %kernel.debug% to its boolean value
//        //    $resolvingBag = $container->getParameterBag();
//        //    $configs = $resolvingBag->resolveValue($configs);
//        $config = $this->processConfiguration(new Configuration(), $configs);
//    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $resolvingBag = $container->getParameterBag(); // '%params%' in config/* files
        $configs = $resolvingBag->resolveValue($configs);

        $config = $this->processConfiguration(new Configuration(), $configs);

        $preload = $this->loadBundleConfig('liip_imagine');
        $preload = $resolvingBag->resolveValue($preload);
//        $preload['filter_sets']['upload']['jpeg_quality'] = $config['quality'];
//        $preload['filter_sets']['upload']['filters']['downscale']['max'] = [$config['width'], $config['height']];
        $container->prependExtensionConfig('liip_imagine', $preload);

        $preload = $this->loadBundleConfig('vich_uploader');
        $preload = $resolvingBag->resolveValue($preload);
//        if (isset($config['namer'])) {
//            $preload['mappings']['uploads']['namer'] = $config['namer'];
//            $preload['mappings']['uploads']['directory_namer'] = $config['namer'];
//        }
        $container->prependExtensionConfig('vich_uploader', $preload);
    }

    public function loadBundleConfig($name)
    {
        $fileLocator = new FileLocator(__DIR__ . '/../../config/packages');
        $file = $fileLocator->locate("$name.yaml");
        return Yaml::parseFile($file)[$name];
    }


}
