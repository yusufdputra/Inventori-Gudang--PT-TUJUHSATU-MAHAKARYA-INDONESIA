@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">
      @role('pegawai')
      <div class="form-row">
        <div class="form-group ">
          <a href="#tambah-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-primary m-l-10 waves-light  ">Tambah</a>
        </div>

      </div>
      @endrole

      @if(\Session::has('alert'))
      <div class="alert alert-danger">
        <div>{{Session::get('alert')}}</div>
      </div>
      @endif

      @if(\Session::has('success'))
      <div class="alert alert-success">
        <div>{{Session::get('success')}}</div>
      </div>
      @endif

      <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Stok Permintaan</th>
            <th>Stok Terpenuhi</th>
            <th>Tanggal Pengajuan</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>

          @foreach ($restok as $key=>$value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->barang[0]['nama']}}</td>
            <td>{{$value->permintaan_stok}}</td>
            <td>
              @if (($value->terpenuhi_stok) == null)
              Belum Dipenuhi
              @else

              {{$value->terpenuhi_stok}}
              @endif
            </td>
            <td>{{date('d-M-Y, H:m', strtotime($value['created_at']))}}</td>

            @if (($value->terpenuhi_stok) == null)
            <td>
              @role('admin')
              <a href="#terima-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-rounded btn-success btn-sm modal_terima"><i class="mdi mdi-check"></i></a>
              @else
              <a href="#edit-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-rounded btn-success btn-sm modal_edit"><i class="fa fa-edit"></i></a>

              <a href="#hapus-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-rounded btn-danger btn-sm hapus"><i class="fa fa-trash"></i></a>
              @endrole
            </td>
            @else
            <td>-</td>
            @endif

          </tr>

          @endforeach

        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- end row -->

<div id="tambah-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Tambah Pengajuan Baru</h4>
    </div>
    <div class="p-20 text-left">
      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('restok.store')}}" method="POST">
        {{csrf_field()}}

        <div class="form-group">
          <label for="">Pilih Barang</label>
          <div class="col-xs-12">
            <select required class="form-control" id="id_barang" name="id">
              <option selected disabled>..pilih..</option>
              @foreach ($barang as $key=>$value)
              <option value="{{$value->id}}">{{$value->nama}}</option>
              @endforeach
            </select>
          </div>
        </div>


        <div class="form-group">
          <label for="">Stok Tersedia</label>
          <div class="col-xs-12">
            <input class="form-control" required readonly id="stok_tersedia" type="number" min="0" autocomplete="off" name="stok" required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Stok Permintaan</label>
          <div class="col-xs-12">
            <input class="form-control" type="number" min="0" autocomplete="off" name="permintaan_stok" required="" placeholder="Stok Barang">
          </div>
        </div>


        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-bordred btn-block waves-effect waves-light" type="submit">Tambah</button>
          </div>
        </div>


      </form>

    </div>
  </div>

</div>

<div id="edit-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Ubah Pengajuan</h4>
    </div>
    <div class="p-20 text-left">
      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('restok.update')}}" method="POST">
        {{csrf_field()}}

        <input type="hidden" name="id" id="edit_id">

        <div class="form-group">
          <label for="">Pilih Barang</label>
          <div class="col-xs-12">
            <select required class="form-control" id="edit_id_barang" name="id_barang">
              <option selected disabled>..pilih..</option>
              @foreach ($barang as $key=>$value)
              <option value="{{$value->id}}">{{$value->nama}}</option>
              @endforeach
            </select>
          </div>
        </div>


        <div class="form-group">
          <label for="">Stok Tersedia</label>
          <div class="col-xs-12">
            <input class="form-control" required readonly id="edit_stok_tersedia" type="number" min="0" autocomplete="off" name="stok" required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Stok Permintaan</label>
          <div class="col-xs-12">
            <input class="form-control" type="number" min="0" autocomplete="off" id="edit_permintaan_stok" name="permintaan_stok" required="" placeholder="Stok Barang">
          </div>
        </div>


        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-bordred btn-block waves-effect waves-light" type="submit">Ubah</button>
          </div>
        </div>


      </form>

    </div>
  </div>

