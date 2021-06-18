<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithPagination, WithFileUploads;

    public $name,$barcode,$cost,$price,$stock,$alerts,$category_id,$image,$search,$selected_id,$pageTitle,$componentName;
    private $pagination = 5;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->categoryId = 'Elegir';
    }
    public function render()
    {
        $categories = Category::select('id','name')->orderBy('name', 'asc')->get();
        if (strlen($this->search) > 0) {
            $products = Product::join('categories as c', 'c.id','products.category_id')
                            ->select('products.*','c.name as category')
                            ->where('products.name', 'like', '%' . $this->search . '%')
                            ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                            ->orWhere('c.name', 'like', '%' . $this->search . '%')
                            ->orderBy('products.name','asc')
                            ->paginate($this->pagination);

        }else {
            $products = Product::join('categories as c', 'c.id','products.category_id')
            ->select('products.*','c.name as category')
             ->orderBy('products.name','asc')
            ->paginate($this->pagination);
        }
        return view('livewire.products.products', compact('products','categories'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:products|min:3',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'category_id' => 'required|not_in:Elegir'
        ];


        $this->validate($rules);

        $product = Product::create([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->category_id
        ]);
        $customFileName;

        if ($this->image) {
            $customFileName = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }

        $this->resetUI();

        $this->emit('product-added', 'Producto registrado');
    }
    public function Edit(Product $product)
    {
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->price = $product->price;
        $this->cost = $product->cost;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->image = null;
        $this->category_id = $product->category_id;

        $this->emit('modal-show', 'Show modal');


    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'category_id' => 'required|not_in:Elegir'
        ];


        $this->validate($rules);
        $product = Product::find($this->selected_id);
        $product->update([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->category_id
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $imageTemp = $product->image;
            $product->image = $customFileName;
            $product->save();

            if ($imageTemp != null) {
                if (file_exists('storage/products/' . $imageTemp )) {
                    unlink('storage/products/' . $imageTemp);
                }
            }
        }

        $this->resetUI();

        $this->emit('product-updated', 'Producto actualizado');

    }

    public function Destroy(Product $product)
    {
        $imageTemp = $product->image;

        $product->delete();

        if ($imageTemp != null) {
            if (file_exists('storage/products/' . $imageTemp )) {
                unlink('storage/products/' . $imageTemp);
            }
        }

        $this->resetUI();
        $this->emit('product-deleted', 'Producto eliminado');
    }
    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
        $this->cost = '';
        $this->price = '';
        $this->barcode = '';
        $this->category_id = 'Elegir';
        $this->alerts = '';
        $this->stock = '';
    }
}
