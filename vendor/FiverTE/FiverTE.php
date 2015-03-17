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
    protected $template_path;
    
    protected $pqdoc;
    
    public function __construct($template_path)
    {
        if (!is_readable($template_path)) {
            throw new FiverTE_Exception();
        }
        $this->template_path = $template_path;
        
        $this->pqdoc = phpQuery::newDocumentFileHTML($this->template_path);
    }
    
    public function text($selectors, $text)
    {
        return $this->pqdoc->find($selectors)->text($text);
    }
    
    
    public function fetch()
    {
        return $this->pqdoc->html();
    }
    
}
