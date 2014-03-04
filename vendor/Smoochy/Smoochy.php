<?php
/**
 * Smoochy - PHP Template Engine like jQuery
 *
 * PHP version 5
 *
 * @category  Smoochy
 * @package   Smoochy
 * @link      http://bitbucket.org/localdisk/smoochy/
 * @author    Matsuo Masaru a.k.a localdisk
 * @copyright 2009-2010 Matsuo Masaru
 * @license   http://opensource.org/licenses/bsd-license.php New BSD License
 */
require_once 'Page.php';
/**
 * Smoochy
 *
 * @package Smoochy
 * @author  Matsuo Masaru a.k.a localdisk
 */
class Smoochy {
    /**
     * バージョン番号
     */
    const VERSION = '0.2.0';

    /**
     * コンストラクタ
     */
    public function __construct() {

    }

    /**
     * ページを出力します
     * 
     * @param Page $page ページオブジェクト
     */
    public function render(Page $page) {
        echo $this->execute($page);
    }

    /**
     * ページの出力結果を返します
     * 
     * @param Page $page ページオブジェクト
     * @return string 出力結果
     */
    public function execute(Page $page) {
        $dom = $page->getDom();
        $contents = $dom->save();
        $dom->clear();
        unset($dom);
        return $contents;
    }
}