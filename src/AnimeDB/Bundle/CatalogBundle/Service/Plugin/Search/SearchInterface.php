<?php
/**
 * AnimeDB package
 *
 * @package   AnimeDB
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDB\Bundle\CatalogBundle\Service\Plugin\Search;

use AnimeDB\Bundle\CatalogBundle\Service\Plugin\PluginInterface;

/**
 * Plugin search interface
 * 
 * @package AnimeDB\Bundle\CatalogBundle\Service\Plugin\Search
 * @author  Peter Gribanov <info@peter-gribanov.ru>
 */
interface SearchInterface extends PluginInterface
{
    /**
     * Search source by name
     *
     * Use $url_bulder for build link to fill item from source or build their own links
     *
     * Return structure
     * <code>
     * [
     *     \AnimeDB\Bundle\CatalogBundle\Service\Plugin\Search\Item
     * ]
     * </code>
     *
     * @param string $name
     * @param \Closure $url_bulder
     *
     * @return array
     */
    public function search($name, \Closure $url_bulder);
}