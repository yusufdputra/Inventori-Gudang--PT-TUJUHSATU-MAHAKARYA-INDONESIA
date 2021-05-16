@extends('layouts.app')

@section('content')
<div class="col-12">
    <div class="row">

    <div class="col-lg-4 col-xs-12">
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

    <div class="col-lg-4 col-xs-12">
      <div class="card-box">
        <table class="table text-center" id="">
          <thead>
            <tr>
              <th colspan="3" class="bg-success text-center text-white">Transaksi Terakhir Barang Masuk</th>
            </tr>
            <tr>
              <th>Tanggal</th>
              <th>Barang</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody class="table-striped">
            @if(!$masuks->isEmpty())
            @foreach ($masuks as $key=>$value)
            <tr>
              <td>{{date("d-M-Y H:m ", strtotime(($value->created_at)))}} WIB</td>
              <td>{{$value->barang[0]['nama']}}</td>
              <td><span class="badge badge-success">{{$value->stok_masuk}}</span></td>
            </tr>

            @endforeach
            @else
            <td colspan="3">Tidak Ada Hasil</td>
            @endif

          </tbody>
        </table>
      </div>

    </div>

    <div class="col-lg-4 col-xs-12">
      <div class="card-box">
        <table class="table text-center" id="">
          <thead>
            <tr>
              <th colspan="3" class="bg-danger text-center text-white">Transaksi Terakhir Barang Keluar</th>
            </tr>
            <tr>
              <th>Tanggal</th>
              <th>Barang</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody class="table-striped">
            @if(!$keluars->isEmpty())
            @foreach ($keluars as $key=>$value)
            <tr>
              <td>{{date("d-M-Y H:m ", strtotime(($value->created_at)))}} WIB</td>
              <td>{{$value->barang[0]['nama']}}</td>
              <td><span class="badge badge-danger">{{$value->stok_keluar}}</span></td>
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