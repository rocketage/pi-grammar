<?php

namespace AppBundle\Services\Content;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Processor;

class Loader
{
    /**
     * @var ConfigurationInterface
     */
    private $schema;

    /**
     * @var FileLocatorInterface
     */
    private $locator;

    /**
     * Loader constructor.
     * @param ConfigurationInterface $schema
     * @param FileLocatorInterface $locator
     */
    public function __construct(ConfigurationInterface $schema, FileLocatorInterface $locator)
    {
        $this->schema = $schema;
        $this->locator = $locator;
    }

    /**
     * @param string $path
     * @param string $language
     * @return array
     */
    public function load($path, $language)
    {
        $processor = new Processor();

        return $processor->processConfiguration(
            $this->schema,
            Yaml::parse(file_get_contents($this->locate($path, $language)))
        );
    }

    /**
     * @param string $path
     * @param string $language
     * @return string
     */
    private function locate($path, $language)
    {
        return $this->locator->locate(sprintf('%s/%s.yml', $path, $language));
    }
}
