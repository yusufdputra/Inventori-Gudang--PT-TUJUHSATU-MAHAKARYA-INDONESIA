@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">

      <div class="form-row">
        @role('admin|pegawai')
        <div class="form-group ">
          <a href="#tambah-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-primary m-l-10 waves-light  ">Tambah</a>
        </div>
        @endrole

        <div class="form-group ">
          <a href="#cetak-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-purple m-l-10 waves-light  ">Cetak</a>
        </div>


        <div class="form-group m-l-10 col-md-4">

          <div class="input-group ">
            <div class="input-group-append">
              <span class="input-group-text">Sorting</span>
            </div>
            <select required class="form-control " onchange="sorting()" id="sort_barangs" name="sort_barang">
              <option value="" selected>Tidak ada</option>
              @foreach ($barangs as $key=>$value)
              <option value="{{$value->nama}}">{{strtoupper($value->nama)}}</option>
              @endforeach
            </select>

          </div>
        </div>

      </div>


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
            <th>No.</th>
            <th>Tanggal Keluar</th>
            <th>Nama barang</th>
            <!-- <th>Jumlah Stok Sekarang</th> -->
            <th>Jumlah Keluar</th>
            <th>Lokasi Penyimpanan</th>
            <th>Nama Pengambil</th>
            <th>Fungsi</th>
            @role('admin|pegawai')
            <th>Aksi</th>
            @endrole
          </tr>
        </thead>
        <tbody>
          @foreach ($barang_klr AS $key=>$value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{date("d-M-Y H:m ", strtotime(($value->created_at)))}} WIB</td>
            <td>{{$value->barang[0]['nama']}}</td>
            <!-- <td>{{$value->barang[0]['stok']}}</td> -->
            <td>{{$value->stok_keluar}}</td>
            <td>{{$value->lokasi}}</td>
            <td>{{$value->pengambil}}</td>
            <td>{{$value->fungsi}}</td>
            @role('admin|pegawai')
            <td>
              <a href="#edit-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-nama="{{$value['nama']}}" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-success btn-sm modal_edit"><i class="fa fa-edit"></i></a>
              <a href="#hapus-modal" data-animation="sign" data-plugin="custommodal" data-id_barang="{{$value->id_barang}}" data-stok="{{$value->stok_keluar}}" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash"></i></a>
            </td>
            @endrole
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
      <h4 class="text-uppercase font-bold mb-0">Tambah barang</h4>
    </div>
    <div class="p-20 text-left">
      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('keluar.store')}}" method="POST">
        {{csrf_field()}}

        <div class="form-group">
          <label for="">Tanggal Masuk</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" readonly value="{{\Carbon\Carbon::now()}}">
          </div>
        </div>

        <div class="form-group">
          <label for="">Nama Barang</label>
          <div class="col-xs-12">
            <select required class="form-control" id="id_barang" name="id_barang">
              <option selected disabled>..pilih..</option>
              @foreach ($barangs as $key => $value)
              <option value="{{$value->id}}">{{$value->nama}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="">Stok Tersedia</label>
          <div class="col-xs-12">
            <input class="form-control" type="number" readonly autocomplete="off" id="stok_tersedia" required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Stok Keluar</label>
          <div class="col-xs-12">
            <input class="form-control" type="number" id="stok" autocomplete="off" name="stok_keluar" required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label>Lokasi Barang Penyimpanan</label>
          <div class="col-xs-12">
            <textarea class="form-control" type="text" autocomplete="off" name="lokasi" required="" placeholder="Nama Lokasi"></textarea>
          </div>
        </div>

        <div class="form-group">
          <label for="">Nama Pengambil</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" name="pengambil" required="" placeholder="Stok Barang">
          </div>
        </div>
        <div class="form-group">
          <label>Fungsi</label>
          <div class="col-xs-12">
            <textarea class="form-control" type="text" autocomplete="off" name="fungsi" required="" placeholder="Fungsi/Kegunaan"></textarea>
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
      <h4 class="text-uppercase font-bold mb-0">Edit barang</h4>
    </div>
    <div class="p-20 text-left">

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('keluar.update')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="id" id="edit_id">
        <input type="hidden" name="old_stok_keluar" id="old_stok_keluar">

        <div class="form-group">
          <label for="">Tanggal Masuk</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" readonly value="{{\Carbon\Carbon::now()}}">
          </div>
        </div>

        <div class="form-group">
          <label for="">Nama Barang</label>
          <div class="col-xs-12">
            <select required class="form-control" id="edit_id_barang" name="id_barang">
              <option selected disabled>..pilih..</option>
              @foreach ($barangs as $key => $value)
              <option value="{{$value->id}}">{{$value->nama}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="">Stok Tersedia</label>
          <div class="col-xs-12">
            <input class="form-control" type="number" readonly autocomplete="off" id="edit_stok_tersedia" required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Stok Keluar</label>
          <div class="col-xs-12">
            <input class="form-control" type="number" id="edit_stok_keluar" autocomplete="off" name="stok_keluar" required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label>Lokasi Barang Penyimpanan</label>
          <div class="col-xs-12">

            <textarea class="form-control" type="text" autocomplete="off" name="lokasi" required="" id="lokasi" placeholder="Nama Lokasi"></textarea>
          </div>
        </div>

        <div class="form-group">
          <label for="">Nama Pengambil</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" id="edit_pengambil" autocomplete="off" name="pengambil" required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label>Fungsi</label>
          <div class="col-xs-12">
            <textarea class="form-control" type="text" id="edit_fungsi" autocomplete="off" name="fungsi" required="" placeholder="Fungsi/Kegunaan"></textarea>
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

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('keluar.hapus')}}" method="POST">
        {{csrf_field()}}
        <div>
          <input type="hidden" id='id_hapus' name='id'>
          <input type="hidden" id='hapus_id_barang' name='id_barang'>
          <input type="hidden" id='hapus_stok_keluar' name='stok_keluar'>
          <h5 id="exampleModalLabel">Apakah anda yakin ingin mengapus ini?</h5>
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

