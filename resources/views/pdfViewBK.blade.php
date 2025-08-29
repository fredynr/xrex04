<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>imprimir</title>
    <style>
        @font-face {
            font-family: 'Great Vibes';
            src: url("{{ public_path('storage/fonts/GreatVibes-Regular.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: "Roboto Regular";
            src: url({{ public_path('fonts/Roboto-Regular.ttf') }});
        }

        @font-face {
            font-family: "Roboto Thin";
            src: url({{ public_path('fonts/Roboto-Thin.ttf') }});
        }

        body {
            background: #636363;
            position: relative;
            font-family: 'Roboto Regular', sans-serif;
            display: block;
            margin: auto;
        }

        main {
            background: #fff;
            padding: 0 1cm;
            box-shadow: 7px 4px 27px 1px;
            position: relative;
            max-width: 21cm;
        }
        .body-class{
            display: flex;
            justify-content: center;
        }
        .main-class{
            height: 25.6cm;
        }

        figure {
            display: block;
            text-align: center;
        }

        .content-boxes h2 {
            padding: 3px;
            border-radius: 5px 5px 0px 0px;
            width: 10cm;
            border-top: 1px solid #b7b7b7;
            margin: 0;
            border-left: 1px solid #b7b7b7;
            border-right: 1px solid #b7b7b7;
            color: #575656;
            font-weight: 100;
            background: #eaeeff;
        }

        .content-boxes p {
            margin-top: 0;
            border: 1px solid #b7b7b7;
            padding: 10px;
        }

        header ul {
            border-bottom: 3px solid #9b9ced;
            padding-bottom: 0.5cm;
        }

        header li {
            font-size: .5cm;
        }

        header li>i {
            display: inline-block;
            width: 10cm;
            font-size: .4cm;
            border-bottom: 1px dashed;
        }

        header li>span {
            display: inline-block;
            width: 2.8cm;
        }

        #logo {
            width: 5cm;
        }

        #title-h {
            display: block;
            text-align: center;
        }

        .title1 {
            font-family: "Great Vibes", cursive;
            font-size: 1.1cm;
            color: #0002a1
        }

        #title-h>h2 {
            font-size: .4cm;
        }

        li {
            list-style: none;
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

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding-top: .5cm;
            border-top: 1px solid;
            background: #ffffff;
        }

        footer>article {
            display: inline-block;
            width: 30%;
            /* margin: 1%; */
            text-align: center;
        }

        footer>article>span {
            /* display: inline-block; */
        }
    </style>
</head>

<body class="{{ empty($desdePdf) ? 'body-class' : '' }}">
    <main class="{{ !empty($desdePdf) ? 'main-class' : '' }}">
        @if (empty($desdePdf))
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
            <figure><img id="logo" src="{{ public_path('images/logo.png') }}" alt=""></figure>
            <div id="title-h">
                <div class="title1">
                    Dr. {{ $estudio->specialistUser->name }}
                </div>
                <span>Médico Radiólogo</span>
            </div>
            
            <ul>
                <li><span>Nombre:</span> <i>
                    {{ $estudio->patient->name }}
                </i> </li>
                <li><span>Dirección:</span> <i>
                    {{ $estudio->patient->direction }}
                </i></li>
                <li><span>Teléfono:</span> <i>
                    {{ $estudio->patient->phone }}
                </i></li>
                <li><span>E-mail:</span> <i>
                    {{ $estudio->patient->email }}
                </i></li>
                <li><span>Fecha:</span> <i>
                    {{ date('d-m-Y H:i:s') }}</i></li>
                </ul>
            </header>
            <div class="content-boxes">
                <h2>Estudio Realizado</h2>
                <p>
                    {{ $estudio->study_name }}
                </p>
            </div>
            <div class="content-boxes">
                <h2>Lectura</h2>
                <p>
                    {{ $estudio->reading }}
                </p>
            </div>
            <div class="content-boxes">
                <h2>
                    Lugar de procedencia:
                </h2>
                <p>
                    <span> <b></b>
                        {{ optional($estudio->exam->departurePlace)->name }}
                    </span> <br>
                </p>
            </div>
            @if (!empty($desdePdf))
            <footer>
                <article>
                    <div>Dirección:</div>
                    <span> Calle 123 #45-67 Barrio Lindo</span>
                    <span>Ciudad: Bogotá</span>
                </article>
                <article>
                    <div>Teléfonos</div>
                    <span> Móvil: 3201233223</span>
                    <span>Teléfono fijo: 2345678</span>
                </article>
                <article>
                    <div>web</div>
                    <span>web: www.hospital.com </span>
                    <span>e-mail: hospital@mail.com</span>
                </article>
            </footer>
            @endif
        </main>
    </body>
    </html>
