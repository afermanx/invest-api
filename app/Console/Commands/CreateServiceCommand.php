<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateServiceCommand extends Command
{
    // Permite o uso de subdiretórios no comando
    protected $signature = 'make:service {name}';

    protected $description = 'Cria um novo service dentro de app/Services, com suporte a subdiretórios';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Nome do service, por exemplo: "auth/Exemplo"
        $name = $this->argument('name');

        // Separar o caminho do arquivo
        $pathParts = explode('/', $name);
        $className = array_pop($pathParts); // Pega o nome do arquivo (última parte)

        // Diretório base para os services
        $baseDirectory = app_path('Services');

        // Concatena as partes do caminho com o diretório base
        $subDirectory = implode('/', $pathParts);
        $directory = $baseDirectory . '/' . $subDirectory;

        // Verifica se a pasta existe, caso contrário, cria
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        // Caminho completo do arquivo
        $filePath = $directory . '/' . $className . 'Service.php';

        // Conteúdo do arquivo de exemplo
        $namespace = 'App\\Services' . (!empty($subDirectory) ? '\\' . str_replace('/', '\\', $subDirectory) : '');
        $fileContent = "<?php\n\nnamespace {$namespace};\n\nclass {$className}Service\n{\n    // Implement your service methods here\n}\n";

        // Cria o arquivo service com o conteúdo
        if (!File::exists($filePath)) {
            File::put($filePath, $fileContent);
            $this->info("Service {$className}Service criado com sucesso em {$directory}!");
        } else {
            $this->error("Service {$className}Service já existe!");
        }

        return 0;
    }
}
