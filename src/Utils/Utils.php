<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

use Symfony\Component\HttpFoundation\Request;

/**
 * Description of Utils
 *
 * @author bambo
 */
class Utils {
    
    public static $serveurUrl = 'http://127.0.0.1:8000';
    //public static $serveurUrl = 'https://prestige-ws.bambocloud.com';

    public static function serializeRequestContent(Request $request) {
        return json_decode($request->getContent(), true);
    }
    
    public static function getObjectFromRequest(Request $request) {
        return json_decode($request->getContent());
    }

}
