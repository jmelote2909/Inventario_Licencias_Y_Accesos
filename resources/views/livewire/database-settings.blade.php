<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-indigo-700 mb-6">Configuración de Base de Datos</h2>

                @if (session()->has('message'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                @if ($message)
                    <div class="mb-4 @if($messageType == 'success') bg-green-100 border-green-400 text-green-700 @else bg-red-100 border-red-400 text-red-700 @endif border px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ $message }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Servidor (Host)</label>
                        <input type="text" wire:model="form.host" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Usa '127.0.0.1' para local o la IP del servidor de la empresa.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Puerto</label>
                        <input type="text" wire:model="form.port" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Normalmente es '3306'.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre de Base de Datos</label>
                        <input type="text" wire:model="form.database" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Usuario</label>
                        <input type="text" wire:model="form.username" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input type="password" wire:model="form.password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <button wire:click="testConnection" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Probar Conexión
                    </button>
                    <button wire:click="save" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
            <p class="font-bold">⚠️ Nota Importante:</p>
            <p>Si cambias la configuración a una IP incorrecta, la aplicación podría dejar de funcionar. Asegúrate de "Probar Conexión" antes de guardar.</p>
        </div>
    </div>
</div>
