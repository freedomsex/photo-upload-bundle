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
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('params.yaml');

        $config = $this->processConfiguration(new Configuration(), $configs);

        $definition = $container->getDefinition('upload_file_namer');
        if (isset($config['namer'])) {
            $definition->setClass($config['namer']);
        }
//
//        $definition = $container->getDefinition('refresh_token.generator');
//        $definition->setProperty('tokenLifetime', $config['refresh_ttl']);
    }

    public function prepend(ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('params.yaml');

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        $preload = $this->parseYamlConfigFile('liip_imagine');
        $preload['filter_sets']['upload']['jpeg_quality'] = $config['quality'];
        $preload['filter_sets']['upload']['filters']['downscale']['max'] = [$config['width'], $config['height']];
        $container->prependExtensionConfig('liip_imagine', $preload);

        $preload = $this->parseYamlConfigFile('vich_uploader');
        if (isset($config['namer'])) {
            $preload['mappings']['uploads']['namer'] = $config['namer'];
            $preload['mappings']['uploads']['directory_namer'] = $config['namer'];
        }
        $container->prependExtensionConfig('vich_uploader', $preload);
    }

    public function parseYamlConfigFile($name)
    {
        $fileLocator = new FileLocator(__DIR__ . '/../Resources/config/packages');
        $file = $fileLocator->locate("$name.yaml");
        return Yaml::parseFile($file)[$name];
    }


}
