@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">
      @role('admin')
      <div class="align-items-center">

        <a href="#tambah-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-primary m-l-10 waves-light  mb-5">Tambah</a>

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
            <th>Nama Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kategori AS $key=>$value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value['nama']}}</td>
            <td>
              <a href="#edit-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-nama="{{$value['nama']}}" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-success btn-sm modal_edit"><i class="fa fa-edit"></i></a>
              <a href="#hapus-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-danger btn-sm hapus"><i class="fa fa-edit"></i></a>

              
            </td>
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
      <h4 class="text-uppercase font-bold mb-0">Tambah kategori</h4>
    </div>
    <div class="p-20">
      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('kategori.store')}}" method="POST">
        {{csrf_field()}}

        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" name="nama" required="" placeholder="Nama Kategori">
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
      <h4 class="text-uppercase font-bold mb-0">Edit Kategori</h4>
    </div>
    <div class="p-20">

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('kategori.update')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="id" id="edit_id">
        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" id="edit_nama" name="nama" required="" placeholder="Nama kategori">
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
      <h4 class="text-uppercase font-bold mb-0">Hapus Kategori</h4>
    </div>
    <div class="p-20">

    <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('kategori.hapus')}}" method="POST">
    {{csrf_field()}}
        <div>
          <input type="hidden" id='id_hapus' name='id'>
          <h5 id="exampleModalLabel">Apakah anda yakin ingin mengapus kategori ini?</h5>
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
  $('.modal_edit').click(function() {
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    $('#edit_id').val(id)
    $('#edit_nama').val(nama)

  });

  $('.hapus').click(function() {
        var id = $(this).data('id');
        $('#id_hapus').val(id);
      });
</script>
@endsection