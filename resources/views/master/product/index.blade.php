@extends('layouts.main')
@section('content')
  <div class="pagetitle">
    <h1>Product</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Product</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Data Produk</h5>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
              Tambah Produk
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
                  <th>Nama</th>
                  <th>Harga</th>
                  <th>Stok</th>
                  <th>Deskripsi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($produk as $item)
                  <tr>
                    <td>{{ $item->nama }}</td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->stok, 0, ',', '.') }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td class="">
                      <button class="btn btn-danger btn-xs" id="btn_delete" data-bs-target="#modalDeleteConfirm" data-bs-toggle="modal" data-id="{{ $item->id }}"><i class="fa fa-trash"></i></button>
                      <button class="btn btn-warning btn-xs" id="btn_edit" data-bs-target="#modalEdit" data-bs-toggle="modal" data-data='{{ $item }}'><i class="fa fa-pencil"></i></button>
                    </td>
                  </tr>
                @endforeach
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
        <form action="{{ url('product') }}" method="post">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="modalAddLabel">Tambah Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama">
            </div>
            <div class="mb-3">
              <label for="harga" class="form-label">Harga</label>
              <input type="number" class="form-control" id="harga" name="harga">
            </div>
            <div class="mb-3">
              <label for="harga" class="form-label">Stok</label>
              <input type="number" class="form-control" id="stok" name="stok">
            </div>
            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea type="text" rows="5" class="form-control" id="deskripsi" name="deskripsi"></textarea>
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
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama_edit" name="nama">
            </div>
            <div class="mb-3">
              <label for="harga" class="form-label">Harga</label>
              <input type="number" class="form-control" id="harga_edit" name="harga">
            </div>
            <div class="mb-3">
              <label for="harga" class="form-label">Stok</label>
              <input type="number" class="form-control" id="stok_edit" name="stok">
            </div>
            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea type="text" rows="5" class="form-control" id="deskripsi_edit" name="deskripsi"></textarea>
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
      let table = $('#transaksi').DataTable({});

      $('#transaksi').on('click', 'tbody td #btn_edit', function() {
        let data = $(this).data('data');
        $('#form_edit').attr('action', "{{ url('product/') }}" + '/' + data.id);
        $('#nama_edit').val(data.nama);
        $('#harga_edit').val(data.harga);
        $('#stok_edit').val(data.stok);
        $('#deskripsi_edit').val(data.deskripsi);
      })

      $('#transaksi').on('click', 'tbody td #btn_delete', function() {
        let id = $(this).attr('data-id');
        $('#form_delete').attr('action', "{{ url('product/') }}" + '/' + id);
      })
    })
  </script>
@endsection
