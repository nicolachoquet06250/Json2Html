<?php

class var_dump
{
    public function __construct($mixed)
    {
        echo '<pre style="margin-left: 30px;">';
        var_dump($mixed);
        echo '</pre>';
    }
}