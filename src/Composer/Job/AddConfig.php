<?php
/**
 * AnimeDb package
 *
 * @package   AnimeDb
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\AnimeDbBundle\Composer\Job;

use AnimeDb\Bundle\AnimeDbBundle\Composer\Job\Job;
use Symfony\Component\Finder\Finder;

/**
 * Job: Add package config
 *
 * @package AnimeDb\Bundle\AnimeDbBundle\Composer\Job
 * @author  Peter Gribanov <info@peter-gribanov.ru>
 */
abstract class AddConfig extends Job
{
    /**
     * Job priority
     *
     * @var integer
     */
    const PRIORITY = self::PRIORITY_INSTALL;

    /**
     * Add config
     *
     * @param string $name
     * @param string $option
     */
    public function addConfig($name, $option = '')
    {
        $config = $this->getPackageConfig($name, $option);
        $bundle = $this->getPackageBundle();
        if ($config && $bundle) {
            $bundle = new $bundle();
            $info = pathinfo($config);
            $path = $info['dirname'] != '.' ? $info['dirname'].'/'.$info['filename'] : $info['filename'];
            $this->addConfig($bundle->getName(), $info['extension'], $path);
        }
    }

    /**
     * Do add config
     *
     * @param string $bundle
     * @param string $extension
     * @param string $path
     */
    abstract protected function doAddConfig($bundle, $extension, $path);

    /**
     * Get package config
     *
     * @param string $name
     * @param string $option
     *
     * @return string
     */
    private function getPackageConfig($name, $option = '')
    {
        // specific location
        if ($option && ($config = $this->getPackageOptionFile($option))) {
            return $config;
        }

        $finder = Finder::create()
            ->files()
            ->in($this->getPackageDir())
            ->path('/\/Resources\/config\/([^\/]+\/)*'.$name.'.(yml|xml)$/')
            ->name('/^'.$name.'.(yml|xml)$/');

        // ignor configs in test
        if (stripos($this->getPackage()->getName(), 'test') === false) {
            $finder->notPath('/test/i');
        }

        /* @var $file \SplFileInfo */
        foreach ($finder as $file) {
            $path = str_replace(DIRECTORY_SEPARATOR, '/', $file->getPathname());
            return substr($path, strrpos($path, '/Resources/config/'));
        }
        return '';
    }
}