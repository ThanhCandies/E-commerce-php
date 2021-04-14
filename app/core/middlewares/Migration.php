<?php


namespace App\core\middlewares;


abstract class Migration
{
    abstract public function up();
    abstract public function down();
}