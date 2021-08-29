<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Orders;
use App\Exports\OrderExport;
use Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Order extends Component
{

    public $paginator = [];

    public $page = 1;

    public $items_per_page = 5;

    public $orders = [] ;
   
    public $filter = [
        "name" => "",
        "order_number" => "",
        "start_date" => "",
        "end_date" => ""
    ];

    protected $updatesQueryString = ['page'];

    public function mount(){
        $this->loadList();
    }

    public function render()
    {  
        return view('livewire.order')->extends('layouts.app');
    }

    public function loadList(){
        $query = [];

        $objects = Orders::with(['customer']);

        if(!empty($this->filter["order_number"])){
            $objects->where('order_number', 'LIKE', $this->filter['order_number'] . '%');
        }

        if(!empty($this->filter["start_date"]) && !empty($this->filter["end_date"])){
            $objects->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($this->filter['start_date'])), date('Y-m-d 23:59:59', strtotime($this->filter['end_date'])) ]);
        }

        if(!empty($this->filter["name"])){
            $objects->whereHas('customer', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->filter['name'] . '%');
            });
        }

        if(auth()->user()->can('admin lvl 1')){
            $objects->where('order_status', 1);
        }
         $objects = $objects->paginate($this->items_per_page);

         $this->paginator = $objects->toArray();

         $this->orders = $objects->items();
    }
    
    // public function format($orders)
    // {
    //     $orders->map(function($order) {
    //         $order['order_status'] = OrderStatus::toString($order['order_status']);
    //         $order['payment_scheme'] = PaymentType::toString($order['payment_scheme']);
    //         $order['payment_status'] = PaymentStatus::toString($order['payment_status']);
    //         return $order;
    //     });

    //     return $orders;
    // }

    public function applyPagination($action, $value, $options=[]){

        if( $action == "previous_page" && $this->page > 1){
            $this->page-=1;
        }

        if( $action == "next_page" ){
            $this->page+=1;
        }

        if( $action == "page" ){
            $this->page=$value;
        }

        $this->loadList();
    }

    public function exportExcel(){
        return Excel::download(new OrderExport($this->orders), "test.xlsx");
    }

}