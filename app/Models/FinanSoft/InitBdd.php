<?php


namespace App\Models\FinanSoft;


class InitBdd
{
    public function getPDO()
    {
        $host     = env('FIREBIRD_HOST', '127.0.0.1');
        $port     = (int) env('FIREBIRD_PORT', 3050);
        $database = env('FIREBIRD_DATABASE');   // ejemplo: /opt/db/mi_base.fdb  (Linux)
        // o C:\\data\\mi_base.fdb     (Windows)
        $user     = env('FIREBIRD_USERNAME');
        $pass     = env('FIREBIRD_PASSWORD');
        $charset  = env('FIREBIRD_CHARSET', 'UTF8');

        // ⚠️ Asegúrate que el prefijo sea 'firebird:' (no dependas de FIREBIRD_NAME_KEY)
        $dsn = sprintf('firebird:dbname=%s/%d:%s;charset=%s', $host, $port, $database, $charset);

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
            // \PDO::ATTR_PERSISTENT      => true, // ← activa si quieres conexión persistente
            \PDO::ATTR_PERSISTENT         => true, // 🔥 evita handshake por request

        ];

        return new \PDO($dsn, $user, $pass, $options);
    }


}
