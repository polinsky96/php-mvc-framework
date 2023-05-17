<?php

namespace app\core;

use PDO;

/**
 * Class Migration
 * 
 * @package app\core
 */

abstract class Migration
{
    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Application::$app->db->pdo;
    }

    abstract public function up(): void;
    abstract public function down(): void;
}