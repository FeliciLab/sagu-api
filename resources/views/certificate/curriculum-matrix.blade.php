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
            padding: 3px 0;
            background-color: #2f4f4f;
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
                    <td>FUNDAMENTOS EM GERONTOLOGIA</td>
                </tr>
                <tr>
                    <td class="title">MATRIZ:</td>
                    <td>FUNDAMENTOS EM GERONTOLOGIA</td>
                </tr>
                <tr>
                    <td class="title">PERÍODO:</td>
                    <td>01/07/2022 a 31/07/2022</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="details-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="module-name" colspan="2">Módulo I: Envelhecimento, Velhice e Sociedade</th>
                    <th colspan="2">CARGA HORÁRIA</th>
                </tr>
                <tr>
                    <th>CÓDIGO</th>
                    <th>UNIDADE DIDÁTICA</th>
                    <th>P</th>
                    <th>E.C</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 20%;">GERONTO M1 U1</td>
                    <td style="width: 60%;">O PROCESSO DE ENVELHECIMENTO A PARTIR DE UMA VISÃO BIOPSICOSSOCIAL</td>
                    <td class="module-workload">4</td>
                    <td class="module-workload"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">TOTAL DO MÓDULO</th>
                    <td colspan="2">8</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="total-wrapper">
        <table>
            <tr>
                <th>TOTAL DA MATRIZ</th>
                <td>40</td>
            </tr>
        </table>
    </div>
</body>

</html>