<div id="cetak-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Cetak Barang Keluar</h4>
    </div>
    <div class="p-20 text-left">
      <form class="form-horizontal m-t-20" target="_BLANK" enctype="multipart/form-data" action="{{route('cetak.cetak')}}" method="POST">
        {{csrf_field()}}

        <input type="hidden" value="keluar" name="jenis">

        <div class="form-group">
          <label for="">Dari Tanggal</label>
          <div class="col-xs-12">
            <div class="input-group-append">
              <input type="text" class="form-control datepicker-autoclose"  autocomplete="off"  name="start_date" id="">
              <span class="input-group-text"><i class="ti-calendar"></i></span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="">Sampai Tanggal</label>
          <div class="col-xs-12">
            <div class="input-group-append">
              <input type="text" class="form-control datepicker-autoclose"  autocomplete="off" name="end_date"  id="">
              <span class="input-group-text"><i class="ti-calendar"></i></span>
            </div>
          </div>
        </div>


        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-bordred btn-block waves-effect waves-light" type="submit">Cetak</button>
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
      url: '{{url("keluar/edit")}}/' + id,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {

        $('#edit_id').val(id)
        $('#edit_id_barang').val(data['id_barang'])
        $('#edit_stok_tersedia').val(data['barang'][0]['stok'])
        $('#edit_stok_keluar').val(data['stok_keluar'])
        $('#lokasi').val(data['lokasi'])
        $('#edit_pengambil').val(data['pengambil'])
        $('#edit_fungsi').val(data['fungsi'])
        $('#old_stok_keluar').val(data['stok_keluar'])
        // $('#edit_stok_keluar').attr({
        //   "max": data['barang'][0]['stok']
        // });
      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })

  });

  $('.hapus').click(function() {
    var id = $(this).data('id');
    var id_barang = $(this).data('id_barang');
    var stok = $(this).data('stok');
    $('#id_hapus').val(id);
    $('#hapus_id_barang').val(id_barang);
    $('#hapus_stok_keluar').val(stok);
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
        $('#stok').attr({
          "max": data['stok']
        });
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
        $('#edit_stok_keluar').attr({
          "max": data['stok']
        });
      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })
  })

  // sorting 
  function sorting() {
    const sort_barang = document.getElementById('sort_barangs').value
    $('#datatable').DataTable()

    function filterData() {
      $('#datatable').DataTable().search(
        sort_barang
      ).draw()
    }
    filterData()
  }
</script>


@endsection