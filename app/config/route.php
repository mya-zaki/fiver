<?php
/**
 * route setting
 * 
 * $rules =>
 *     name =>
 *         [pattern]
 *         array([params]...), // params
 *         array([requirements]...) // requirements
 */
return array(
    
    'default' => array('/:module/:action', array('module' => 'index', 'action' => 'index')),
    
);