</div>

<div id="hapus-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Hapus barang</h4>
    </div>
    <div class="p-20">

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('restok.hapus')}}" method="POST">
        {{csrf_field()}}
        <div>
          <input type="hidden" id='id_hapus' name='id'>
          <h5 id="exampleModalLabel">Apakah anda yakin ingin mengapus permintaan ini?</h5>
        </div>

        <div class="form-group text-center m-t-30">
          <div class="col-xs-6">
            <button type="button" onclick="Custombox.close();" class="   btn btn-primary btn-bordred btn-block waves-effect waves-light">Tidak</button>
            <button class="btn btn-danger btn-bordred btn-block waves-effect waves-light" type="submit">Hapus</button>
          </div>
        </div>


      </form>

    </div>
  </div>

</div>

<div id="terima-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Terima Pengajuan</h4>
    </div>
    <div class="p-20 text-left">
      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('restok.terima')}}" method="POST">
        {{csrf_field()}}

        <input type="hidden" name="id" id="terima_id">
        <input type="hidden" name="id_barang" id="terima_id_barang">

        <div class="form-group">
          <label for="">Nama Barang</label>
          <div class="col-xs-12">
            <input class="form-control" required readonly id="terima_nama_barang" type="text"  autocomplete="off"  required="" placeholder="Nama Barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Stok Saat Ini</label>
          <div class="col-xs-12">
            <input class="form-control" required readonly id="terima_stok_sekarang" type="number" min="0" autocomplete="off"  required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Stok Permintaan</label>
          <div class="col-xs-12">
            <input class="form-control" readonly type="number" min="0" autocomplete="off" id="terima_permintaan_stok"  required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Stok Terpenuhi</label>
          <div class="col-xs-12">
            <input class="form-control" type="number" min="0" autocomplete="off" name="terpenuhi_stok" id="terima_terpenuhi_stok"  required="" placeholder="Stok Barang">
          </div>
        </div>


        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-bordred btn-block waves-effect waves-light" type="submit">Ubah</button>
          </div>
        </div>


      </form>

    </div>
  </div>

</div>

<script type="text/javascript">
  $('.modal_edit').click(function() {
    var id = $(this).data('id');
    $('#edit_id').val(id)

    $.ajax({
      url: '{{url("restok/edit")}}/' + id,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {

        $('#edit_id').val(id)
        $('#edit_id_barang').val(data['id_barang'])
        $('#edit_stok_tersedia').val(data['barang'][0]['stok'])
        $('#edit_permintaan_stok').val(data['permintaan_stok'])
      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })
  });

  $('.modal_terima').click(function() {
    var id = $(this).data('id');
    $('#terima_id').val(id)
    $.ajax({
      url: '{{url("restok/edit")}}/' + id,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {

        $('#terima_id').val(id)
        $('#terima_id_barang').val(data['barang'][0]['id'])
        $('#terima_nama_barang').val(data['barang'][0]['nama'])
        $('#terima_stok_sekarang').val(data['barang'][0]['stok'])
        $('#terima_permintaan_stok').val(data['permintaan_stok'])
        $('#terima_terpenuhi_stok').attr({
          "max": data['permintaan_stok']
        });
      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })
  });

  $('.hapus').click(function() {
    var id = $(this).data('id');
    $('#id_hapus').val(id);
  });

  // untuk tambah
  document.getElementById('id_barang').addEventListener("change", function() {
    $('#stok_tersedia').html('')
    $.ajax({
      url: '{{url("getBarangById")}}/' + this.value,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        $('#stok_tersedia').val(data['stok'])

      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })
  })

  // untuk edit
  document.getElementById('edit_id_barang').addEventListener("change", function() {
    $('#edit_stok_tersedia').html('')
    $.ajax({
      url: '{{url("getBarangById")}}/' + this.value,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        $('#edit_stok_tersedia').val(data['stok'])

      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })
  })
</script>


@endsection