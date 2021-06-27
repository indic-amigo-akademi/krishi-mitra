<?php

namespace App\Helpers;

class Notiflix
{
    public static function make(
        $array = [
            'code' => 'success',
            'title' => 'Bonjour!',
            'subtitle' => 'You have been logged in as an customer!',
        ]
    ) {
        if (!isset($array['code'])) {
            $array['code'] = 'success';
        }
        if (!isset($array['title'])) {
            $array['title'] = 'Done!';
        }
        if (!isset($array['subtitle'])) {
            $array['subtitle'] = 'Action Complete!';
        }
        if (!isset($array['type'])) {
            $array['type'] = 'Notify';
        }
        if (!isset($array['confirm'])) {
            $array['confirm'] = 'OK';
        }
        $alert = json_decode(json_encode($array));
        return $alert;
    }
}

?>
