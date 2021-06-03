@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">

      <div class="form-row">
      

        <div class="form-group ">
          <a href="#cetak-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-purple m-l-10 waves-light  ">Cetak</a>
        </div>

        <div class="form-group m-l-10  col-md-4">

          <div class="input-group">
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
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>Nama Pegawai</th>
            <th>Nama Barang</th>
            <th>Estimasi Peminjaman (Hari)</th>
            <th>Jumlah Peminjaman</th>
            <th>Fungsi Peminjaman</th>
            @role('admin|pegawai')
            <th>Aksi</th>
            @endrole
          </tr>
        </thead>
        <tbody>
          @foreach ($peminjaman AS $key=>$value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{date("d-M-Y H:i ", strtotime(($value->created_at)))}} WIB</td>
            @if($value->pengembalian_at != null)
            <td>{{date("d-M-Y H:i ", strtotime(($value->pengembalian_at)))}} WIB</td>
            @else
            <td>-</td>
            @endif

            <td>{{$value->nama_peminjam}}</td>
            <td>{{$value->barang[0]['nama']}}</td>
            <td>{{$value->estimasi}}</td>
            <td>{{$value->jml_pinjam}}</td>
            <td>{{$value->fungsi}}</td>
            @role('admin|pegawai')

            <td>
              @if($value->pengembalian_at != null)
              Sudah Dikembalikan
              @else
              <a href="#edit-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-success btn-sm modal_edit"><i class="mdi mdi-keyboard-return"></i></a>
              @endif
            </td>
            @endrole
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div id="edit-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Pengembalian barang</h4>
    </div>
    <div class="p-20 text-left">

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('pengembalian.update')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="id" id="edit_id">
        <input type="hidden" name="id_barang" id="edit_id_barang">

        <div class="form-group">
          <label for="">Nama Peminjam</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" readonly autocomplete="off" id="edit_nama_peminjam" name="nama_peminjam" required="">
          </div>
        </div>

        <div class="form-group">
          <label for="">Nama Barang</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" readonly autocomplete="off" id="edit_nama_barang" name="" required="">
          </div>
        </div>

        <div class="form-group">
          <label for="">Stok Dipinjam</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" readonly id="edit_jml_pinjam" autocomplete="off" name="jml_pinjam" required="" placeholder="Stok Dipinjam">
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


<div id="cetak-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Cetak Data Pengembalian Barang</h4>
    </div>
    <div class="p-20 text-left">
      <form class="form-horizontal m-t-20" target="_BLANK" enctype="multipart/form-data" action="{{route('cetak.cetak')}}" method="POST">
        {{csrf_field()}}

        <input type="hidden" value="kembali" name="jenis">

        <div class="form-group">
          <label for="">Dari Tanggal</label>
          <div class="col-xs-12">
            <div class="input-group-append">
              <input type="text" class="form-control datepicker-autoclose" placeholder="dd/mm/yyyy" autocomplete="off" name="start_date">
              <span class="input-group-text"><i class="ti-calendar"></i></span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="">Sampai Tanggal</label>
          <div class="col-xs-12">
            <div class="input-group-append">
              <input type="text" class="form-control datepicker-autoclose" placeholder="dd/mm/yyyy" autocomplete="off" name="end_date">
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
      url: '{{url("pengembalian/edit")}}/' + id,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        $('#edit_id').val(id)
        $('#edit_id_barang').val(data['id_barang'])
        $('#edit_nama_peminjam').val(data['nama_peminjam'])
        $('#edit_nama_barang').val(data['barang'][0]['nama'])
        $('#edit_stok_tersedia').val(data['barang'][0]['stok'])
        $('#edit_jml_pinjam').val(data['jml_pinjam'])


      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })

  });



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