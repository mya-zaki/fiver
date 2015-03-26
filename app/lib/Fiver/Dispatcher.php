<?php

class Fiver_Dispatcher
{
    
    public static function dispatch($module_name, $action_name, $previous_action = null)
    {
        
        $module_name_ucfirst = ucfirst(strtolower($module_name));
        $action_name_ucfirst = ucfirst(strtolower($action_name));
        
        addIncludePath(APP . '/lib/Fiver/action');
        addIncludePath(APP . '/action/' . $module_name_ucfirst);
        if (is_readable(APP . '/action/' . $module_name_ucfirst . '/' . $action_name_ucfirst . 'Action.php')) {
            $action_class = $module_name_ucfirst . '_' . $action_name_ucfirst . 'Action';
            $action = new $action_class($module_name_ucfirst, $action_name_ucfirst);
        } else {
            $action = new Error_404Action('Error', '404');
        }
        
        if (!is_null($previous_action)) {
            $action->input = $previous_action->input;
            $action->container = $previous_action->container;
        }
        
        try {
            $buffer = $action->_run();
            echo $buffer;
            
        } catch (Fiver_ForwardException $e) {
            $forward_module = $e->getModuleName();
            $forward_action = $e->getActionName();
            Fiver_Dispatcher::dispatch($forward_module, $forward_action, $action);
            
        } catch (Fiver_RedirectException $e) {
            $location = $e->getMessage();
            $http_code = $e->getCode();
            if ($http_code == '301') {
                redirect301($location);
            } else {
                redirect302($location);
            }
        }
    }
}
