<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        <style>body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 3px;
        }

        th {
            text-align: left;
        }

        .d-block {
            display: block;
        }

        img {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .p-1 {
            padding: 5px 1px 5px 1px;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .border-bottom-header {
            border-bottom: 1px solid;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid;
        }
    </style>
</head>

<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ asset('logo-poltek.png') }}" style="height: 80px; width: auto;">
            </td>
            <td width="85%">
                <span class="text-center"
                    style="display:block; font-size: 11pt; font-weight: bold; margin-bottom: 2px;">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
                </span>
                <span class="text-center"
                    style="display:block; font-size: 13pt; font-weight: bold; margin-bottom: 2px;">
                    POLITEKNIK NEGERI MALANG
                </span>
                <span class="text-center" style="display:block; font-size: 10pt;">
                    Jl. Soekarno-Hatta No. 9 Malang 65141
                </span>
                <span class="text-center" style="display:block; font-size: 10pt;">
                    Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420
                </span>
                <span class="text-center" style="display:block; font-size: 10pt;">
                    Laman: www.polinema.ac.id
                </span>
            </td>
        </tr>
    </table>

    <h3 class="text-center">LAPORAN DATA PENJUALAN</h3>

    <table class="border-all font-11">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Penjualan</th>
                <th>Petugas</th>
                <th>Pembeli</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Total Harga</th>
                <th class="text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $p)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $p->penjualan_kode }}</td>
                    <td>{{ $p->user->nama ?? '-' }}</td>
                    <td>{{ $p->pembeli ?? '-' }}</td>
                    <td class="text-right">{{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($p->total, 0, ',', '.') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($p->penjualan_tanggal)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>