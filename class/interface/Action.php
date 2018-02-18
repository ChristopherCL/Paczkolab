<?php

interface Action
{
    const db = null;

    public function save();

    public function update();

    public function delete();

    public static function load($id = null);
    
    public static function loadAll();

    public static function setDb(Database $db);
}
