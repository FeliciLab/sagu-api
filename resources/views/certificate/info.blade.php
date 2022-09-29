<html>

<head>
    <style>
        .info-wrapper {
            position: absolute;
            top: 280px;
            text-align: center;
            padding: 0 165px 0 100px;
            font-size: 18px;
        }

        .info {
            font-family: 'Archivo', sans-serif;
            letter-spacing: 0.5px;
        }

        .info span {
            font-weight: bold;
        }

        .date {
            font-family: 'Arial';
            font-weight: bold;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="info-wrapper">
        <p class="info">
            Certificamos que <span>{{ $student_name }}</span> concluiu com aproveitamento o curso <span>{{ $course_name }}</span>
            da Escola de Saúde Pública do Ceará Paulo Marcelo Martins Rodrigues (ESP/CE), realizado no período de <span>{{ $course_period }}</span>,
            com carga horária total de <span>{{ $course_workload }}</span>.
        </p>
        <p class="date">
            Fortaleza, {{ $today_date }}
        </p>
    </div>
</body>

</html>
