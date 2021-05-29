<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ccmven;
use App\Models\Ccmcli;
use App\Models\Ccmcpa;
use App\Models\Ccmtrs;
use App\Models\Articulo;
use App\Models\Famdfa;

class FixStringColumns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stringcolumns:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->line('Pulling records');
        $ccmven = Ccmven::all();
        $this->info('Starting CCMVEN fix');
        foreach ($ccmven as $c) {
            $c->MNOMBRE = trim($c->MNOMBRE);
            $c->save();
        }

        $this->line('Pulling Articulo records');
        $articulos = Articulo::all();
        foreach ($articulos as $a) {
            $a->MDESCRIP = trim($a->MDESCRIP);
            $a->MABREVI = trim($a->MABREVI);
            $a->MUNIDAD = trim($a->MUNIDAD);
            $a->MOBSERV = trim($a->MOBSERV);
            $a->MCOD_ORI = trim($a->MCOD_ORI);
            $a->MDISENO = trim($a->MDISENO);
            $a->MNOMB_PLIS = trim($a->MNOMB_PLIS);
            $a->MENVASE1 = trim($a->MENVASE1);
            $a->MENVASE2 = trim($a->MENVASE2);
            $a->MENVASE3 = trim($a->MENVASE3);
            $a->MENVASE4 = trim($a->MENVASE4);
            $a->save();
        }
        
        $ccmcli = Ccmcli::all();
        $this->info('Starting CCMCLI fix');
        foreach ($ccmcli as $c) {
            $c->MNOMBRE = trim($c->MNOMBRE);
            $c->MDIRECC = trim($c->MDIRECC);
            $c->MLOCALID = trim($c->MLOCALID);
            $c->MTELEF1 = trim($c->MTELEF1);
            $c->MTELEF2 = trim($c->MTELEF2);
            $c->MTELEX = trim($c->MTELEX);
            $c->MFAX = trim($c->MFAX);
            $c->MPERSONA = trim($c->MPERSONA);
            $c->MRUCCLTE = trim($c->MRUCCLTE);
            $c->MDOCIDEN = trim($c->MDOCIDEN);
            $c->MDIRDESP = trim($c->MDIRDESP);
            $c->MCTACTB = trim($c->MCTACTB);
            $c->MCTAANA = trim($c->MCTAANA);
            $c->MCORREO = trim($c->MCORREO);
            $c->MPATERNO = trim($c->MPATERNO);
            $c->MMATERNO = trim($c->MMATERNO);
            $c->MNOMBRE1 = trim($c->MNOMBRE1);
            $c->MNOMBRE2 = trim($c->MNOMBRE2);
            $c->MCODRUV = trim($c->MCODRUV);
            $c->save();
        }

        $ccmcpa = Ccmcpa::all();
        $this->info('Starting CCMCPA fix');
        foreach ($ccmcpa as $c) {
            $c->MDESCRIP = trim($c->MDESCRIP);
            $c->MABREVI = trim($c->MABREVI);
            $c->save();
        }

        $ccmtrs = Ccmtrs::all();
        $this->info('Starting CCMTRS fix');
        foreach ($ccmtrs as $c) {
            $c->MNOMBRE = trim($c->MNOMBRE);
            $c->MDIRECC = trim($c->MDIRECC);
            $c->MTELEF1 = trim($c->MTELEF1);
            $c->MTELEF2 = trim($c->MTELEF2);
            $c->MFAX = trim($c->MFAX);
            $c->save();
        }

        $famdfa = Famdfa::all();
        $this->info('Starting FAMDFA fix');
        foreach ($famdfa as $f) {
            $f->MDESCRIP = trim($f->MDESCRIP);
            $f->MABREVI = trim($f->MABREVI);
            $f->save();
        }


        $this->info('The command was successful!');
    }
}
