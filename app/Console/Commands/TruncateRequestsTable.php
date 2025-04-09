<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class TruncateRequestsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requests:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vide la table des demandes CVEC';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm('Êtes-vous sûr de vouloir vider la table des demandes CVEC ? Cette action est irréversible.')) {
            $count = Post::count();
            Post::truncate();
            $this->info("La table des demandes CVEC a été vidée. {$count} enregistrements ont été supprimés.");
            return 0;
        }
        
        $this->info('Opération annulée.');
        return 1;
    }
} 