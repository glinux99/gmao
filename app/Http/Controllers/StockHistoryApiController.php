<?php

namespace App\Http\Controllers;

use App\Exports\ExportExcelSheets;
use App\Exports\StockHistoryExport;
use App\Models\Category;
use App\Models\Entry;
use App\Models\StockHistory;
use App\Models\User;
use App\Notifications\SortieMateriel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;

class StockHistoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sorties = StockHistory::where('type', 'withdraw')->with(['category', 'demandeur'])->orderByDesc('id')->get();
        return response()->json(['data' => $sorties]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $stock = StockHistory::where('category_id', $request->category_id)
                ->where('type', "entry")
                ->orderByDesc('id')->first();

            $stock2 = StockHistory::create([
                "demandeur_id" => $request->demandeur_id,
                "category_id" => $request->category_id,
                "quantity" => $request->quantity,
                "quantity_restante" => 0,
                "etat" => $request->etat,
                "type" => "withdraw"
            ]);

            if (!$stock) {
                $stock = $stock2;
            }

            $errorSold = false;
            if (($stock->quantity_restante - $request->quantity) <= 0) {
                $stock2->delete();
                $errorSold = true;
                return response()->json(['message' => 'Le stock est insuffisant pour effectuer ce mouvement'], 400);
            }

            if (!$errorSold) {
                if ($stock) {
                    $stock->update(['quantity_restante' => $stock->quantity_restante - $request->quantity]);
                } else {
                    $entry = new EntryApiController();
                    $req = new Request();
                    $req["caracteristique"] = "";
                    $req["description"] = "";
                    $req["quantity"] = -$request->quantity;
                    $req["category_id"] = $request->category_id;
                    $req["quantity_restante"] = -$request->quantity;
                    $req["etat"] = $request->etat;
                    $entry->store($req);
                    $stock = StockHistory::where('category_id', $request->category_id)
                        ->where('type', "entry")
                        ->first();
                    $stock->update(['quantity_restante' => -$request->quantity]);
                }
                $stock2->update(['quantity_restante' => $stock->quantity_restante]);
                $user = User::find($request->demandeur_id);
                $category = Category::with('unity')->find($request->category_id);

                try {
                    $user->notify(new SortieMateriel([
                        "title" => "Vous avez sortie " . $request->quantity . " " . $category->unity->designation . "(s) de " . $category->designation . " qui " . ($request->quantity > 1 ? "sont" : "est") . " en  état " . $request->etat . " .\n\n\n Si vous n'êtes pas à l'origine de ce mouvement, veuillez nous contacter rapidement",
                        "greeting" => "Bonjour Ms/Md " . $user->name
                    ]));
                } catch (\Throwable $th) {
                    DB::rollback();
                    return response()->json(['message' => 'Erreur lors de l\'envoie du mail sur l\'adresse fournie, mais le mouvement a été effectué'], 500);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Ce mouvement de retrait a été effectué avec succès', 'data' => $stock2], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'Une erreur s\'est produite', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StockHistory $stockHistory)
    {
        return response()->json(['data' => $stockHistory->load(['category', 'demandeur'])]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockHistory $stockHistory)
    {
        $stock = StockHistory::where('category_id', $stockHistory->category_id)->orderByDesc('id')->first();
        $calculs = $request->quantity > $stock->quantity ?  $request->quantity - $stockHistory->quantity : - ($stockHistory->quantity - $request->quantity);
        $request['quantity_restante'] = $stock->quantity_restante - $calculs;

        if (isset($request->is_remise) && $request->is_remise == 1) {
            $entry = new EntryApiController();
            $req = new Request([
                "caracteristique" => "",
                "description" => "",
                "quantity" => $request->quantity,
                "category_id" => Category::find($request->category)->id,
                "quantity_restante" => $request->quantity_restante,
                "etat" => $request->etat,
            ]);
            $entry->store($req);
        }

        if ($request['quantity_restante'] >= 0) {
            $stockHistory->update($request->all());
            return response()->json(['message' => 'Mouvement mis à jour avec succès', 'data' => $stockHistory]);
        } else {
            return response()->json(['message' => "Le stock est inferieur a la quantite demande"], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockHistory $stockHistory)
    {
        $stockHistory->delete();
        return response()->json(['message' => 'Mouvement supprimé avec succès'], 200);
    }
    public function export_stock()
    {
        $sorties = StockHistory::where('type', 'withdraw')->with(['category', 'demandeur']);
        $entries = $entries = Entry::with(['category']);
        $inventories = StockHistory::with(['category'])
            ->orderByDesc("id")
            ->get()->unique('category_id');
        $data = [
            // ["title"=> "Inventaire",
            // "data"=>$inventories],
            [
                "title" => "Retrait materiel",
                "data" => $sorties
            ],
            [
                "title" => "Ajout materiel",
                "data" => $entries
            ]

        ];
        return Excel::download(new ExportExcelSheets($data), 'rapport_sortie_de_stock.xlsx');
        // return Excel::download(new ExportExcelSheets($data), 'rapport_sortie_de_stock.xlsx')->getFile();
    }
}
