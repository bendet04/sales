<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Orders;
use App\Models\OrderStatuses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class OrderDetail extends Component
{

    public $order_detail;
    public $installation_date;
    
    public function mount($order_id)
    {
        $this->order_detail = Orders::with(['customer','orderDetail','paymentDetail','discount'])->where('id', $order_id)->first();
    }

    public function render()
    {
        return view('livewire.order-detail')->extends('layouts.app');
    }

    public function changeStatus($id, $status){
        $user_id = Auth::id();
        $params = ['order_status' => $status];

        if(!empty($this->installation_date)) $params ['installation_date'] = $this->installation_date;

        Orders::where('id', $id)->update($params);
        OrderStatuses::create(['orders_id'=>$id,'users_id'=>$user_id, 'order_status'=>$status]);

        
        redirect()->route('order');
    }
}
