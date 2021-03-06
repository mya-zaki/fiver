<?php

class Fiver_Dispatcher
{
    /**
     * dispatch
     * 
     * @param string $module_name
     * @param string $action_name
     * @param Fiver_Action $previous_action
     */
    public static function dispatch($module_name, $action_name, $previous_action = null)
    {
        
        $module_name_ucfirst = ucfirst(strtolower($module_name));
        $action_name_ucfirst = ucfirst(strtolower($action_name));
        
        addIncludePath(APP . '/lib/Fiver/action');
        addIncludePath(APP . '/action');
        
        $action_class = $module_name_ucfirst . '_' . $action_name_ucfirst . 'Action';
        if (@class_exists($action_class, true)) {
            $action = new $action_class($module_name_ucfirst, $action_name_ucfirst);
        } else {
            $action = new Error_404Action('Error', '404');
        }
        
        if (!is_null($previous_action)) {
            $action->input = $previous_action->input;
            $action->container = $previous_action->container;
        }
        
        try {
            Fiver_Log::mark('fiver_action');
            $buffer = $action->_run();
            Fiver_Log::performance('fiver_action', get_class($action));
            Fiver_Response::getInstance()->sendHeaders();
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
        } catch (Exception $e) {
            Fiver_Log::error($e->getMessage());
            $action = new Error_500Action('Error', '500');
            $buffer = $action->_run();
            echo $buffer;
        }
        return;
    }
}
