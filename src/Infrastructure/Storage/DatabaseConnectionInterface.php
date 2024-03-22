<?php

namespace Alcoline\Daniel\Infrastructure\Storage;

use PDO;

interface DatabaseConnectionInterface
{
    public function getConnection(): PDO;
}