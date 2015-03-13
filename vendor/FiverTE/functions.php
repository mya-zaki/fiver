<?php
/**
 * 引数を escape します
 * 
 * @param  mixed $var
 * @return mixed
 */
function h($var) {
    if (is_array($var)) {
        array_map(__FUNCTION__, $var);
    }
    if (is_scalar($var)) {
        $charset = mb_internal_encoding();
        $var = htmlspecialchars($var, ENT_QUOTES, $charset);
    }
    return $var;
}