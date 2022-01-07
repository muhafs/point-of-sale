<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //! INDEX
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    //! CREATE
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    //! STORE
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'image' => 'image',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ]);

        $validated = $request->except(['image']);

        if ($request->image) {
            //? create instance
            $image = Image::make($request->image);
            //? resize the image to a width of 300 and constrain aspect ratio (auto height)
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //? save the same file as jpg with default quality
            $image->save('uploads/products/' . $request->image->hashName());

            $validated['image'] = $image->basename;
        }

        Product::create($validated);

        return redirect('products')->with('success', 'Product has been added successfully');
    }

    //! EDIT
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    //! UPDATE
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'image' => 'image',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ]);

        $validated = $request->except(['image']);

        if ($request->image) {
            //? Delete the stored image
            if ($product->image !== 'default.png') {
                Storage::disk('public_uploads')->delete('/products/' . $product->image);
            }

            //? create instance
            $image = Image::make($request->image);
            //? resize the image to a width of 300 and constrain aspect ratio (auto height)
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //? save the same file as jpg with default quality
            $image->save('uploads/products/' . $request->image->hashName());

            $validated['image'] = $image->basename;
        }

        $product->update($validated);

        return redirect('products')->with('success', 'Product has been updated successfully');
    }

    //! DESTROY
    public function destroy(Product $product)
    {
        if ($product->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/products/' . $product->image);
        }
        $product->delete();

        return redirect('products')->with('success', 'Admin has been deleted successfully');
    }
}
