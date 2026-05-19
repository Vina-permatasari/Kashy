<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Dipakai karyawan & owner untuk lihat stok
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return view('karyawan.stok-produk', compact('products'));
    }

    // Nanti dipakai owner untuk halaman daftar produk CRUD
    public function ownerIndex()
    {
        $products = Product::with('category')->latest()->get();

        return view('owner.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('owner.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // nanti kita isi pas masuk CRUD owner
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('owner.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // nanti kita isi pas masuk CRUD owner
    }

    public function destroy(Product $product)
    {
        // nanti kita isi pas masuk CRUD owner
    }
}