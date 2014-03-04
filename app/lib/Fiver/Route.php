<?php

require_once 'symfony/lib/routing/sfRoute.class.php';

class Fiver_Route
{
    /** @var string REDIRECT_URL */
    private $url = '';
    /** @var array routing rule*/
    private $rules = '';
    
    public function __construct($url, $rules)
    {
        $this->url = $url;
        $this->rules = $rules;
    }
    
    public function match()
    {
        try {
            foreach ($this->rules as $rule) {
                $pattern      = isset($rule[0])?$rule[0]:null;
                $defaults     = isset($rule[1])?$rule[1]:array();
                $requirements = isset($rule[2])?$rule[2]:array();
                $options      = isset($rule[3])?$rule[3]:array();
                $sfroute = new sfRoute($pattern, $defaults, $requirements, $options);
                
                $ret = $sfroute->matchesUrl($this->url);
                if ($ret !== false) {
                    break;
                }
            }
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}