@extends('layouts.main')
@section('content')
  <div class="pagetitle">
    <h1>Sales Person</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Sales Person</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Data Sales Person</h5>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
              Tambah Sales Person
            </button>
            <table class="table" id="transaksi">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>No HP</th>
                  <th>Provinsi</th>
                  <th>Kabupaten</th>
                  <th>Kecamatan</th>
                  <th>Kelurahan</th>
                  <th>Alamat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($sales_person as $item)
                  <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td>{{ $item->nama_provinsi }}</td>
                    <td>{{ $item->nama_kabupaten }}</td>
                    <td>{{ $item->nama_kecamatan }}</td>
                    <td>{{ $item->nama_kelurahan }}</td>
                    <td>{{ $item->alamat }}</td>
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
        <form action="{{ url('sales-person') }}" method="post">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="modalAddLabel">Tambah Sales Person</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nama" class="form-label">User</label>
              <select class="form-select" aria-label="Default select example" id="user_id" name="user_id" required>
                <option selected value="" disabled>pilih</option>
                @foreach ($user as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
              <label for="no_hp" class="form-label">No HP</label>
              <input type="number" class="form-control" id="no_hp" name="no_hp">
            </div>
            <div class="mb-3">
              <label for="provinsi" class="form-label">Provinsi</label>
              <select class="form-select" aria-label="Default select example" id="provinsi_id" name="provinsi_id">
                <option selected>pilih</option>
              </select>
              <input type="hidden" name="nama_provinsi" id="nama_provinsi">
            </div>
            <div class="mb-3">
              <label for="kabupaten" class="form-label">Kabupaten</label>
              <select class="form-select" aria-label="Default select example" id="kabupaten_id" name="kabupaten_id">
                <option selected>pilih</option>
              </select>
              <input type="hidden" name="nama_kabupaten" id="nama_kabupaten">
            </div>
            <div class="mb-3">
              <label for="kecamatan" class="form-label">Kecamatan</label>
              <select class="form-select" aria-label="Default select example" id="kecamatan_id" name="kecamatan_id">
                <option selected>pilih</option>
              </select>
              <input type="hidden" name="nama_kecamatan" id="nama_kecamatan">
            </div>
            <div class="mb-3">
              <label for="kelurahan" class="form-label">Kelurahan</label>
              <select class="form-select" aria-label="Default select example" id="kelurahan_id" name="kelurahan_id">
                <option selected>pilih</option>
              </select>
              <input type="hidden" name="nama_kelurahan" id="nama_kelurahan">
            </div>
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <textarea type="text" rows="5" class="form-control" id="alamat" name="alamat"></textarea>
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
            <h5 class="modal-title" id="modalEditLabel">Edit Sales Person</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nama" class="form-label">User</label>
              <select class="form-select" aria-label="Default select example" id="user_id_edit" name="user_id" required>
                <option selected value="" disabled>pilih</option>
                @foreach ($user as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama_edit" name="nama" required>
            </div>
            <div class="mb-3">
              <label for="no_hp" class="form-label">No HP</label>
              <input type="number" class="form-control" id="no_hp_edit" name="no_hp">
            </div>
            <div class="mb-3">
              <label for="provinsi" class="form-label">Provinsi</label>
              <select class="form-select" aria-label="Default select example" id="provinsi_id_edit" name="provinsi_id">
                <option selected>pilih</option>
              </select>
              <input type="hidden" name="nama_provinsi" id="nama_provinsi_edit">
            </div>
            <div class="mb-3">
              <label for="kabupaten" class="form-label">Kabupaten</label>
              <select class="form-select" aria-label="Default select example" id="kabupaten_id_edit" name="kabupaten_id">
                <option selected>pilih</option>
              </select>
              <input type="hidden" name="nama_kabupaten" id="nama_kabupaten_edit">
            </div>
            <div class="mb-3">
              <label for="kecamatan" class="form-label">Kecamatan</label>
              <select class="form-select" aria-label="Default select example" id="kecamatan_id_edit" name="kecamatan_id">
                <option selected>pilih</option>
              </select>
              <input type="hidden" name="nama_kecamatan" id="nama_kecamatan_edit">
            </div>
            <div class="mb-3">
              <label for="kelurahan" class="form-label">Kelurahan</label>
              <select class="form-select" aria-label="Default select example" id="kelurahan_id_edit" name="kelurahan_id">
                <option selected>pilih</option>
              </select>
              <input type="hidden" name="nama_kelurahan" id="nama_kelurahan_edit">
            </div>
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <textarea type="text" rows="5" class="form-control" id="alamat_edit" name="alamat"></textarea>
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

      let list_provinsi = [],
        list_kabupaten = [],
        list_kecamatan = [],
        list_kelurahan = [];

      loadWilayah('#provinsi_id', 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json').then(data => list_provinsi = data);
      loadWilayah('#provinsi_id_edit', 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');

      $('#transaksi').on('click', '#btn_edit', async function () {
        let data = $(this).data('data');
        $('#form_edit').attr('action', `{{ url('sales-person/') }}/${data.id}`);
        $('#user_id_edit').val(data.user_id);
        $('#nama_edit').val(data.nama);
        $('#no_hp_edit').val(data.no_hp);
        $('#alamat_edit').val(data.alamat);

        $('#provinsi_id_edit').val(data.provinsi_id).change();
        $('#nama_provinsi_edit').val(getNamaWilayah(list_provinsi, data.provinsi_id));

        await loadWilayah('#kabupaten_id_edit', `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${data.provinsi_id}.json`).then(data => list_kabupaten = data);
        $('#kabupaten_id_edit').val(data.kabupaten_id).change();
        $('#nama_kabupaten_edit').val(getNamaWilayah(list_kabupaten, data.kabupaten_id));

        await loadWilayah('#kecamatan_id_edit', `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${data.kabupaten_id}.json`).then(data => list_kecamatan = data);
        $('#kecamatan_id_edit').val(data.kecamatan_id).change();
        $('#nama_kecamatan_edit').val(getNamaWilayah(list_kecamatan, data.kecamatan_id));

        await loadWilayah('#kelurahan_id_edit', `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${data.kecamatan_id}.json`).then(data => list_kelurahan = data);
        $('#kelurahan_id_edit').val(data.kelurahan_id);
        $('#nama_kelurahan_edit').val(getNamaWilayah(list_kelurahan, data.kelurahan_id));
    });

      $('#provinsi_id, #provinsi_id_edit').on('change', async function() {
        let provinsiId = $(this).val();
        let isEdit = $(this).attr('id').includes('_edit');
        let kabupatenSelect = isEdit ? '#kabupaten_id_edit' : '#kabupaten_id';
        let namaProvinsi = isEdit ? '#nama_provinsi_edit' : '#nama_provinsi';
        let namaKabupaten = isEdit ? '#nama_kabupaten_edit' : '#nama_kabupaten';
        let namaKecamatan = isEdit ? '#nama_kecamatan_edit' : '#nama_kecamatan';
        let namaKelurahan = isEdit ? '#nama_kelurahan_edit' : '#nama_kelurahan';

        $(namaProvinsi).val(getNamaWilayah(list_provinsi, provinsiId));

        $(kabupatenSelect).empty().append('<option selected>pilih</option>');
        $('#kecamatan_id, #kecamatan_id_edit').empty().append('<option selected>pilih</option>');
        $('#kelurahan_id, #kelurahan_id_edit').empty().append('<option selected>pilih</option>');
        $(namaKabupaten).val('');
        $(namaKecamatan).val('');
        $(namaKelurahan).val('');

        list_kabupaten = await loadWilayah(kabupatenSelect, `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinsiId}.json`);
      });

      $('#kabupaten_id, #kabupaten_id_edit').on('change', async function() {
        let kabupatenId = $(this).val();
        let isEdit = $(this).attr('id').includes('_edit');
        let kecamatanSelect = isEdit ? '#kecamatan_id_edit' : '#kecamatan_id';
        let namaKabupaten = isEdit ? '#nama_kabupaten_edit' : '#nama_kabupaten';
        let namaKecamatan = isEdit ? '#nama_kecamatan_edit' : '#nama_kecamatan';
        let namaKelurahan = isEdit ? '#nama_kelurahan_edit' : '#nama_kelurahan';

        $(namaKabupaten).val(getNamaWilayah(list_kabupaten, kabupatenId));

        $(kecamatanSelect).empty().append('<option selected>pilih</option>');
        $('#kelurahan_id, #kelurahan_id_edit').empty().append('<option selected>pilih</option>');
        $(namaKecamatan).val('');
        $(namaKelurahan).val('');

        list_kecamatan = await loadWilayah(kecamatanSelect, `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabupatenId}.json`);
      });

      $('#kecamatan_id, #kecamatan_id_edit').on('change', async function() {
        let kecamatanId = $(this).val();
        let isEdit = $(this).attr('id').includes('_edit');
        let kelurahanSelect = isEdit ? '#kelurahan_id_edit' : '#kelurahan_id';
        let namaKecamatan = isEdit ? '#nama_kecamatan_edit' : '#nama_kecamatan';
        let namaKelurahan = isEdit ? '#nama_kelurahan_edit' : '#nama_kelurahan';

        $(namaKecamatan).val(getNamaWilayah(list_kecamatan, kecamatanId));

        $(kelurahanSelect).empty().append('<option selected>pilih</option>');
        $(namaKelurahan).val('');

        list_kelurahan = await loadWilayah(kelurahanSelect, `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`);
      });

      $('#kelurahan_id, #kelurahan_id_edit').on('change', function() {
        let kelurahanId = $(this).val();
        let isEdit = $(this).attr('id').includes('_edit');
        let namaKelurahan = isEdit ? '#nama_kelurahan_edit' : '#nama_kelurahan';

        $(namaKelurahan).val(getNamaWilayah(list_kelurahan, kelurahanId));
      });

      async function loadWilayah(selectId, url) {
        try {
          let response = await $.get(url);
          $(selectId).append('<option selected>pilih</option>');
          response.forEach(item => {
            $(selectId).append(`<option value="${item.id}">${item.name}</option>`);
          });
          return response;
        } catch (error) {
          console.error(`Gagal memuat data dari ${url}`, error);
          return [];
        }
      }

      function getNamaWilayah(list, id) {
        let wilayah = list.find(e => e.id == id);
        return wilayah ? wilayah.name : '';
      }
    });
  </script>
@endsection
