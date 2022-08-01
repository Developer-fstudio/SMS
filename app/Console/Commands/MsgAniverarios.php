<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Controllers\AniversariosController as Aniversarios;
class MsgAniverarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Aniversarios:msg';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mensagem de aniversarios para onde envia mensagem personalizada';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Aniversarios::AniversariosMsg();
        return 0;
    }
}
