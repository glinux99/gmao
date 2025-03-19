<?php

namespace App\Console\Commands;

use App\Http\Controllers\StockHistoryController;
use App\Models\User;
use App\Models\UserRepport;
use App\Notifications\NewRegister;
use App\Notifications\RepportSendNotifier;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RepportSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repport:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $maintenant = Carbon::now();

// Formater la date en français
        $dateFrancais = $maintenant->format('l d F Y H:i:s');
        info("Cron Job running at ". now());
        $users = UserRepport::all();
        $stockCtrl = new StockHistoryController;
        foreach ($users as $user        ) {
            # code...
           try {
            $user->notify(new RepportSendNotifier ([
                "title"=> "Nous espère que ce mail vous trouve bien.\n\n                        nous vous envoyons en pièce jointe le rapport sur les Entree/Sortie de la Sous station. \nVous y trouverez notamment les quantites restantes par sortie du $dateFrancais",
                        "greeting"=>"Bonjour Mr/Md ".$user->fullname,
                        "data" => $stockCtrl->export_stock(), ['as'=>"rapport_sortie_de_stock.xlsx"]
            ]));
           } catch (\Throwable $th) {
            //throw $th;
           }
        }
    }
}
