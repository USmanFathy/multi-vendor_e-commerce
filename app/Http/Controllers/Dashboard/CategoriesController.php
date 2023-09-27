<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
//use Mockery\Exception;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();
        $query = Category::query();
        if($name = $request->query('name')){ //asigned and comparing
            $query->where('name','LIKE' , "%{$name}%");
        }
        if($status = $request->query('status')){ //asigned and comparing
            $query->wherestatus($status);
        }
        $categories = $query->paginate(1); // get all data in this model return collection object not array
        return view('Dashboard.categories.index' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('Dashboard.categories.create' , compact('parents' , 'category'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
       // $request->post('name');
//        $request->query('name'); specific for query in action
//        $request->get();
//    $request->name;
//        $request['name'] don't prefer
//        $request->all(): return array of all input data
//        $request->only([]);

        //request merge
//        $request->validate([
//            'name'      =>'required|string|min:3|max:255',
//            'parent_id' =>[
//                'int' , 'exists:categories,id' ,'nullable'
//            ],
//            'image'    =>[
//                'image','max:1048576','dimensions:width=150 , height=100'
//            ],
//            'status' => 'in:active,archived'
//        ]);
        $request->merge([
            'slug'=>Str::slug($request->post('name')),
        ]);
        $data = $request->except('image');
//        if ($request->hasFile('image')){
//            $file =$request->file('image'); //uploaded file
//            $path =$file->storeAs('categories/' ,$file->getClientOriginalName(), 'public');
////            $request->merge([
////                    'image' => $path
////                ]);
//            $data['image']=$path;
//        }


        $data['image']=$this->uploadImage($request);
        //Sport clothes # slug = sport-clothes

         // mass assignment
        $category = Category::create($data);
        // PRG post redirect get

        return redirect()->route('categories.index')->with('success' ,'Category Created!');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $category = Category::findOrFail($id);
        $parents = Category::where('id' , '<>' ,$id)
            ->where(function ($query ) use ($id){
                $query->whereNull('parent_id')
                    ->orwhere('parent_id' ,'!=', $id);
            })
            ->get();
        return view('Dashboard.categories.edit' , compact('category' ,'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {

        $category = Category::findOrFail($id);

//        try {
//
//        }catch (Exception $e){
//
//        }
        $old_image = $category->image;

        $data = $request->except('image');
        $path=$this->uploadImage($request);

        if ($path){
            $data['image'] = $path;
        }


        $category->update($data);


        if($old_image && $path){
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('categories.index')->with('info' ,'Category Edited!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        if ($category->image){
            Storage::disk('public')->deleteDirectory('categories/'.$category->name);        }


        return redirect()->route('categories.index')->with('danger' ,'Category deleted!');

    }
    protected function uploadImage(CategoryRequest $request){
        if (!$request->hasFile('image')) {
            return;
        }
            $file =$request->file('image'); //uploaded file
            $path =$file->storeAs('categories/'.$request->name ,$file->getClientOriginalName(), 'public');

            return $path ;
    }





}
