@extends('layouts.main')
@section('content')
  <div class="pagetitle">
    <h1>Sales</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Penjualan Sales</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Data Sales</h5>
            <div class="alert alert-warning">
              Ada fitur perhitungan diskon secara otomatis (Jika qty >= 10 maka dapat diskon 15%, Jika qty >= 5 dapat diskon 10%, dan mendapatkan tambahan diskon 5% jika subtotal lebih dari Rp 500.000)
            </div>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
              Tambah Penjualan Sales
            </button>
            @if (session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif

            @if (session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif
            <table class="table" id="transaksi">
              <thead>
                <tr>
                  <th>Tanggal Transaksi</th>
                  <th>Nama Sales</th>
                  <th>Nama Product</th>
                  <th>Harga</th>
                  <th>Qty</th>
                  <th>Sub Total</th>
                  <th>Diskon</th>
                  <th>Sales Amount</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>

      </div>
  </section>

  <!-- Modal -->
  <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ url('sales') }}" method="post">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="modalAddLabel">Tambah Penjualan Sales</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="tanggal_transaksi" class="form-label">Tanggal</label>
              <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ date('Y-m-d') }}">
            </div>
            <div class="mb-3">
              <label for="nama" class="form-label">Sales Person</label>
              <select class="form-select" aria-label="Default select example" id="sales_person_id" name="sales_person_id" required>
                <option selected disabled>pilih</option>
                @foreach ($sales_person as $item)
                  <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="products_id" class="form-label">Product</label>
              <select class="form-select" aria-label="Default select example" id="products_id" name="products_id" required>
                <option selected disabled>pilih</option>
                @foreach ($product as $item)
                  <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="qty" class="form-label">Qty</label>
              <input type="number" class="form-control" id="qty" name="qty">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" id="form_edit">
          @method('put')
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditLabel">Edit Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="tanggal_transaksi" class="form-label">Tanggal</label>
              <input type="date" class="form-control" id="tanggal_transaksi_edit" name="tanggal_transaksi">
            </div>
            <div class="mb-3">
              <label for="nama" class="form-label">Sales Person</label>
              <select class="form-select" aria-label="Default select example" id="sales_person_id_edit" name="sales_person_id" required>
                <option selected disabled>pilih</option>
                @foreach ($sales_person as $item)
                  <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="products_id" class="form-label">Product</label>
              <select class="form-select" aria-label="Default select example" id="products_id_edit" name="products_id" required>
                <option selected disabled>pilih</option>
                @foreach ($product as $item)
                  <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="qty" class="form-label">Qty</label>
              <input type="number" class="form-control" id="qty_edit" name="qty">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(function() {
      let table = $('#transaksi').DataTable({
        order: [
          [0, 'asc']
        ],
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ url('sales/data') }}",
          type: 'GET',
          data: function(d) {
            d.search = $('#transaksi input[type="search"]').val();
          }
        },
        columns: [{
            data: 'tanggal_transaksi',
            name: 'tanggal_transaksi',
            className: 'text-center'
          },
          {
            data: 'sales',
            name: 'sales',
            className: 'text-center'
          },
          {
            data: 'product',
            name: 'product',
            className: 'text-center'
          },
          {
            data: 'harga',
            name: 'harga',
            className: 'text-center'
          },
          {
            data: 'qty',
            name: 'qty',
            className: 'text-center'
          },
          {
            data: 'sub_total',
            name: 'sub_total',
            className: 'text-center'
          },
          {
            data: 'diskon',
            name: 'diskon',
            className: 'text-center'
          },
          {
            data: 'sales_amount',
            name: 'sales_amount',
            className: 'text-center'
          },
          {
            data: 'aksi',
            name: 'aksi',
            className: 'text-center'
          },
        ],
      });
    })

    $('#transaksi').on('click', 'tbody td #btn_edit', function() {
      let data = $(this).data('data');
      $('#form_edit').attr('action', "{{ url('sales/') }}" + '/' + data.id);
      $('#tanggal_transaksi_edit').val(data.tanggal_transaksi);
      $('#sales_person_id_edit').val(data.sales_person_id);
      $('#products_id_edit').val(data.products_id);
      $('#qty_edit').val(data.qty);
    })

    $('#transaksi').on('click', 'tbody td #btn_delete', function() {
      let id = $(this).attr('data-id');
      $('#form_delete').attr('action', "{{ url('sales/') }}" + '/' + id);
    })
  </script>
@endsection
