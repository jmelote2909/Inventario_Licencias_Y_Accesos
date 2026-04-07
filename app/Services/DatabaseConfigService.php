<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

class DatabaseConfigService
{
    protected static $filename = 'db_config.json';

    /**
     * Obtener la configuración actual guardada localmente.
     */
    public static function get(): array
    {
        if (Storage::disk('local')->exists(self::$filename)) {
            return json_decode(Storage::disk('local')->get(self::$filename), true);
        }

        return [
            'host' => config('database.connections.mysql.host'),
            'port' => config('database.connections.mysql.port'),
            'database' => config('database.connections.mysql.database'),
            'username' => config('database.connections.mysql.username'),
            'password' => config('database.connections.mysql.password'),
        ];
    }

    /**
     * Guardar la configuración en un archivo JSON local.
     */
    public static function set(array $data): void
    {
        Storage::disk('local')->put(self::$filename, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Aplicar la configuración al runtime de Laravel.
     */
    public static function apply(): void
    {
        $config = self::get();

        Config::set('database.connections.mysql.host', $config['host'] ?? '127.0.0.1');
        Config::set('database.connections.mysql.port', $config['port'] ?? '3306');
        Config::set('database.connections.mysql.database', $config['database'] ?? 'forge');
        Config::set('database.connections.mysql.username', $config['username'] ?? 'root');
        Config::set('database.connections.mysql.password', $config['password'] ?? '');
    }
}
