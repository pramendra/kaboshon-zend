<?php

namespace Album;

return array(
    'service_manager'=>array(   
        'factories' => array(
            'test.service'=> function(){
                return new Service\Test(array('entityName'=>'Application\Entity\User'));
            },           
        ), 
    ),

);