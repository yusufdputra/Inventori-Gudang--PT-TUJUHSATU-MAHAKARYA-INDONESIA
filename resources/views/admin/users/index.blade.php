@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">
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


      <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Nomor Hp</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>

          @foreach ($users as $key=>$value)

          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->nama}}</td>
            <td>{{$value->username}}</td>
            <td>{{$value->nomor_hp}}</td>

            <td>
              <a href="#edit-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-success btn-sm modal_edit"><i class="fa fa-edit"></i></a>

              <a href="#hapus-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-iduser='{{$value->id_user}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash"></i></a>

              <a href="#edit-password" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-warning btn-sm modal_pw"><i class="fa fa-lock"></i></a>
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

  <div class="custom-modal-text text-left">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Tambah {{$jenis}}</h4>
    </div>
    <div class="p-20">

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('user.store')}}" method="POST">
        {{csrf_field()}}

        <div class="form-group">
          <label for="">Nama</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" name="nama" required="" placeholder="Nama">
          </div>
        </div>

        <div class="form-group">
          <label for="">Username</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" name="username" required="" placeholder="Nama">
          </div>
        </div>

        <div class="form-group">
          <label for="">Nomor Hp</label>
          <div class="col-xs-12">
            <input class="form-control" type="text"  autocomplete="off" name="nomor_hp" required="" placeholder="Nomor Hp">
          </div>
        </div>

        <input type="hidden" value="{{$jenis}}" name="role">



        <div class="form-group">
          <label for="">Password</label>
          <div class="col-xs-12">
            <input class="form-control" autocomplete="off" type="text" name="password" required="" placeholder="Password">
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

  <div class="custom-modal-text text-left">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Edit {{$jenis}}</h4>
    </div>
    <div class="p-20">

      <form class="form-horizontal m-t-20" action="{{route('user.update')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="id" id="edit_id">


        <div class="form-group">
          <label for="">Nama</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" id="edit_nama" name="nama" required="" placeholder="Nama">
          </div>
        </div>
        <div class="form-group">
          <label for="">Nomor Hp</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" id="edit_nomor_hp" name="nomor_hp" required="" placeholder="Nomor Hp">
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

<div id="edit-password" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text text-left">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Reset Password {{$jenis}}</h4>
    </div>
    <div class="p-20">

      <form class="form-horizontal m-t-20" action="{{route('user.resetpw')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="id" id="pw_id">


        <div class="form-group">
          <label for="">Password Baru</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" name="password" required="" placeholder="Masukkan Password Baru">
          </div>
        </div>


        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-bordred btn-block waves-effect waves-light" type="submit">Reset</button>
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
      <h4 class="text-uppercase font-bold mb-0">Hapus {{$jenis}}</h4>
    </div>
    <div class="p-20">

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('user.hapus')}}" method="POST">
        {{csrf_field()}}
        <div>
          <input type="hidden" id='id_hapus' name='id'>
          <input type="hidden" id='id_user_hapus' name='id_user'>
          <input type="hidden" id='jenis_hapus' name='jenis'>
          <h5 id="exampleModalLabel">Apakah anda yakin ingin mengapus {{$jenis}} ini?</h5>
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
    $.ajax({
      url: '{{url("user/edit")}}',
      type: 'POST',
      data: {
        'id': id,
        '_token': '{{ csrf_token() }}'
      },
      dataType: 'json',
      success: 'success',
      success: function(data) {
        $('#edit_id').val(id)
        $('#edit_nama').val(data['nama'])
        $('#edit_nomor_hp').val(data['nomor_hp'])
      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })
  });

  $('.hapus').click(function() {
    var id = $(this).data('id');
    var jenis = $(this).data('jenis');
    var id_user = $(this).data('iduser');
    $('#id_hapus').val(id);
    $('#id_user_hapus').val(id_user);
    $('#jenis_hapus').val(jenis);
  });

  $('.modal_pw').click(function() {
    var id = $(this).data('id');
    $('#pw_id').val(id);
  });
</script>

@endsection