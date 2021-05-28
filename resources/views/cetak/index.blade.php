<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak LAPORAN</title>

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
        <img height="60px" src="..\public\adminto\images\brand\logo-big.png" alt="">
      </div>
      <div style="text-align: center; ">
        <span style="font-size: 24px; font-weight: bold;">PT TUJUHSATU MAHAKARYA INDONESIA</span> <br>
        <span style="font-size: 18px; font-weight: bold; color: blue; ">{{$header}}</span><br>
        <br>
        <hr>
      </div>


    </div>
    <div id="body">

      
      <div style="font-size: 12px;">
        <p >Tanggal {{date('d-M-Y', strtotime($start))}} s/d {{date('d-M-Y', strtotime($end))}} </p>

        <div style="font-size: 12px;">
          <table style="width: 100%; border-style: solid !important; border-collapse: collapse; " border="1">
            <thead>
              <tr>
                <th style="padding: 5px;">No.</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Stok Keluar</th>
                <th>Lokasi</th>
                <th>Nama Pengambil</th>
                <th>Fungsi</th>
              </tr>
            </thead>
            <tbody style="text-align: center !important">
           
              @foreach($barang as $key => $value)
             
              <tr>
                <td style="padding: 5px;">{{$key+1}}</td>
                <td>{{date('d-M-Y', strtotime($value->created_at))}} </td>
                <td>{{$value->barang[0]['nama']}}</td>
                <td>{{$value->stok_keluar}}</td>
                <td>{{$value->lokasi}}</td>
                <td>{{$value->pengambil}}</td>
                <td>{{$value->fungsi}}</td>
              </tr>

              @endforeach

            

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