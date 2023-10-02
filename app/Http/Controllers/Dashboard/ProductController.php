<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();
        $products = Product::with(['category' , 'store'])->search($request->query())->paginate();
        // select all from products
        // select all from categories where id in (*)
        // select all from stores where id in (*)

        return view('Dashboard.products.index' , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $product = new Product();
        $tags = new Tag();
        return view('Dashboard.products.create' , compact('product' , 'tags','categories' ));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      =>'required|string|min:3|max:255',
            'parent_id' =>[
                'int' , 'exists:categories,id' ,'nullable'
            ],
            'image'    =>[
                'image','max:1048576','dimensions:width=150 , height=100'
            ],
            'status' => 'in:active,archived,draft'
        ]);
        $request->merge([
            'slug'=>Str::slug($request->post('name')),
        ]);
        $data = $request->except('image' );
        $path=$this->uploadImage($request);

        if ($path){
            $data['image'] = $path;
        }
        $product = Product::create($data);
        return redirect()->route('products.index')->with('success' , 'Product Created!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $tags = implode(',' ,$product->tags()->pluck('name')->toArray());
        return view('Dashboard.products.edit' , compact('product' , 'tags','categories' ));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
                $request->validate([
            'name'      =>'required|string|min:3|max:255',
            'parent_id' =>[
                'int' , 'exists:categories,id' ,'nullable'
            ],
            'image'    =>[
                'image','max:1048576','dimensions:width=150 , height=100'
            ],
            'status' => 'in:active,archived,draft'
        ]);
        $old_image = $product->image;
        $data = $request->except('image' );
        $path=$this->uploadImage($request);

        if ($path){
            $data['image'] = $path;
        }


        $product->update($data);


        $tags = json_decode($request->post('tags'));


        $saved_tags = Tag::all();
        foreach ($tags as $t_name)
        {
            $slug = Str::slug($t_name->value);
            $tag = $saved_tags->where('slug' , $slug)->first();
            if(!$tag){
                $tag = Tag::create([
                    'name' => $t_name->value ,
                    'slug' => $slug
                ]);

            }
            $tags_id[] = $tag->id;
        }

        $product->tags()->sync($tags_id);

        if($old_image && $path){
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('products.index')->with('info' ,'Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('danger' ,'Product Deleted!');

    }
    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file =$request->file('image'); //uploaded file
        $path =$file->storeAs('Products/'.$request->name ,$file->getClientOriginalName(), 'public');

        return $path ;
    }
    public function trash()
    {
        $request = request();
        $products = Product::onlyTrashed()->search($request->query())->paginate();
        return view('Dashboard.products.trash' , compact('products'));

    }
    public function restore(Request $request,$id)
    {
        $product= Product::onlyTrashed()->findOrFail($id);
        $product->restore($id);
        return redirect()->route('products.trash')
            ->with('success' , 'Product restored!');
    }

    public function force_delete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete($id);
        if ($product->image){
            Storage::disk('public')->deleteDirectory('Products/'.$product->name);        }

        return redirect()->route('products.trash')
            ->with('danger' , 'Product deleted forever!');
    }
}
