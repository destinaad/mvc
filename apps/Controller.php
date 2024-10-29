<?php

class Controller{

    /* handle models
        1. Cek apakah file model ada?
        2. jika ada, maka require kelas model
        3. Instansiasi pada kelas model
    */

    public function loadmodel($model){
        if (file_exists('apps/models/'.$model.'.php')) {
            require_once('apps/models/'.$model.'.php');
            $model = new $model;
        }
        return $model;
    }
    public function loadview($view, $data=null){
        if (file_exists('apps/views/'.$view.'.php')){
            require_once('apps/views/'.$view.'.php');
        }
    }
}