<?php
/**
 * AnimeDb package
 *
 * @package   AnimeDb
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\CatalogBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Clear the media temporary folder of images
 *
 * @package AnimeDb\Bundle\CatalogBundle\Command
 * @author  Peter Gribanov <info@peter-gribanov.ru>
 */
class ClearMediaTempCommand extends Command
{
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this->setName('animedb:clear-media-temp')
            ->setDescription('Clear the media temporary folder of images');
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $start = microtime(true);

        $fs = new Filesystem();
        $fs->remove(__DIR__.'/../../../../../web/media/tmp/');

        $output->writeln('Time: <info>'.round((microtime(true)-$start)*1000, 2).'</info> s.');
    }
}