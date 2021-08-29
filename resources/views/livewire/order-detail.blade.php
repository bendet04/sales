<div class="row">
    <div class="col-8">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5>Detail Barang</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kuantitas</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        @foreach ($order_detail->orderDetail as $index => $product)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->qty}}</td>
                            <td>{{\App\Utils\FormatCurrency::toRupiah($product->price)}}</td>
                            <td>{{\App\Utils\FormatCurrency::toRupiah($product->total)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right">Diskon</td>
                            <td>{{\App\Utils\FormatCurrency::toRupiah($order_detail->discount_amount) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Total</td>
                            <td>{{\App\Utils\FormatCurrency::toRupiah($order_detail->grand_price) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header pb-0">
                <h5>Detail Pembayaran</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Nomor Pembayaran</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal Pembayaran</th>
                    </thead>
                    <tbody>
                        @foreach ($order_detail->paymentDetail as $index => $payment)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$payment->payment_number}}</td>
                            <td>{{$payment->price}}</td>
                            <td>{{\App\Consts\PaymentStatus::toString($payment->payment_status)}}</td>
                            <td>{{$payment->payment_date}}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5>Detail Order</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>Nomor Order</td>
                            <td>{{$order_detail->order_number}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Identitas</td>
                            <td>{{ $order_detail->customer->id_number}}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>{{ $order_detail->customer->name}}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>{{ $order_detail->customer->address}}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>{{ $order_detail->customer->phone}}</td>
                        </tr>
                        <tr>
                            <td>Alamat Pemasangan</td>
                            <td>{{$order_detail->installation_address}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pemasangan</td>
                            <td>{{$order_detail->installation_date}}</td>
                        </tr>
                        <tr>
                            <td>PIC Kontak</td>
                            <td>{{$order_detail->pic_contact}}</td>
                        </tr>
                        <tr>
                            <td>Cara Pembayaran</td>
                            <td>{{ \App\Consts\PaymentType::toString($order_detail->payment_scheme) }}</td>
                        </tr>
                        <tr>
                            <td>Status Pembayaran</td>
                            <td>{{ \App\Consts\PaymentStatus::toString($order_detail->payment_status) }}</td>
                        </tr>
                        <tr>
                            <td>Dokumen Identitas</td>
                            <td><a href="{{ asset('storage/'.$order_detail->document)}}" target="_blank"
                                    class="btn btn-success btn-block">Lihat</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @can('admin lvl 1')
                    <div class="col-6 mb-3">
                        <button class="btn btn-primary btn-block"
                            wire:click="changeStatus({{$order_detail->id}},3)">Terima</button>
                    </div>
                    <div class="col-6 mb-3">
                        <button class="btn btn-danger btn-block"
                            wire:click="changeStatus({{$order_detail->id}},7)">Tolak</button>
                    </div>
                    <div class="col-6 mb-3">
                        <button class="btn btn-info btn-block" wire:click="changeStatus({{$order_detail->id}},2)">Verif
                            Admin lvl 2</button>
                    </div>
                    @endcan
                    @can('admin lvl 2')
                    <div class="col-6 mb-3">
                        <button class="btn btn-primary btn-block"
                            wire:click="changeStatus({{$order_detail->id}},3)">Terima</button>
                    </div>
                    <div class="col-6 mb-3">
                        <button class="btn btn-danger btn-block"
                            wire:click="changeStatus({{$order_detail->id}},7)">Tolak</button>
                    </div>
                    @endcan
                    @can('technician')
                    @if($order_detail->order_status == 3)
                    <div class="col-12 mb-3">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tanggal Pemasangan</label>
                            <div class="col-md-9">
                                <input type="date" wire:model="installation_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <button class="btn btn-primary"
                            wire:click="changeStatus({{$order_detail->id}}, 8)">Simpan</button>
                    </div>
                    @elseif($order_detail->order_status == 8)
                    <div class="col-6">
                        <button class="btn btn-primary btn-block"
                            wire:click="changeStatus({{$order_detail->id}},4)">Instalasi Berhasil</button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-danger btn-block"
                            wire:click="changeStatus({{$order_detail->id}},7)">Insatalasi Gagal</button>
                    </div>
                    @endif
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tanggal Pemasangan</h5>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" wire:click="cek()">Simpan</button>
                <button type="button" class="btn btn-danger finish" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
