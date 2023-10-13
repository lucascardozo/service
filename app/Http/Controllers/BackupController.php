<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Backup;
use Spatie\Backup\BackupDestination\Backup as SpatieBackup;
use Spatie\Backup\BackupDestination\BackupDestination;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index(){
        
        $backups = Backup::orderBy('id','DESC')->paginate(10);

        return view("admin.backups",['backups' => $backups]);

    }

    public function gerar()
    {
        try {

            /* Faz o backup */
		
            $dbhost = env('DB_HOST');
            $dbuser = env('DB_USERNAME');
            $dbpass = env('DB_PASSWORD');
            $dbname = env('DB_DATABASE');

            /* diretorio */
            $diretorio = storage_path("app/public/backup/");
            /* nome do arquivo */
            $backupfile = "backup_".$dbname."_".date("YmdHis",time()).".sql";
            /* diretorio do arquivo */
            $dir_backupfile = $diretorio.$backupfile;
            /* diretorio do arquivo zipado */
            $dir_backupzip 	= $diretorio.$backupfile.'.tar.gz';
            /* nome do arquivo zipado*/
            $nomearquivo = $backupfile.'.tar.gz';
            
            /* faz o dump do banco de dados */
            system("mysqldump -h $dbhost -u $dbuser -p$dbpass $dbname > $dir_backupfile");
            
            /* salva zipado no diretorio */
            system("tar -czvf $dir_backupzip $dir_backupfile");
            
            /* apaga o arquivo sql */
            unlink($dir_backupfile);

            // Salve informações sobre o backup no banco de dados
            Backup::create([
                'backup' => $nomearquivo,
                'file' => $nomearquivo
            ]);

            // Se chegou até aqui, o backup foi bem-sucedido
            $backups = Backup::orderBy('id','DESC')->paginate(10);

            return view("admin.backups",['backups' => $backups]);

        } catch (\Exception $e) {
            // Se ocorrer algum erro, retorne uma resposta de erro
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function download(){
        echo "teste download";
    }

    public function deletar(){
        echo "teste deletar";
    }
}
