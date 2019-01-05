<?php

define('API_KEY', 'ilovethisapi');

function checkAPIKEY(){
    foreach (getallheaders() as $name => $value) {
        if ($name == "API_KEY") {
            if (API_KEY == $value) {
                return true;
             } 
            return false;
        }
    }
}