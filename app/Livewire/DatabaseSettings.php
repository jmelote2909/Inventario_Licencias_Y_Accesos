<?php

namespace App\Livewire;

use App\Services\DatabaseConfigService;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DatabaseSettings extends Component
{
    public $form = [
        'host' => '',
        'port' => '',
        'database' => '',
        'username' => '',
        'password' => '',
    ];

    public $message = '';
    public $messageType = 'info';

    public function mount()
    {
        $this->form = DatabaseConfigService::get();
    }

    public function testConnection()
    {
        try {
            // Configurar temporalmente la conexión para la prueba
            Config::set('database.connections.mysql_test', array_merge(
                config('database.connections.mysql'),
                [
                    'host' => $this->form['host'],
                    'port' => $this->form['port'],
                    'database' => $this->form['database'],
                    'username' => $this->form['username'],
                    'password' => $this->form['password'],
                ]
            ));

            DB::connection('mysql_test')->getPdo();
            
            $this->message = "¡Conexión establecida con éxito!";
            $this->messageType = 'success';
        } catch (\Exception $e) {
            $this->message = "Error de conexión: " . $e->getMessage();
            $this->messageType = 'error';
        }
    }

    public function save()
    {
        DatabaseConfigService::set($this->form);
        session()->flash('message', 'Configuración guardada correctamente. Reinicia la aplicación si es necesario.');
        
        // Aplicar inmediatamente al runtime actual
        DatabaseConfigService::apply();
        
        $this->message = "Configuración guardada y aplicada.";
        $this->messageType = 'success';
    }

    public function render()
    {
        return view('livewire.database-settings')
            ->layout('layouts.app');
    }
}
