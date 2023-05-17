<?php

namespace app\migration;

use app\core\Migration;

class m0001_initial extends Migration
{
    public function up(): void
    {
        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            status TINYINT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE users";

        $this->pdo->exec($sql);
    }
}
