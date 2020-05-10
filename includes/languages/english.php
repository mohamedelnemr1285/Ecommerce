<?php

function lang($phrase){

    static $lang = array(

        'message' => 'welcome',
    );
    return $lang[$phrase];
}


?>