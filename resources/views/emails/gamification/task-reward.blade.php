<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>¡Ganaste Yapitas!</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f3f5f9;
    font-family:Arial,Helvetica,sans-serif;
">

<table role="presentation"
       width="100%"
       cellpadding="0"
       cellspacing="0"
       style="background:#f3f5f9;">

    <tr>
        <td align="center" style="padding:30px 12px;">

            <!-- CONTENEDOR -->
            <table role="presentation"
                   width="100%"
                   cellpadding="0"
                   cellspacing="0"
                   style="
                       max-width:560px;
                       background:#ffffff;
                       border-radius:20px;
                       overflow:hidden;
                   ">

                <!-- HEADER -->
                <tr>
                    <td align="center"
                        style="
                            background:#435cf0;
                            padding:30px 20px;
                        ">

                        <img
                            src="{{ $logoUrl }}"
                            alt="Yapita"
                            width="110"
                            style="
                                max-width:110px;
                                height:auto;
                                display:block;
                            "
                        >

                        <h1 style="
                            color:#ffffff;
                            font-size:25px;
                            margin:20px 0 8px;
                        ">
                            🎉 ¡Felicidades!
                        </h1>

                        <p style="
                            color:#ffffff;
                            font-size:15px;
                            margin:0;
                        ">
                            Has ganado Yapitas
                        </p>

                    </td>
                </tr>

                <!-- CONTENIDO -->
                <tr>
                    <td style="padding:28px 25px;">

                        <p style="
                            color:#374151;
                            font-size:15px;
                            line-height:24px;
                        ">
                            Hola, <strong>{{ $userName }}</strong>.
                            Completaste una tarea y recibiste
                            una nueva recompensa.
                        </p>

                        <!-- IMAGEN TAREA -->
                        @if(!empty($taskImage))
                            <img
                                src="{{ $taskImage }}"
                                alt="{{ $taskName }}"
                                width="510"
                                style="
                                    width:100%;
                                    max-width:510px;
                                    height:auto;
                                    border-radius:14px;
                                    display:block;
                                "
                            >
                        @endif

                        <!-- NOMBRE -->
                        <h2 style="
                            font-size:21px;
                            color:#111827;
                            margin:24px 0 10px;
                        ">
                            {{ $taskName }}
                        </h2>

                        <!-- DESCRIPCIÓN -->
                        <p style="
                            font-size:15px;
                            color:#6b7280;
                            line-height:24px;
                            margin-bottom:25px;
                        ">
                            {{ $taskDescription }}
                        </p>

                        <!-- PUNTOS GANADOS -->
                        <table role="presentation"
                               width="100%"
                               cellpadding="0"
                               cellspacing="0"
                               style="
                                   background:#eef2ff;
                                   border-radius:16px;
                               ">

                            <tr>
                                <td align="center"
                                    style="padding:25px 15px;">

                                    <p style="
                                        color:#435cf0;
                                        font-size:13px;
                                        font-weight:bold;
                                        margin:0 0 10px;
                                    ">
                                        RECOMPENSA OBTENIDA
                                    </p>

                                    <p style="
                                        font-size:42px;
                                        font-weight:bold;
                                        color:#435cf0;
                                        margin:0;
                                    ">
                                        +{{ number_format($points, 0) }}
                                    </p>

                                    <p style="
                                        color:#435cf0;
                                        font-size:16px;
                                        font-weight:bold;
                                        margin:8px 0 0;
                                    ">
                                        Yapitas
                                    </p>

                                </td>
                            </tr>

                        </table>

                        <!-- BOTÓN -->
                        <table role="presentation"
                               cellpadding="0"
                               cellspacing="0"
                               align="center"
                               style="margin-top:28px;">

                            <tr>
                                <td align="center"
                                    bgcolor="#435cf0"
                                    style="border-radius:12px;">

                                    <a href="{{ $walletUrl }}"
                                       style="
                                           display:inline-block;
                                           padding:16px 32px;
                                           color:#ffffff;
                                           font-size:15px;
                                           font-weight:bold;
                                           text-decoration:none;
                                           border-radius:12px;
                                       ">
                                        Ver mis Yapitas
                                    </a>

                                </td>
                            </tr>

                        </table>

                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td align="center"
                        style="
                            padding:25px;
                            background:#f9fafb;
                        ">

                        <p style="
                            font-size:14px;
                            color:#374151;
                            margin:0 0 8px;
                        ">
                            Sigue participando y gana más recompensas.
                        </p>

                        <p style="
                            font-size:12px;
                            color:#9ca3af;
                            margin:0;
                        ">
                            © {{ date('Y') }} Yapita.
                            Todos los derechos reservados.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>

</table>

</body>
</html>
