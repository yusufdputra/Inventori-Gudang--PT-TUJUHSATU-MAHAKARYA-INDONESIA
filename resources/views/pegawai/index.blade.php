@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">



      <button class="btn btn-success waves-effect m-l-10 waves-light m-b-30">Tambah Pegawai</button>



      <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Didaftarkan</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>

          @foreach ($pegawai as $key=>$value)
          <tr>
            <td>{{$key}}</td>
            <td>{{$value->nama}}</td>
            <td>{{$value->email}}</td>
            <td>{{$value->created_at}}</td>
            <td>
              <a href="#edit-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-rounded btn-success btn-sm "><i class="fa fa-edit"></i></a>

              <a href="#hapus-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-rounded btn-danger btn-sm "><i class="fa fa-trash"></i></a>
            </td>
          </tr>

          @endforeach

        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- end row -->

@endsection