<?php
    function format_date($date) {
        $tokens = explode('/', $date);

        $date ='';
        foreach($tokens as $token) {
            $date .= $token.'/';
        }
        return substr($date,0, strlen($date) - 1);
    }