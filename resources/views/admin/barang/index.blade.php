@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">

      @role('admin')
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
            <th>No.</th>
            <th>Nama barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Tanggal Perubahan</th>
            @role('admin')
            <th>Aksi</th>
            @endrole
            @role('pegawai')
            <th>Restok</th>
            @endrole
          </tr>
        </thead>
        <tbody>
          @foreach ($barang AS $key=>$value)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->nama}}</td>
            <td>{{$value->kategori[0]['nama']}}</td>
            <td>{{$value->stok}}</td>
            <td>{{$value->satuan}}</td>
            <td>

              @if($value['updated_at'] != null)
              {{date('d-M-Y, H:m', strtotime($value['updated_at']))}} WIB
              @else
              {{date('d-M-Y, H:m', strtotime($value['created_at']))}} WIB
              @endif
            </td>

            @role('admin')
            <td>
              <a href="#edit-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-success btn-sm modal_edit"><i class="fa fa-edit"></i></a>
              <a href="#hapus-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash"></i></a>
            </td>
            @endrole
            @role('pegawai')
            <td>
              <a href="#restok-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-nama="{{$value['nama']}}" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-success btn-sm modal_restok"><i class="mdi mdi-basket-fill"></i></a>
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
      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('barang.store')}}" method="POST">
        {{csrf_field()}}

        <div class="form-group">
          <label>Nama barang</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" name="nama" required="" placeholder="Nama barang">
          </div>
        </div>



        <div class="form-group">
          <label for="">Kategori</label>
          <div class="col-xs-12">
            <div class="input-group">
              <select required class="form-control" name="kategori">
                @foreach ($kategori AS $key=>$value)
                <option value="{{$value->id}}">{{$value->nama}}</option>
                @endforeach
              </select>
              <div class="input-group-append">
                <a href="{{route ('kategori.index')}}" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus"></i> <span> </span> </a>
              </div>
            </div>

          </div>
        </div>

        <div class="form-group">
          <label for="">Stok</label>
          <div class="col-xs-12">
            <input class="form-control" type="number" min="0" autocomplete="off" name="stok" required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Satuan</label>
          <div class="col-xs-12">
            <select required class="form-control" name="satuan">
              <option value="Ball">Ball</option>
              <option value="Set">Set</option>
              <option value="Pcs">Pcs</option>
            </select>
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

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('barang.update')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="id" id="edit_id">

        <div class="form-group">
          <label>Nama barang</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" id="edit_nama" name="nama" required="" placeholder="Nama barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Kategori</label>
          <div class="col-xs-12">
            <div class="input-group">
              <select required class="form-control" id="edit_kategori" name="kategori">
                @foreach ($kategori AS $key=>$value)
                <option value="{{$value->id}}">{{$value->nama}}</option>
                @endforeach
              </select>
              <div class="input-group-append">
                <a href="{{route ('kategori.index')}}" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus"></i> <span> </span> </a>
              </div>
            </div>

          </div>
        </div>

        <div class="form-group">
          <label for="">Stok</label>
          <div class="col-xs-12">
            <input class="form-control" type="number" min="0" id="edit_stok" autocomplete="off" name="stok" required="" placeholder="Stok Barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Satuan</label>
          <div class="col-xs-12">
            <select required class="form-control" id="edit_satuan" name="satuan">
              <option value="Ball">Ball</option>
              <option value="Set">Set</option>
              <option value="Pcs">Pcs</option>
            </select>
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

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('barang.hapus')}}" method="POST">
        {{csrf_field()}}
        <div>
          <input type="hidden" id='id_hapus' name='id'>
          <h5 id="exampleModalLabel">Apakah anda yakin ingin mengapus barang ini?</h5>
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

<div id="restok-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Ajukan Restok <span id="nama_restok"></span></h4>
    </div>
    <div class="p-20 text-left">

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('restok.store')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="id" id="restok_id">


        <div class="form-group">
          <label for="">Permintaan Stok</label>
          <div class="col-xs-12">
            <input class="form-control" type="number" min="0" autocomplete="off" name="permintaan_stok" required="" placeholder="Permintaan Stok Barang">
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
      url: '{{url("barang/edit")}}/' + id,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        $('#edit_id').val(id)
        $('#edit_nama').val(data['nama'])
        $('#edit_stok').val(data['stok'])
        $('#edit_kategori').val(data['id_kategori'])
        $('#edit_satuan').val(data['satuan'])

      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })

  });

  $('.modal_restok').click(function() {
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    $('#restok_id').val(id)
    $('#nama_restok').html(nama)


  });

  $('.hapus').click(function() {
    var id = $(this).data('id');
    $('#id_hapus').val(id);
  });
</script>


@endsection