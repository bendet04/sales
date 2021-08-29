<div class="row">
    <div class="col-3">
        <div class="card mb-1">
            <div class="card-header pb-0">
                <h4>Customer</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nomor Identitas</label>
                    <input type="text" wire:model="id_number" class="form-control">
                    <span class="text-danger">@error('id_number')
                        {{ $message }}
                        @enderror</span>
                    @if($suggestCustomers)
                    <ul class="list-group position-absolute w-100 shadow">
                        @foreach($suggestCustomers as $suggestCustomer)
                        <li class="list-group-item list-group-item-action"
                            wire:click="setCustomer({{$suggestCustomer->id}})">
                            <small>{!! str_replace($id_number,'<span
                                    class="bg-warning">'.$id_number.'</span>',$suggestCustomer->id_number)
                                !!}</small>
                            <p class="m-1">{{$suggestCustomer->name}}</p>
                        </li>
                        @endforeach
                        <li class="list-group-item list-group-item-action" wire:click="setCustomer(0)">
                            <small>Tutup Daftar</small>
                        </li>
                    </ul>
                    @endif
                </div>
                <div class="form-group">
                    <label>Nomor Handphone</label>
                    <input type="text" wire:model="phone" class="form-control" @if($customer) readonly @endif>
                    <span class="text-danger">@error('phone')
                        {{ $message }}
                        @enderror</span>
                </div>
                <div class="form-group">
                    <label>Tipe Pelanggan</label>
                    <select wire:model="type" class="form-control" @if($customer) disabled @endif>
                        <option selected>Pilih Tipe</option>
                        <option value="1">Individu</option>
                        <option value="2">Korporat</option>
                    </select>
                    <span class="text-danger">@error('type')
                        {{ $message }}
                        @enderror</span>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" wire:model="name" class="form-control" @if($customer) readonly @endif>
                    <span class="text-danger">@error('name')
                        {{ $message }}
                        @enderror</span>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" wire:model="address" class="form-control" @if($customer) readonly @endif>
                    <span class="text-danger">@error('address')
                        {{ $message }}
                        @enderror</span>
                </div>
            </div>
        </div>
        <div class="card mb-1">
            <div class="card-body">
                <div class="form-group">
                    <label>Alamat Pemasangan</label>
                    <input type="text" wire:model="installation_address" class="form-control">
                    <span class="text-danger">@error('installation_address')
                        {{ $message }}
                        @enderror</span>
                </div>
                <div class="form-group">
                    <label>PIC Kontak</label>
                    <input type="text" wire:model="pic_contact" class="form-control">
                    <span class="text-danger">@error('pic_contact')
                        {{ $message }}
                        @enderror</span>
                </div>
            </div>
        </div>
        <div class="card mb-1">
            <div class="card-body">
                <div class="form-group">
                    <label>Upload Dokumen</label>
                    <input type="file" wire:model="document" class="form-control">
                    <span class="text-danger">@error('document')
                        {{ $message }}
                        @enderror</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-5">
        <div class="card">
            <div class="card-header pb-0">
                <h4>Products</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($products)
                    @foreach($products as $product)
                    <div class="col-md-4 mb-3">
                        <div class="border shadow-sm rounded-sm mb-2">
                            <div style="min-height: 112px;">
                                <div class="px-2 pt-2 d-flex justify-content-between">
                                    <h1></h1>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h5>{{ $product->name }}</h5>
                            <h6>{{ \App\Utils\FormatCurrency::toRupiah($product->price) }} </h6>
                            <button class="btn btn-primary"
                                wire:click="addItem({{ $product->id }}, '{{$product->name}}', {{$product->price}}, {{$product->category}} )">Add
                                to
                                cart</button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="table-responsive" style="height: 300px;">
                            <table class="table table-borderless">
                                <thead>
                                    <th style="min-width:100px">Nama</th>
                                    <th style="min-width:100px">Harga</th>
                                    <th style="min-width:120px">Kuantitas</th>
                                    <th style="min-width:100px">Sub Total</th>
                                </thead>
                                <tbody>
                                    @if(!empty($cart[0]))
                                    @foreach($cart as $index => $product)
                                    <tr>
                                        <td>{{$product['name']}}</td>
                                        <td>{{ \App\Utils\FormatCurrency::toRupiah( $product['price'] )}}</td>
                                        <td><button class="btn btn-danger btn-sm" wire:click="removeItem( {{ $product['id'] }} )"><i class="fa fa-minus-circle"></i></button>
                                                {{$product['qty']}}
                                            <button class="btn btn-success btn-sm" wire:click="addItem( {{ $product['id'] }}, '{{$product['name']}}', {{$product['price']}}, {{$product['category']}})"><i class="fa fa-plus-circle"></i></button>
                                        </td>
                                        <td>{{ \App\Utils\FormatCurrency::toRupiah( $product['total']) }}</td>
                                    </tr>
                                    @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mb-2 pb-0">
                    <div class="card-body">
                        <div class="form-group">
                            <select class="form-control" wire:model='payment_scheme'>
                                <option selected>Skema Pembayaran</option>
                                <option value="1">Tunai</option>
                                <option value="12">Cicilan 12 Bulan</option>
                                <option value="24">Cicilan 24 Bulan</option>
                                <option value="36">Cicilan 36 Bulan</option>
                            </select>
                            <span class="text-danger">@error('payment_scheme')
                                {{ $message }}
                                @enderror</span>
                        </div>
                        <div class="form-group">
                            <select class="form-control" wire:model="discount">
                                <option value="" selected>Pilih Diskon</option>
                                @foreach ($discounts as $discount)
                                    <option value="{{$discount->id}}">{{$discount->name}} || {{\App\Utils\FormatCurrency::toRupiah( $discount->price )}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <table class="table table-sm table-borderless text-right mt-2 mb-0">
                        <tbody>
                            <tr>
                                <td>Total </td>
                                <td>
                                    {{ \App\Utils\FormatCurrency::toRupiah($total_price) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td>{{ \App\Utils\FormatCurrency::toRupiah( $discount_amount)  }}</td>
                            </tr>
                            <tr>
                                <td>Grand Total </td>
                                <td>
                                    <h4>{{ \App\Utils\FormatCurrency::toRupiah( $grand_price) }}</h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card">
                    <button class="btn btn-success" wire:click="submit">Simpan Transaksi</button>
                </div>
            </div>
        </div>
    </div>
</div>
