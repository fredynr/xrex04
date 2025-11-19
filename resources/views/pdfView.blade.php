<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>imprimir</title>
    <style>
        .html_footer {
            position: absolute;
            bottom: 0;
            left: 1cm;
            right: 0;
            height: 5cm;
            display: flex;
            flex-direction: column;
            text-align: left;
            font-size: 10px;
        }

        .html_footer img {
            height: 2.5cm;
            border-bottom: 1px solid #353535;
        }

        #html_footer {
            position: fixed;
            bottom: -6cm;
            left: 0;
            right: 0;
            height: 6cm;
            text-align: left;
            font-size: 10px;
        }

        #html_footer img {
            height: 2.5cm;
            border-bottom: 1px solid #353535;
        }

        @page {
            margin-top: 0.4cm;
            margin-right: 1cm;
            margin-bottom: 6cm;
            margin-left: 1cm;
            footer: html_footer;

            @bottom-center {
                content: element(html_footer);
            }
        }

        body {
            background: #ffffff;
            position: relative;
            font-family: 'Roboto Regular', sans-serif;
            display: block;
            margin: auto;
        }

        .main-class {
            position: relative;
            height: 25.6cm !important;
            box-shadow: 0px 2px 27px 1px #353535;
            padding: 1cm;
        }

        main {
            background: #fff;
            padding: 0;
            width: 19.6cm;
            height: 21.22cm;
        }

        .body-class {
            background: #858585;
            display: flex;
            justify-content: center;
        }

        .description_html {
            padding: 1cm;
        }

        h1 {
            font-size: 14px;
            margin: 0;
        }

        td {
            vertical-align: top;
        }

        br {
            display: block;
            margin-bottom: 5px;
        }

        .logo {
            width: 1.6cm;
        }

        .container-head {
            width: 15.6cm;
            margin-top: 0.2cm;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .left-head {
            float: left;
            font-size: 8px;
            width: 6cm;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .txt-md {
            font-size: 14px;
        }

        .txt-bold {
            font-weight: 600;
            color: #353535;
        }

        .bold {
            font-weight: 600;
        }

        .align-left {
            text-align: left;
        }

        .mt-m {
            margin: 6px 0 0 0;
        }

        .left-head>span {
            display: block;
        }

        .right-head {
            border: 1px solid #353535;
            border-radius: 5px;
            padding: 0 4px;
            float: right;
            width: 9cm;
            font-size: 12px;
            margin-left: 10px;
        }

        .right-head-head {
            border-bottom: 1px solid;
            text-align: center;
        }

        .right-head-head h2 {
            font-size: 14px;
            margin: 0;
        }

        .right-head-head span {
            font-size: 14px;
        }

        .right-body {
            display: flex;
        }

        .title1 {
            background: #e0e0e0;
            font-size: 10px;
            padding: 4px 10px 4px 4.5cm;
            border: 1px solid #858585;
        }

        .estudio {
            font-size: 10px;
            padding: 0.5cm 10px 1cm 4.5cm;
        }

        .description {
            font-size: 12px;
        }

        .wrapper-pdf {
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .dw-pdf {
            display: block;
            position: absolute;
            top: -10vh;
            font-family: "Roboto Thin";
            font-size: .6rem;
            transition: all ease 1s;
            background: rgb(55 54 54);
            text-align: center;
            width: 50%;
        }

        .dw-pdf a {
            color: #fff;
        }

        .dw-pdf i {
            color: #b30c00;
        }

        main:hover .dw-pdf {
            transform: translateY(100vh);
        }
    </style>
</head>

<body class="{{ !$desdePdf ? 'body-class' : '' }}">
    <div id="html_footer">
        <div class="bold">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/signatures/'. $estudio->specialistUser->id .'.png'))) }}"
                style="display: block; margin: 0; padding: 0;">
            <div style="margin:8px 0;">{{ $estudio->specialistUser->name }}</div>
            <div>Tarjeta Nro. #########</div>
            <div>RADIOLOGÍA E IMÁGENES MÉDICAS</div>
        </div>
        <div>
            <div>CENTRO DE ECO-RADIODIAGNÓSTICOS S.A.S. — Página clínica generada automáticamente</div>
            <div>CALLE 12 N 13 20 PISO 1 EDIFICIO MARIANGOLA OCAÑA TEL: 5694438</div>
        </div>
    </div>

    <main class="{{ !$desdePdf ? 'main-class' : '' }}">
        @if (!$desdePdf)
            <div class="html_footer">
                <div class="bold">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/signatures/' . $estudio->specialistUser->id . '.png'))) }}"
                        style="display: block; margin: 0; padding: 0;">
                    <div style="margin:8px 0;">{{ $estudio->specialistUser->name }}</div>
                    <div>Tarjeta Nro. #########</div>
                    <div>RADIOLOGÍA E IMÁGENES MÉDICAS</div>
                </div>
                <div>
                    <div>CENTRO DE ECO-RADIODIAGNÓSTICOS S.A.S. — Página clínica generada automáticamente</div>
                    <div>CALLE 12 N 13 20 PISO 1 EDIFICIO MARIANGOLA OCAÑA TEL: 5694438</div>
                </div>
            </div>
        @endif
        @if (!$desdePdf)
            <div class="wrapper-pdf">
                <span class="dw-pdf">
                    <h1>
                        <a class="btn-pri" href="{{ route('downloadPdf', $estudio->id) }}">Descargar PDF</a>
                        <i class="fas fa-file-pdf"></i>
                    </h1>
                </span>
            </div>
        @endif
        <header>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="vertical-align: top;">
                            <figure class="logo">
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logoIPS.png'))) }}"
                                    style="display: block; margin: 0; padding: 0;" width="90">
                            </figure>
                        </td>
                        <td style="vertical-align: top;">
                            <h1>CENTRO DE ECO-RADIODIAGNOSTICOS SOCIEDAD ANONIMA SIMPLIFICADA</h1>
                            <div class="container-head clearfix">
                                <div class="left-head">
                                    <span>NIT: 900,332,743-3</span>
                                    <span>CALLE 12 N 13 20 PISO 1 EDIFICIO MARIANGOLA</span>
                                    <span>OCAÑA TEL: 5694438</span>
                                    <span class="txt-md mt-m">{{ $estudio->exam->departurePlace->name }}</span>
                                    <span class="txt-md align-left mt-m"><span class="txt-bold">FECHA:</span>
                                        {{ strtoupper(\Carbon\Carbon::now('America/Bogota')->translatedFormat('d/M/Y h:i A')) }}
                                    </span>
                                    <span class="txt-md align-left mt-m"><span class="txt-bold">INGRESO:</span>
                                        71686 -
                                        2</span>
                                </div>
                                <div class="right-head">
                                    <div class="right-head-head">
                                        <h2>{{ $estudio->patient->name }} {{ $estudio->patient->first_surname }}</h2>
                                        <span>Documento {{ $estudio->patient->type_document }} :
                                            {{ $estudio->patient->document }}</span>
                                    </div>
                                    <div class="right-body"">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="text-right bold">Edad:</td>
                                                    <td style="width: 3.8cm;">{{ $estudio->patient->age }}</td>
                                                    <td class="text-right bold">Sexo:</td>
                                                    @if ($estudio->patient->sexo === 'F')
                                                        <td>Femenino</td>
                                                    @elseif ($estudio->patient->sexo === 'M')
                                                        <td>Masculino</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td class="text-right bold">Nacimiento</td>
                                                    <td style="width: 3.8cm;">{{ $estudio->patient->birth }}</td>
                                                    <td class="text-right bold">Teléfono</td>
                                                    <td>{{ $estudio->patient->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right bold">Dirección:</td>
                                                    <td style="width: 3.8cm;">{{ $estudio->patient->direction }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right bold">Empresa:</td>
                                                    <td>{{ $estudio->exam->epsSender->name }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>
        <div class="title1">
            DESCRIPCIÓN DEL PROCEDIMIENTO
        </div>
        <div class="estudio">
            {{ $estudio->study_name }}
        </div>

        <div class="description">{!! nl2br(e($estudio->reading)) !!}</div>

    </main>


</body>

</html>
