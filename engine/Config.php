<?php

namespace Engine;

use League\Config\Configuration;
use Nette\Schema\Expect;
use Symfony\Component\Finder\Finder;

class Config
{
    private Finder $finder;

    public function get($key)
    {
        $finder = new Finder();

        $configuration = new Configuration(
            $this->collectConfigurate($finder)
        );

        $configuration->merge(
            $this->collectData($finder)
        );

        return to_object($configuration->get($key));
    }

    private function collectConfigurate(Finder $finder)
    {
        $finder->files()->in(path('configs/'));
        $configuration = [];

        foreach ($finder as $file) {
            $fileName = $file->getRelativePathname();
            $name = mb_strcut($fileName, 0, stripos($fileName, '.'));
            $config[$name] = $data = require($file->getRealPath());

            $configuration[$name] = Expect::structure(
                $this->buildConfiguration(
                    $name,
                    $data
                )
            );
        }

        return $configuration;
    }

    private function collectData(Finder $finder)
    {
        $finder->files()->in(path('configs/'));
        $data = [];

        foreach ($finder as $file) {
            $fileName = $file->getRelativePathname();
            $name = mb_strcut($fileName, 0, stripos($fileName, '.'));
            $data[$name] = require($file->getRealPath());
        }

        return $data;
    }

    private function buildConfiguration($parent = null, array $data = null)
    {
        $subArray = [];

        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $subArray[$key] = Expect::string();
            }

            if (is_int($value)) {
                $subArray[$key] = Expect::int();
            }

            if (is_bool($value)) {
                $subArray[$key] = Expect::bool();
            }

            if (is_array($value)) {
                $subArray[$key] = Expect::structure(
                    $this->buildConfiguration($key, $value)
                );
            }
        }

        return $subArray;
    }
}
