<?php

namespace App\Http\Controllers;

use App\Imports\ImportCategory;
use App\Models\Category;
use App\Models\Unity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $categories = Category::with('unity')->latest()->get();
        // $unities= Unity::all();
        // $title = 'Supprimer cette categorie!';
        // $text = "Voulez-vous supprimer cette categorie?";
        // confirmDelete($title, $text);
        // return view('categories.categories', ['categories'=>$categories, 'unities'=>$unities]);
        return view('categories.categories');
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

        if(!isset($request->is_remise)){
            $request['is_remise']=0;
        }
        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('categories');
            $request['avatar'] = $avatarPath;
            $category= Category::create($request->all());
            $fileName = substr(Str::uuid(),0,10).".".$avatar->getClientOriginalExtension();
            $path = $avatar->storeAs(
                '\/categories/',
                $fileName,
                'public'
            );
            $category->update(['avatar'=>'/storage/categories/'.$fileName]);

        }

        // Create a new user
        else {

            Category::create($request->except(['avatar']));

        }

        toast('L\'ajout de la categorie '.$request->designation.' s\'est effectuee avec success','success');

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            toast('La catégorie '.$category->designation.' a été supprimé ','success');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            //throw $th;
            toast('La catégorie '.$category->designation.' n\'a pas été supprimé car elle est utilisé','error');
            return redirect()->route('categories.index');
        }
    }
    public function import(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:xlsx,xls',
        // ]);

        try {
            Excel ::import(new ImportCategory, $request->file('file'));
            return response()->json([
                'message' => 'Categories imported successfully',
                'success' => true
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Row " . $failure->row() . ": " . implode(", ", $failure->errors());
            }
            return response()->json([
                'errors' => $errors,
                'message' => 'Validation error',
                'success' => false
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during import.',
                'success' => false
            ]);
        }
    }
}
