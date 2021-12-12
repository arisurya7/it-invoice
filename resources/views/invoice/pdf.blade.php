<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ bcrypt($invoice->nomor_invoice) }}</title>
    <style>
        header {
            position: fixed;
            top: 0;
            left: 2.5cm;
            right: 2cm;
            height: 6cm;

        }

        body {
            margin-top: 6cm;
            margin-left: 2.5cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        @page {
            margin: 0cm 0cm;
        }

        main {
            margin-top: 20px;
        }

        .header {
            display: inline-block;
        }

        p {
            font-size: 12pt;
        }

        .regarding {
            position: relative;
            width: inherit;
        }

        #regarding-left {
            display: inline-block;
            vertical-align: top;
        }

        #regarding-right {
            display: inline-block;
            vertical-align: top;
            margin-left: 270px;
        }

        #right-header {
            vertical-align: bottom;
        }


        #left-header .text-header {
            margin-top: 100px;
        }

        #left-header {
            vertical-align: top;
            width: 350px;
        }

        #title {
            margin-left: 190px;
            color: rgb(0, 195, 255);
            margin-bottom: 30px;
        }

        .header img {
            width: 100px;
            height: auto;
            padding-top: 1cm;
        }

        .text-header,
        .text-agreement {
            line-height: 2pt;
        }

        .text-regarding {
            line-height: 10pt;
        }

        .recipient,
        .feature-table {
            font-weight: bold;
        }

        .line-header {
            height: 2px;
            background-color: rgb(0, 195, 255);
            width: 610px;
        }

        .table-demand table {
            border-collapse: collapse;
            width: 610px;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .table-demand thead,
        .table-demand tfoot,
        .table-demand table {
            border: 1px solid black;
        }

        .table-demand tr.bottom-border td {
            border-bottom: 1px solid black;
        }

        .table-demand .desc {
            padding-left: 25px;
        }

        .table-demand .amnt {
            text-align: right;
            padding: 10px;
        }

        .description,
        .amount {
            width: 50%;
        }

        thead {
            background-color: #aed1ff;
            color: black;
            text-align: center;
        }

        ul.desc,
        ul.amnt {
            list-style-type: none;
        }

        ul.amnt {
            text-align: right;
            padding-right: 10px;
        }

        .total,
        .termin,
        .termin-value,
        .total-value {
            text-align: right;
            font-weight: bold;
            padding-right: 10px;
        }


        .termin-row, .bottom-border {
            background-color: #f8deb6;
        }

        .agreement {
            margin-top: 30px;
            display: inline-block;
            position: relative;
        }

        #agreement-left {
            width: 300px;
        }

        .director-name {
            margin-top: 100px;
            margin-left:50px;
            text-decoration-line: inherit;
        }

        #agreement-right {
            padding-left: 50px;
            width: 230px;
        }

        #agreement-right .cap {
            width: 70px;
            height: auto;
            position: absolute;
            opacity: 0.5;
            top: 25px;
            left: 25px;
        }

        #agreement-right .signature {
            width: auto;
            height: 120px;
            position: absolute;
            opacity: 0.5;
            top: 20px;
            left: 30px;
        }

        .agreement .role {
            text-align: center;
        }

        .payment table {
            border-collapse: collapse;
            padding: 0;
        }

    </style>
</head>

<body>

    <header>
        <div class="header" id="left-header">
            <img src="assets/dist/img/logo-company.jpg" alt="">
        </div>
        <div class="header" id="right-header">
            <p class="title" id="title">INVOICE</p>
            <table>
                <tr>
                    <td class="date">Invoice Date</td>
                    <td> : </td>
                    <td>{{ $invoice->tanggal }}</td>
                </tr>
                <tr>
                    <td class="number">Inovice Number</td>
                    <td> : </td>
                    <td>{{ $invoice->nomor_invoice }}</td>
                </tr>
                <tr>
                    <td class="date">Term</td>
                    <td> : </td>
                    <td>{{ $invoice->termin }}</td>
                </tr>
                <tr>
                    <td class="date">Due Date</td>
                    <td> : </td>
                    <td>{{ $duedate }}</td>
                </tr>
            </table>
        </div>
        <p class="text-header">Jl. Gatot Subroto no.9, Denpsar</p>
        <p class="text-header">info@itcompany.id</p>
        <div class="line-header"></div>

    </header>

    <main>
        <div class="regarding">
            <div class="left" id="regarding-left">
                <p class="text-regarding">Bill to :</p>
                <p class="text-regarding recipient">{{ $project->customer->nama_customer }}</p>
            </div>
            <div class="right" id="regarding-right">
                <p class="text-regarding">For :</p>
                <p class="text-regarding">{{ $invoice->perihal }}</p>
            </div>
        </div>

        <br>
        <div class="table-demand">
            <table rules='cols'>
                <thead>
                    <tr>
                        <td class="feature-table description">Description</td>
                        <td class="feature-table amount">Amount (Rp)</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($descriptions as $item)
                    <tr>
                        <td class="desc">{{ $item->deskripsi }}</td>
                        <td class="amnt">Rp {{ number_format($item->ammount,0, ",", ".")}},-</td>
                    </tr>
                    @endforeach                    
                </tbody>
                <tfoot>
                    <tr class="bottom-border">
                        <td class="total">Total</td>
                        <td class="total-value">Rp {{ number_format($invoice->total,0, ",", ".")}},-</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="payment">
            <table>
                <tbody>
                    <tr>
                        <td>Metode Pembayaran</td>
                        <td> : </td>
                        <td>{{ $invoice->metode_pembayaran }}</td>
                    </tr>
                    <tr>
                        <td>Nama Bank</td>
                        <td> : </td>
                        <td>{{ $invoice->bank }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Rekening</td>
                        <td> : </td>
                        <td>{{ $invoice->no_rekening }}</td>
                    </tr>
                    <tr>
                        <td>Alamat/Cabang Bank</td>
                        <td> : </td>
                        <td>{{ $invoice->cabang_bank }}</td>
                    </tr>
                    <tr>
                        <td>Nama Penerima </td>
                        <td> : </td>
                        <td>{{ $invoice->penerima }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="agreement" id="agreement-left"> </div>
        <div class="agreement" id="agreement-right">
            <img class="cap" src="" alt="">
            <img class="signature" src="" alt="">
            <p class="text-agreement">Denpasar, {{ $print_date }}</p>
            <p class="text-agreement director-name"><u>I Kadek Ari Surya</u></p>
            <p class="text-agreement role">(Director)</p>
        </div>
    </main>

</body>

</html>
