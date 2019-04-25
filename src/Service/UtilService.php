<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service;

class UtilService {

    //generate random sting , usefull for unique code
    public static function generateRandomString($length = 8) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function makeSQLArrayToOneArray($arrays) {
        $result = array();

        if (count($arrays) === 0){
            return $result;
        }

        foreach ($arrays as $array) {
            
            foreach ($array as  $value) {
                $result[] = $value;
                break;
            }
        }

        return $result;
    }

}
