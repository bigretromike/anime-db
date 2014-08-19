<?php
/**
 * AnimeDb package
 *
 * @package   AnimeDb
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\AnimeDbBundle\Tests\Composer\Job\Migrate;

use AnimeDb\Bundle\AnimeDbBundle\Composer\Job\Migrate\Down;

/**
 * Test job migrate down
 *
 * @package AnimeDb\Bundle\AnimeDbBundle\Tests\Composer\Job\Migrate
 * @author  Peter Gribanov <info@peter-gribanov.ru>
 */
class DownTest extends TestCase
{
    /**
     * Test create proxy migrations
     *
     * @dataProvider getMigrations
     *
     * @param string $config
     */
    public function testCreateProxyMigrations($config, $file)
    {
        $file = $this->root_dir.'vendor/foo/bar/'.($config ?: $file);
        $versions = $this->root_dir.'vendor/foo/bar/DoctrineMigrations/';
        $meg_dir = $this->root_dir.'app/DoctrineMigrations/';
        $this->fs->mkdir([dirname($file), $versions, $meg_dir]);
        $this->putConfig($file);

        $version1 = 'Version55555555555555_Demo';
        $version2 = 'Version66666666666666_Test';
        touch($versions.$version1.'.php');
        touch($versions.$version2.'.php');
        touch($meg_dir.$version1.'.php');
        touch($meg_dir.$version2.'.php');

        $this->execute($config); // test

        $cache_dir = $this->root_dir.'app/cache/dev/DoctrineMigrations/';
        $this->assertFileExists($cache_dir.$version1.'.php');
        $this->assertFileExists($cache_dir.$version2.'.php');
        $this->assertFileNotExists($meg_dir.$version1.'.php');
        $this->assertFileNotExists($meg_dir.$version2.'.php');
    }

    /**
     * Get job
     *
     * @param \PHPUnit_Framework_MockObject_MockObject $package
     *
     * @return \AnimeDb\Bundle\AnimeDbBundle\Composer\Job\Migrate\Up
     */
    protected function getJob(\PHPUnit_Framework_MockObject_MockObject $package)
    {
        return new Down($package, $this->root_dir);
    }
}