<?php
/**
 * FiverTE - PHP Template Engine used phpQuery
 *
 * PHP version 5
 *
 * @package   FiverTE
 * @link      https://github.com/mya-zaki/fiverTE
 * @author    mya-zaki
 * @copyright 2009-2010 Matsuo Masaru
 * @license   http://opensource.org/licenses/bsd-license.php New BSD License
 */
require_once 'FiverTE/Page.php';

/**
 * FiverTE
 *
 * @package FiverTE
 * @author  mya-zaki
 */
class FiverTE
{
    /** @var const string Version */ 
    const VERSION = '0.1.0';

    /**
     * constructor
     */
    public function __construct()
    {
    }

    /**
     * render page
     * 
     * @param Page $page page object
     */
    public function render(Page $page)
    {
        echo $this->execute($page);
    }

    /**
     * return the output of the page.
     * 
     * @param Page $page page object
     * @return string Output
     */
    public function execute(Page $page)
    {
        $dom = $page->getDom();
        $contents = $dom->save();
        $dom->clear();
        unset($dom);
        return $contents;
    }
}