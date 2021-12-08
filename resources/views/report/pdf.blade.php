<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Report Invoice</title>
    <style>
        body {
            margin-top: 1.5cm;
            margin-bottom: 1.5cm;
        }

        .table-report th,
        .table-report td {
            border: 1px solid black;
        }

        .table-report table td,
        .table-report table th {
            padding: 10px;
        }

        .table-report table {
            width: 90%;
            margin: auto;
        }

        .header {
            display: inline-block;
        }

        .top-header {
            margin-top: -40px;
            text-align: center;
        }

        .title-report {
            color: rgb(7, 124, 179);
        }

        .top-header p {
            margin-top: -15px;
        }

        #left-header {
            margin-left: 50px;
            margin-top: 30px;
            float: left;
        }

        #right-header {
            float: right;
            margin-right: 50px;
            margin-bottom: 90px;
        }

        thead {
            background-color: rgb(149, 205, 241);
        }

    </style>
</head>

<body>

    <header>
        <div class="top-header">
            <h2 class="title-report">Report Invoice IT Company</h2>
            <p>Company Addess</p>
            <p>info@company.com</p>
        </div>
        <div class="header" id="left-header">
            <table>
                <tr>
                    <td>Status</td>
                    <td> : </td>
                    <td>{{ $filter['status']?? 'All Status' }}</td>
                </tr>
                <tr>
                    <td>Project</td>
                    <td> : </td>
                    <td>{{ $filter['project'][0]->nama_project?? 'All Project' }}</td>
                </tr>
                <tr>
                    <td>Customer</td>
                    <td> : </td>
                    <td>{{ $filter['customer'][0]->nama_customer?? 'All Customer' }}</td>
                </tr>
            </table>
        </div>
        <div class="header" id="right-header">
            <table>
                <tr>
                    <td>Start Date</td>
                    <td> : </td>
                    <td>{{ $filter['begin_date']??'All Date' }}</td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td> : </td>
                    <td>{{ $filter['last_date'] ?? 'All Date'}}</td>
                </tr>
                <tr>
                    <td>Grand Total</td>
                    <td> : </td>
                    <td>Rp {{ number_format($grandTotal,0, ",", ".") }},-</td>
                </tr>
            </table>
        </div>
    </header>
    <main>
        <div class="table-report">
            <table rules='cols'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Invoice</th>
                        <th>Project</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Perihal</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="actionz">
                    @foreach ($invoice as $key=>$item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{$item->nomor_invoice}}</td>
                        <td>{{$item->project->nama_project}}</td>
                        <td>{{$item->project->customer->nama_customer}}</td>
                        <td>{{date('d-m-Y',strtotime($item->tanggal))}}</td>
                        <td>{{$item->perihal}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{ number_format($item->total,0, ",", ".") }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>
