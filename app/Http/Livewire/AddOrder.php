<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Products;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\OrderStatuses;
use App\Models\Payments;
use App\Models\Discounts;
use Livewire\WithFileUploads;
use Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AddOrder extends Component
{
    use WithFileUploads;

    public $name, $id_number, $type, $address, $phone, $installation_address,
        $pic_contact, $document, $document_name;
    public $suggestCustomers;
    public $customer;
    public $products;
    public $cart = [];
    public $total_price = 0;
    public $discounts, $discount;
    public $discount_amount = 0;
    public $payment_scheme;
    public $grand_price = 0;
    

    protected $rules = [
        'name' => 'required',
        'id_number'=> 'required',
        'type'=> 'required',
        'address'=> 'required',
        'phone' => 'required',
        'document'=> 'required',
        'installation_address' =>'required',
        'pic_contact'=>'required',
        'payment_scheme' => 'required'
    ];

    public function mount(){
        $this->products = Products::get();
        $this->discounts = Discounts::get();
    }

    public function render()
    {
        return view('livewire.add-order')->extends('layouts.app');
    }

    public function addItem($id, $name, $price, $category){
        $key = array_search($id, array_column($this->cart, 'id'), true);
        if($key !== false){
            $this->cart[$key]['qty']++;
            $this->cart[$key]['total'] = $this->cart[$key]['price'] * $this->cart[$key]['qty'];
        }else{
            $this->cart[] =  ['id'=>$id, 'name'=> $name, 'qty'=>1, 'price'=>$price, 'total'=>$price, 'category' => $category];
        }   

        $this->sumPrice();
    }

    public function removeItem($id){
        $key = array_search($id, array_column($this->cart, 'id'), true);
        if($key !== false){
            $this->cart[$key]['qty']--;
            if($this->cart[$key]['qty'] == 0)  unset($this->cart[$key]);
        } 

        $this->sumPrice();
    }

    private function sumPrice(){  
        $this->total_price = 0;
        foreach($this->cart as $index => $key){
            $this->total_price += $key['price'] * $key['qty'];
        }
        $this->calculateDiscount();
        $this->grand_price = $this->total_price - $this->discount_amount;
    }

    public function setCustomer($id){
        $this->customer = Customers::where('id', $id )->first();
        if ($this->customer) {
            $this->phone = $this->customer->phone;
            $this->name = $this->customer->name;
            $this->address = $this->customer->address;
            $this->type = $this->customer->type;
            $this->id_number = $this->customer->id_number;
        }
        $this->suggestCustomers = null;
    }

    public function updatedIdNumber(){
        if (strlen($this->id_number > 4)) {
            $this->suggestCustomers = Customers::where('id_number', 'like', $this->id_number . '%')->limit(3)->get();
        } else {
            $this->suggestCustomers = [];
        }
    }

    public function updatedPaymentScheme(){
        $this->sumPrice();
    }

    public function updatedDiscount(){
        $this->sumPrice();
    }

    public function updatedDocument(){
        $this->validate([
            'document' => 'mimes:pdf,png,jpg,jpeg|file|max:1024',
        ]);
    
        $this->document_name = $this->document->store('public');

    }

    private function calculateDiscount(){
        if ($this->discount != "" ){
            
            if(empty($this->cart)){
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Pilih barang dulu',
                    'timer'=>3000,
                    'icon'=>'error',
                    'toast'=>true,
                    'position'=>'top-right'
                ]);
                $this->discount = "";

            }else if(empty($this->payment_scheme)){
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Pilih skema pembayaran',
                    'timer'=>3000,
                    'icon'=>'error',
                    'toast'=>true,
                    'position'=>'top-right'
                ]);
                $this->discount = "";
            }
           
            if($this->discount == 1 && $this->payment_scheme == 1){
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Diskon diterapkan',
                    'timer'=>3000,
                    'icon'=>'success',
                    'toast'=>true,
                    'position'=>'top-right'
                ]);

                $this->discount_amount = Discounts::where('id', $this->discount)->first()->price;
            }elseif($this->discount == 2 && $this->payment_scheme > 2){
                $isCategory2 = false;
                foreach($this->cart as $product){
                    if ($product['category'] == 2) $isCategory2 = true; else $isCategory2 = false;
                }
                if($isCategory2){
                    $this->dispatchBrowserEvent('swal', [
                        'title' => 'Diskon diterapkan',
                        'timer'=>3000,
                        'icon'=>'success',
                        'toast'=>true,
                        'position'=>'top-right'
                    ]);
    
                    $this->discount_amount = Discounts::where('id', $this->discount)->first()->price;
                }else{
                    $this->discount_amount = 0;
                    $this->dispatchBrowserEvent('swal', [
                        'title' => 'Diskon tidak dapat dipakai',
                        'timer'=>3000,
                        'icon'=>'error',
                        'toast'=>true,
                        'position'=>'top-right'
                    ]);
                    $this->discount = "";
                }
            }else{
                $this->discount_amount = 0;
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Diskon tidak dapat dipakai',
                    'timer'=>3000,
                    'icon'=>'error',
                    'toast'=>true,
                    'position'=>'top-right'
                ]);
                $this->discount = "";
            }  
            
        }else{
            $this->discount_amount = 0;
        }
    }

    public function submit(){
        $this->validate();

        $admin_id = Auth::id();

        $cust_id = Customers::create($this->id_number, [
            'type'=>$this->type,
            'name'=>$this->name,
            'address'=>$this->address, 
            'phone'=>$this->phone,    
        ])->id;

        //1 lunas, 0 belum lunas
        if ($this->payment_scheme == 1) $payment_status = 2;
        else $payment_status = 1;

        $order_id = Orders::create([
            'order_number'=>Orders::genOrderNum(),
            'customer_id'=>$cust_id,
            'discount_id'=>$this->discount,
            'installation_address'=>$this->installation_address,
            'pic_contact'=>$this->pic_contact,
            'document'=>str_replace('public/','',$this->document_name),
            'order_status'=>1,
            'total_price'=>$this->total_price,
            'discount_amount'=>$this->discount_amount,
            'grand_price' =>$this->grand_price,
            'payment_scheme'=> $this->payment_scheme,
            'payment_status' => $payment_status,
        ])->id;

        OrderStatuses::create([
            'orders_id'=>$order_id,
            'users_id'=>$admin_id,
            'order_status'=>1,
        ]);

        foreach($this->cart as $product){
            OrderDetails::create([
                'orders_id' => $order_id,
                'products_id'=>$product['id'],
                'name' => $product['name'],
                'qty' => $product['qty'],
                'price' => $product['price'],
                'total' => $product['total'],
            ]);
        }

        if ($this->payment_scheme == 1){
            Payments::create([
                'orders_id' => $order_id,
                'payment_number'=> Payments::genOrderNum(),
                'price' => $this->total_price,
                'payment_date' => now(),
                'payment_status'=>2,
            ]);
        }else{
            for($i = 0; $i < $this->payment_scheme; $i++){
                $installment = $this->total_price / $this->payment_scheme;
                Payments::create([
                    'orders_id' => $order_id,
                    'payment_number'=> Payments::genOrderNum(),
                    'price' => $installment,
                    'payment_date' =>NULL,
                    'payment_status'=>1,
                ]);
            }
        }

        redirect()->route('add-order');
    } 

}

