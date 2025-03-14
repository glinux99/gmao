<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entry;
use App\Models\StockHistory;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries=Entry::with(['category'])->latest()->get();
        $categories=Category::with('unity')->get();
        $title = 'Supprimer cette entree!';
        $text = "Voulez-vous supprimer cette entree?";
        confirmDelete($title, $text);
        return view('entry.entries',['entries'=>$entries, 'categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $entry= Entry::create($request->all());
        $stock=StockHistory::where('category_id', $request->category_id)
        ->orderByDesc('id')->first();
        if(!$stock){
            StockHistory::create([
                "entry_id"=>$entry->id,
                "category_id"=>$entry->category_id,
                "quantity"=>$request->quantity,
                "quantity_restante"=>$request->quantity,
                "etat"=>$request->etat,
                "type"=>"entry"
            ]);
        }
        else{
            $stock->update([
                "quantity_restante"=>$stock->quantity_restante+$request->quantity
            ]);
            $entry->update([
                "quantity_restante"=>$stock->quantity_restante+$request->quantity
            ]);
        }

        return  redirect()->route('entries.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entry $entry)
    {
        $categories=Category::all();
        return view('entry.entry',['entry'=>$entry, 'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entry $entry)
    {
        $entry2=$entry;
        $calculs = ($request->quantity > $entry->quantity) ? $request->quantity - $entry->quantity : $entry->quantity - $request->quantity;

        $entry->update($request->all());


        $stock= StockHistory::where('category_id', $entry->category_id)
        ->orderByDesc('id')->first();
        if($calculs){
            $stock->update(
                ['quantity_restante'=>$stock->quantity_restante +$calculs]
            );
        }else{
            $stock->update(
                ['quantity_restante'=>$stock->quantity_restante-$calculs]
            );
        }
        $entry->update(['quantity_restante'=>$stock->quantity_restante]);
        return redirect()->route('entries.edit', $entry);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        $stock= StockHistory::where('category_id', $entry->category_id)
        ->orderByDesc('id')->first();
        $stock->update(['quantity_restante'=>$stock->quantity_restante - $entry->quantity]);
        $entry->delete();
        return redirect()->route('entries.index');
    }
}
