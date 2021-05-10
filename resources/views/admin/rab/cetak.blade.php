<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Rab</title>

  <style>
    html,
    body {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    #container {
      min-height: 100%;
      position: relative;
    }

    #header {
      padding-left: 30px;
      padding-right: 30px;
      padding-top: 30px;
    }

    #body {
      padding: 30px;
      padding-bottom: 60px;
      /* Height of the footer */
    }

    #footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 60px;
    }
  </style>

</head>

<body>

  <div id="container">
    <div id="header">
      <div style="float: left;">
        <img height="60px" src="..\public\adminto\images\brand\sejahtera.png" alt="">
      </div>
      <div style="float: right; ">
        <img height="40px" src="..\public\adminto\images\brand\ims.jpg" alt="">
      </div>
      <div style="text-align: center; ">
        <span style="font-size: 24px; font-weight: bold;">PT. SEJAHTERA MANDIRI PEKANBARU</span> <br>
        <span style="font-size: 18px; font-weight: bold; color: blue; ">RANCANGAN ANGGARAN BIAYA</span><br>
        <br>
        <hr>
      </div>


    </div>
    <div id="body">

      <p>Berikut ini kami sampaikan terkait orderan tanggal {{date('d-M-Y', strtotime($rab['created_at']))}} untuk dapat dikirim.</p>

      <div style="font-size: 12px;">
        <table style="border: 1px;">
          <thead></thead>
          <tbody>

            <tr>
              <td>Kode PO</td>
              <td style="padding-left: 50px;">:</td>
              <td>{{strtoupper($rab['nama'])}}</td>
            </tr>

            <tr>
              <td>Tanggal PO</td>
              <td style="padding-left: 50px;">:</td>
              <td>{{date('d-M-Y', strtotime($rab['created_at']))}}</td>
            </tr>

          </tbody>
          </td>
        </table>

        <br>

        <div style="font-size: 12px;">
          <table style="width: 100%; border-style: solid !important; border-collapse: collapse; " border="1">
            <thead>
              <tr>
                <th style="padding: 5px;">No.</th>
                <th>Nama Barang</th>
                <th>Suplier</th>
                <th>Harga (Rp.)</th>
                <th>Kuantitas</th>
                <th>Total Harga (Rp.)</th>
              </tr>
            </thead>
            <tbody style="text-align: center !important">
              @php
              $harga_total = 0;
              @endphp
              @foreach($rab_temp as $key => $value)
              @php
              $total = $value[0]->barang[0]->harga * $value[0]['kuantitas'];
              $harga_total = $harga_total + ($value[0]->barang[0]->harga * $value[0]['kuantitas']);
              @endphp
              <tr>
                <td style="padding: 5px;">{{$key+1}}</td>
                <td>{{$value[0]->barang[0]->nama}}</td>
                <td>{{$value[0]->barang[0]->suplier}}</td>
                <td>{{$value[0]->barang[0]->harga}}</td>
                <td>{{$value[0]['kuantitas']}}</td>
                <td>{{$total}}</td>

              </tr>

              @endforeach

              <tr>
                <td style="padding: 5px;" colspan="5">Total</td>
                <td>Rp. {{$harga_total}}</td>
              </tr>


            </tbody>
            </td>
          </table>
        </div>


        <div style="font-size: 12px;">
          <p style="text-align: right;">
            <strong>
              Pekanbaru, {{date('d-M-Y', strtotime(now()))}}
              <br>
              <br>
              Hormat Kami
              <br>
              PT. Sejahtera Mandiri Pekanbaru
            </strong>
          </p>

        </div>


      </div>
      <div id="footer">
        <img height="60px" src="..\public\adminto\images\brand\footer.jpg" alt="">
      </div>
    </div>

</body>
</html>