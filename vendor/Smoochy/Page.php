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
require_once 'Query.php';
require_once 'lib/simple_html_dom.php';
/**
 * Page
 *
 * @package Smoochy
 * @author  Matsuo Masaru a.k.a localdisk
 */
class Page {
    /**
     * テンプレートが配置されているディレクトリ
     * 
     * @var string
     */
    protected $_templateDirectory;
    /**
     * テンプレートの拡張子
     *
     * @var string
     */
    protected $_templateSuffix = '.html';
    /**
     * クエリオブジェクト
     *
     * @var Query
     */
    protected $_query;
    /**
     * ページに設定するオブジェクト
     *
     * @var mixed
     */
    protected $_obj;
    /**
     * テンプレートの名前
     *
     * @var string
     */
    private $_templateName;
    /**
     * コンストラクタ
     *
     * @param mixed ページに設定するオブジェクト
     */
    public function __construct($obj = null) {
        $this->_loadTemplate();
        $this->_obj = $obj;
        $this->_injection();
    }
    /**
     * テンプレートディレクトリを設定します
     *
     * @param string $dir テンプレートディレクトリ
     */
    public function setTemplateDirectory($dir) {
        $this->_templateDirectory = $dir;
    }
    /**
     * テンプレートの拡張子を設定します
     * 
     * @param string $suffix テンプレートの拡張子
     */
    public function setTemplateSuffix($suffix) {
        $this->_templateSuffix = $suffix;
    }
    /**
     * simple_html_dom オブジェクトを取得します
     *
     * @return simple_html_dom simple_html_dom オブジェクト
     */
    public function getDom() {
        return $this->_query->getDom();
    }
    /**
     * Query オブジェクトを取得します
     * 
     * @return Query Query オブジェクト
     */
    public function getQuery() {
        return $this->_query;
    }
    /**
     * テンプレートを読み込みます
     * 
     * @return void
     */
    private function _loadTemplate() {
        $this->_templateName = strtolower(get_class($this));
        $template = $this->_templateDirectory .
                $this->_templateName .
                $this->_templateSuffix;
        if (!file_exists($template)) {
            throw new Exception("template $template not found.");
        }
        $dom = file_get_html($template);
        $this->_query = new Query($dom);
    }
    /**
     * ページクラスに定義されたメソッドをコールします
     * コールするメソッドの条件
     * 1.public メソッドである
     * 2.メソッドの1文字目「_(アンダースコア)」ではない
     * 
     * @return void
     */
    private function _injection() {
        $obj = new ReflectionClass($this);
        $methods = $obj->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if (strtolower($method->class) !== 'page'
                    && substr($method->name, 0, 1) !== '_'
                    && !in_array($method->name, get_class_methods(get_class())))  {
                $q = new ReflectionMethod('Query', 'id');
                $q->invoke($this->_query, $method->name);
                $method->invoke($this);
            }
        }

    }
}