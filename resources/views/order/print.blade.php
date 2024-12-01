<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .main {
            height: 100vh;
        }

        .kotak {
            height: 600px;
            width: 550px;
            box-sizing: border-box;
            border-radius: 10px;
        }

        .isi .btn {
            height: 40px;
            width: 77px;
        }

        h2 {
            font-size: .9rem;
        }

        p {
            font-size: .8rem;
            color: #666;
            line-height: 1.2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px 0 5px 15px;
            border: 1px solid #eee;
        }

        .tabletitle {
            font-size: 1rem;
            background: #eee;
        }

        .itemtext {
            font-size: .7rem;
        }
    </style>
</head>

<body>
    <div class="container main d-flex flex-column justify-content-center align-items-center ">

        <div class="container kotak p-5 shadow-lg p-3 mb-5">

            <p class="container text-center fs-5 fw-bold">Naspad Roy</p>
            <p>Alamat : ketidakpastian</br>
                Email : t7D8o@example.com </br>
                Phone : 000-000-000</p>
         

            <div id="table">
                <table>
                    <tr class="table-title">
                        <td class="item">
                            <h2>Menu</h2>
                        </td>
                        <td class="item">
                            <h2>Total</h2>
                        </td>
                        <td class="item">
                            <h2>Harga</h2>
                        </td>
                    </tr>
                    @foreach ($order['naspads'] as $naspad)
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">{{ $naspad['name_naspads'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ $naspad['qty'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">Rp.{{ number_format($naspad['price'], 0, ',','.') }}</p>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="tabletitle">
                        <td></td>
                        <td class="rate">
                            <h2>PPN 10%</h2>
                        </td>
                        @php
                            $ppn = $order['total_price'] * 0.01;
                        @endphp
                        <td class="payment">
                            <h2>Rp. {{ number_format($ppn, 0, ',', '.`') }}</h2>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="rate">Total harga</td>
                        <td class="payment">
                            Rp. {{ number_format($order['total_price'] + $ppn, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
                
            </div>
            <div class="container isi d-flex justify-content-between m-2">
                
                <div class="satu">
                    <a href="{{ route('orders.download', $order['id']) }}" class="btn btn-primary">Cetak (.pdf)</a>
                    <a href="{{ route('orders') }}" class="btn btn-warning">Kembali</a>
                </div>

            </div>  
            <p class="container">Terimakasih atas pembelian anda ! Kami berharap and puas dengan pelayanan kami. Jangan
                Ragu
                untuk datang lagi</p>
        </div>

    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
