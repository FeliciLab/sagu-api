<html>

<head>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        header {
            text-align: center;
        }

        .matrix-info-wrapper,
        .details-wrapper {
            margin-bottom: 15px;
        }

        .matrix-info-wrapper table,
        .details-wrapper table,
        .total-wrapper table {
            width: 100%;
            border: 1px solid #dee2e6;
            border-collapse: collapse;
        }

        .matrix-info-wrapper table td,
        .details-wrapper table td,
        .total-wrapper table td {
            background-color: #e6e6e6;
            padding: 3px 5px;
        }

        .details-wrapper table th,
        .total-wrapper table th {
            background-color: #c0c0c0;
        }

        .matrix-info-wrapper table td,
        .details-wrapper table th,
        .details-wrapper table td {
            border: 1px solid #D3D3D3;
        }

        .matrix-info-wrapper thead th {
            color: white;
            font-size: 16px;
            padding: 4px 0;
            background-color: #0A8A4B;
            border: 1px solid #0A8A4B;
        }

        .matrix-info-wrapper tbody .title {
            width: 20%;
            font-weight: bold;
        }

        .matrix-info-wrapper tbody td {
            font-size: 14px;
        }

        .details-wrapper thead .module-name {
            text-align: left;
            padding: 6px 5px;
        }

        .details-wrapper thead th {
            font-size: 14px;
        }

        .details-wrapper tbody td {
            font-size: 13px;
        }

        .details-wrapper tfoot th {
            text-align: right;
            font-size: 13px;
            padding-right: 7px;
        }

        .details-wrapper tfoot td {
            text-align: center;
            font-size: 13px;
        }

        .details-wrapper tbody .module-workload {
            width: 10%;
            text-align: center;
        }

        .total-wrapper table {
            font-size: 13px;
        }

        .total-wrapper th {
            width: 80%;
            text-align: right;
            padding-right: 7px;
        }

        .total-wrapper td {
            text-align: center;
        }

    </style>
</head>

<body>
    <header>
        <div style="width: 80%; height: 15px; background: #0A8A4B; border-radius: 0 0 16px 16px; margin-left: 10%; margin-bottom: 30px;"></div>
        <img width="350" src="/var/www/public/assets/images/certificate/esp-gov-ceara-logos.png" alt="Logotipos">
    </header>

    <div class="matrix-info-wrapper">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Matriz curricular do curso</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="title">CURSO:</td>
                    <td>{{ $course_name }}</td>
                </tr>
                <tr>
                    <td class="title">MATRIZ:</td>
                    <td>{{ $matrix_name }}</td>
                </tr>
                <tr>
                    <td class="title">PERÍODO:</td>
                    <td>{{ $course_period }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @foreach ($modules as $module)
    <div class="details-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="module-name">{{ $module['descricao_modulo'] }}</th>
                    <th colspan="2">CARGA HORÁRIA</th>
                </tr>
                <tr>
                    <th>UNIDADE DIDÁTICA</th>
                    <th>P</th>
                    <th>E.C</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($module['unidadedidatica'] as $didactic_unit)
                <tr>
                    <td style="width: 80%;">{{ $didactic_unit['nome_unidadedidatica'] }}</td>
                    <td class="module-workload">{{ $didactic_unit['cargahoraria_presencial'] }}</td>
                    <td class="module-workload">{{ $didactic_unit['cargahoraria_extraclasse'] }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>TOTAL DO MÓDULO</th>
                    <td colspan="2">{{ $module['carga_horaria_modulo'] }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endforeach

    <div class="total-wrapper">
        <table>
            <tr>
                <th>TOTAL DA MATRIZ</th>
                <td>{{ $course_workload }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
