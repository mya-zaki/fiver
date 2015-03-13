<?php
/**
 * FiverTE - PHP Template Engine used phpQuery
 *
 * PHP version 5
 *
 * @package   FiverTE
 */
require_once 'FiverTE/Query.php';
require_once 'vendor/phpQuery-onefile.php';
/**
 * Page
 *
 * @package FiverTE
 * @author  mya-zaki
 */
class Page
{
    /** @var string Dir where template is located */
    protected $_templateDirectory;
    /** @var string template extension */
    protected $_templateSuffix = '.html';
    /** @var Query object */
    protected $_query;
    /** @var mixed　Object to be set for the page. */
    protected $_obj;
    /** @var string template name */
    private $_templateName;
    
    /**
     * constructor
     *
     * @param mixed $obj Object to be set for the page.
     */
    public function __construct($obj = null)
    {
        $this->_loadTemplate();
        $this->_obj = $obj;
        $this->_injection();
    }
    
    /**
     * Set template location
     *
     * @param string $dir template dir
     */
    public function setTemplateDirectory($dir)
    {
        $this->_templateDirectory = $dir;
    }
    
    /**
     * Set template extension
     * 
     * @param string $suffix template extension
     */
    public function setTemplateSuffix($suffix)
    {
        $this->_templateSuffix = $suffix;
    }
    
    /**
     * get phpQuery Object.
     *　
     * @return phpQueryObject
     */
    public function getDom() {
        return $this->_query->getDom();
    }
    /**
     * get Query object.
     * 
     * @return Query Query object
     */
    public function getQuery() {
        return $this->_query;
    }
    /**
     * load template.
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
     * Call methods that defined in class. 
     *   Conditions:
     *     1.public method
     *     2.First character of method name is not '_'.
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