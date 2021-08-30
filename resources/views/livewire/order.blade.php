<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-3">
                    <div class="form-group">
                        <label class="floating-label">Nomor Order</label>
                        <input class="form-control" wire:model.defer="filter.order_number" placeholder="Nomor Order">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="floating-label">Nama</label>
                        <input class="form-control" wire:model.defer="filter.name" placeholder="Nama">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="floating-label">Tanggal Awal</label>
                        <input type="date" class="form-control" wire:model.defer="filter.start_date"
                            placeholder="Tanggal Awal">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="floating-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" wire:model.defer="filter.end_date"
                            placeholder="Tanggal Akhir">
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label class="floating-label">Order Status</label>
                        <select class="form-control" wire:model.defer="filter.order_status">
                            <option value="">Pilih</option>
                            <option value="1">Verifikasi Admin lvl 1</option>
                            <option value="2">Persetujuan Admin Lvl 2</option>
                            <option value="3">Jadwal Pemasangan</option>
                            <option value="8">Pemasangan</option>
                            <option value="4">Order Selesai</option>
                            <option value="5">Ditolak Admin lvl 1</option>
                            <option value="6">Ditolak Admin lvl 2</option>
                            <option value="7">Order Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                    <label class="floating-label btn-block"> </label>
                        <button class="btn btn-primary" style="width:200px;" wire:click="loadList">Cari</button>
                    </div>
                </div>

                <div class="col-12">
                    <div class="text-right mb-2">
                        <button class="btn btn-success" wire:click="exportExcel">excel</button>
                    </div>
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Order</th>
                                    <th>Nama</th>
                                    <th>Nomor Identitas</th>
                                    <th>Telepon</th>
                                    <th>Order Status</th>
                                    <th>Total Harga</th>
                                    <th>Cara Pembayaran</th>
                                    <th>Status Pembayaran</th>
                                    <th>Tanggal Pemasangan</th>
                                    <th>Tanggal Order</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($orders))
                                @foreach($orders as $key => $order)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $order['order_number'] }}</td>
                                    <td>{{ $order['customer']['name'] }}</td>
                                    <td>{{ $order['customer']['id_number'] }}</td>
                                    <td>{{ $order['customer']['phone'] }}</td>
                                    <td>{{ \App\Consts\OrderStatus::toString($order['order_status']) }}</td>
                                    <td>{{ \App\Utils\FormatCurrency::toRupiah($order['total_price']) }}</td>
                                    <td>{{ \App\Consts\PaymentType::toString($order['payment_scheme']) }}</td>
                                    <td>{{ \App\Consts\PaymentStatus::toString($order['payment_status']) }}</td>
                                    <td>{{ $order['installation_date'] }}</td>
                                    <td>{{ $order['created_at'] }}</td>
                                    <td><a href="/order-detail/{{$order['id']}}"
                                            class="btn btn-primary">
                                            Detail
                                        </a></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-container">
                        <ul class="pagination">
                            <li class="page-item @if($page == 1) disabled @endif">
                                <a class="page-link" href="javascript:void(0)"
                                    wire:click="applyPagination('previous_page', {{ $page-1 }})">
                                    Previous
                                </a>
                            </li>

                            <li class="page-item @if($page == $paginator['last_page']) disabled @endif ">
                                <a class="page-link" href="javascript:void(0)" @if($page <=$paginator['last_page'])
                                    wire:click="applyPagination('next_page', {{ $page+1 }})" @endif>
                                    Next
                                </a>
                            </li>
                            <li class="page-item" style="margin: 0 5px">
                                Jump to Page
                            </li>

                            <li class="page-item" style="margin: 0 5px">
                                <select class="form-control" title="" style="width: 80px" wire:model="page">
                                    @for($i=1; $i<=$paginator['last_page']; $i++) <option value="{{ $i }}">{{ $i }}
                                        </option>
                                        @endfor
                                </select>
                            </li>

                            <li class="page-item" style="margin: 0 5px">
                                Items Per Page
                            </li>

                            <li class="page-item" style="margin: 0 5px">
                                <select class="form-control" title="" style="width: 80px" wire:model="items_per_page"
                                    wire:change="loadList">
                                    <option value="5">05</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>