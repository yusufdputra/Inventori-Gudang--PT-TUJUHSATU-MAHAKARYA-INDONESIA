@extends('layouts.app')

@section('content')
<div class="col-12">
    <div class="row">

    <div class="col-lg-6 col-xs-12">
      <div class="card-box">
        <table class="table text-center" id="">
          <thead>
            <tr>
              <th colspan="2" class="bg-warning text-center text-white">Stok Barang Minimum</th>
            </tr>
            <tr>
              <th>Barang</th>
              <th>Stok</th>
            </tr>
          </thead>
          <tbody class="table-striped">
            @if(!$barangs->isEmpty())
            @foreach ($barangs as $key=>$value)
            <tr>
              <td>{{$value->nama}}</td>
              <td><span class="badge badge-warning">{{$value->stok}}</span></td>
            </tr>

            @endforeach
            @else
            <td colspan="2">Tidak Ada Hasil</td>
            @endif

          </tbody>
        </table>
      </div>

    </div>

    <div class="col-lg-6 col-xs-12">
      <div class="card-box">
        <table class="table text-center" id="">
          <thead>
            <tr>
              <th colspan="3" class="bg-success text-center text-white">Transaksi Peminjaman Terakhir</th>
            </tr>
            <tr>
              <th>Tanggal</th>
              <th>Barang</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody class="table-striped">
            @if(!$peminjamans->isEmpty())
            @foreach ($peminjamans as $key=>$value)
            <tr>
              <td>{{date("d-M-Y H:m ", strtotime(($value->created_at)))}} WIB</td>
              <td>{{$value->barang[0]['nama']}}</td>
              <td><span class="badge badge-success">{{$value->jml_pinjam}}</span></td>
            </tr>

            @endforeach
            @else
            <td colspan="3">Tidak Ada Hasil</td>
            @endif

          </tbody>
        </table>
      </div>

    </div>

   
  </div>
</div>


@endsection