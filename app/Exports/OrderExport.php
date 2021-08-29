<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Log;
use \App\Consts\OrderStatus;

class OrderExport implements FromCollection, WithHeadings
{
    use Exportable;

    public $orders;

    public function __construct($orders){
        $this->orders = $orders; 
    }

    public function headings():array{
        return [ 'No','Nomor Order','Nama', 'Order Status'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $arrOrder;

        foreach($this->orders as $index => $order){
            $arrOrder[] =  [
                 $index + 1,
                 $order['order_number'],
                 $order['customer']['name'],
                 OrderStatus::toString($order['order_status']),
            ];
        }
        return collect($arrOrder);
    }
}
