@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">
      @role('admin')
      <div class="align-items-center">

        <a href="{{route('rabtemp.index')}}" class="btn btn-primary m-l-10 waves-light  mb-5">Tambah</a>

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

      @endrole
      <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">

        <thead>
          <tr>
            <th>No.</th>
            <th>Nama Proyek</th>
            <th>Harga Total (Rp.)</th>
            <th>Tanggal Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rab AS $key=>$value)

          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value['nama']}}</td>
            <td>{{$harga_total[$key]}}</td>
            <td>{{$value['created_at']}}</td>
            <td>
              <a href="{{route('rab.edit', $value->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
              <a href="#hapus-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash"></i></a>
              <a href="{{route('rab.cetak', $value->id)}}" target="_BLANK" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
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

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('rab.delete')}}" method="POST">
        {{csrf_field()}}
        <div>
          <input type="hidden" id='id_hapus' name='id'>
          <h5 id="exampleModalLabel">Apakah anda yakin ingin mengapus RAB ini?</h5>
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

<script type="text/javascript">
  $('.hapus').click(function() {
    var id = $(this).data('id');
    $('#id_hapus').val(id);
  });
</script>
@endsection