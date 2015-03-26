<?php
/**
 * FiverTE - PHP Template Engine used phpQuery
 * 
 * require php-dom package.
 *   e.g yum install php-dom
 * 
 */

require_once 'FiverTE/vendor/phpQuery-onefile.php';
require_once 'FiverTE/Exception.php';

class FiverTE
{
    /** @var string Template filepath */
    protected $template_path;
    
    /** @var phpQueryObject */
    protected $pqdoc;
    
    /**
     * constructor
     * 
     * @param string $template_path
     * @throws FiverTE_Exception
     */
    public function __construct($template_path)
    {
        if (!is_readable($template_path)) {
            throw new FiverTE_Exception();
        }
        $this->template_path = $template_path;
        
        $this->pqdoc = phpQuery::newDocumentFileHTML($this->template_path);
    }
    
    /**
     * Set the text contents of the matched elements.
     * 
     * @param string $selectors
     * @param string $text
     */
    public function text($selectors, $text)
    {
        $this->pqdoc->find($selectors)->text($text);
    }
    
    /**
     * Set the HTML contents of every matched element.
     *
     * @param string $selectors
     * @param string $html
     */
    public function html($selectors, $html)
    {
        $this->pqdoc->find($selectors)->html($html);
    }
    
    /**
     * Set the value of every matched element.
     *
     * @param string $selectors
     * @param string $val
     */
    public function val($selectors, $val)
    {
        $this->pqdoc->find($selectors)->val($val);
    }
    
    /**
     * Set one or more attributes for every matched element.
     * 
     * @param string $selectors
     * @param string $attr
     * @param string $value
     */
    public function attr($selectors, $attr, $value)
    {
        $this->pqdoc->find($selectors)->attr($attr, $value);
    }
    
    /**
     * Append to repeat the view parts.
     * 
     * @param string $selectors
     * @param Callable $callback
     * @param array $data_array
     */
    public function loop($selectors, $callback, $data_array)
    {
        $loop_target = $this->pqdoc->find($selectors);
        
        foreach ($data_array as $key => $value) {
            $view_part = $loop_target->clone();
            call_user_func($callback, $view_part, $value, $key);
            $loop_target->before($view_part);
        }
        $loop_target->remove();
    }
    
    /**
     * Adds the specified class to each of the set of matched elements.
     *
     * @param string $selectors
     * @param string $class_name
     */
    public function addClass($selectors, $class_name)
    {
        $this->pqdoc->find($selectors)->addClass($class_name);
    }
    
    /**
     * Remove a class from each element in the set of matched elements.
     *
     * @param string $selectors
     * @param string $class_name
     */
    public function removeClass($selectors, $class_name)
    {
        $this->pqdoc->find($selectors)->removeClass($class_name);
    }
    
    /**
     * Set the other FiverTE object of every matched element.
     * 
     * @param string $selectors
     * @param FiverTE $fte
     */
    public function import($selectors, FiverTE $fte)
    {
        $this->pqdoc->find($selectors)->html($fte->fetch());
    }
    
    /**
     * Get contents.
     * 
     * @return string 
     */
    public function fetch()
    {
        return $this->pqdoc->html();
    }
    
}
