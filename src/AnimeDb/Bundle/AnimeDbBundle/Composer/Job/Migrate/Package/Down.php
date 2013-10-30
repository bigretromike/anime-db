<?php
/**
 * AnimeDb package
 *
 * @package   AnimeDb
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\AnimeDbBundle\Composer\Job\Migrate\Package;

use AnimeDb\Bundle\AnimeDbBundle\Composer\Job\Migrate\Package\Package as BasePackage;

/**
 * Job: Migrate package down
 *
 * @package AnimeDb\Bundle\AnimeDbBundle\Composer\Job\Migrate\Package
 * @author  Peter Gribanov <info@peter-gribanov.ru>
 */
class Down extends BasePackage
{
    /**
     * (non-PHPdoc)
     * @see AnimeDb\Bundle\AnimeDbBundle\Composer\Job.Job::execute()
     */
    public function execute()
    {
        if ($config = $this->getMigrationsConfig()) {
           self::executeCommand('doctrine:migrations:migrate 0 --no-interaction --configuration='.$config);
        }
    }
}