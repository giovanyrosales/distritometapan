<!--Parte superior de las paginas -  hasta head  -->
@include('frontend.menu.indexsuperior')


<style>
    :root{
        --brand:#14532d;       /* verde institucional */
        --brand-2:#0e7490;     /* acento */
        --ink:#0f172a;         /* texto principal */
        --muted:#475569;       /* texto secundario */
        --bg:#f8fafc;          /* fondo */
        --card:#ffffff;        /* tarjeta */
        --ring: rgba(20,83,45,.15);
        --radius: 16px;
    }

    /* Reset suave */
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
        margin:0;
        font: 16px/1.6 system-ui,-apple-system,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial;
        color:var(--ink);
        background:linear-gradient(180deg,var(--bg),#eef2f7 60%);
    }

    .wrap{
        max-width: 980px;
        margin: clamp(16px,4vw,48px) auto;
        padding: clamp(12px,2.5vw,24px);
    }

    .banner {
        background: #243b54; /* celestito pastel */
        border: 1px solid #e2e8f0;
        border-radius: calc(var(--radius) + 6px);
        padding: clamp(18px,3vw,28px);
        box-shadow: 0 20px 40px -24px var(--ring);
        position: relative;
        overflow: hidden;
    }

    .badge {
        display: inline-flex;
        gap: .5rem;
        align-items: center;
        font-weight: 600;
        letter-spacing: .2px;
        color: #000;              /* texto negro */
        background: #fff;         /* fondo blanco */
        border: 1px solid #d1d5db; /* gris suave para darle contorno */
        padding: .35rem .7rem;
        border-radius: 999px;
    }
    .badge svg {
        width: 18px;
        height: 18px;
        stroke: #000; /* ícono también en negro */
    }

    h1{
        margin: .6rem 0 0.2rem;
        font-size: clamp(1.4rem, 2.8vw, 2rem);
        line-height:1.25;
        color: #ffffff;
    }
    p.lead{
        margin: .2rem 0 1rem;
        margin-top: 5px;
        font-size: clamp(1.05rem, 1.8vw, 1.25rem);
        color: #ffffff;
    }

    .grid{
        display:grid;
        grid-template-columns: 1fr;
        gap: 18px;
        margin-top: 16px;
    }
    @media (min-width: 800px){
        .grid { grid-template-columns: 1.6fr 1.4fr; gap: 24px; }


    }
    .grid aside.card {
        align-self: start;   /* hace que el aside solo ocupe lo que necesita */
        height: auto;        /* asegura que no se estire */
    }

    .card{
        background:var(--card);
        border:1px solid #e5e7eb;
        border-radius: var(--radius);
        padding: clamp(14px,2.2vw,20px);
        box-shadow: 0 10px 24px -16px var(--ring);
    }

    .list{
        margin:0; padding-left: 1.2rem;
    }
    .list li{ margin:.35rem 0; }
    .list-checked{
        list-style:none; padding:0; margin:0;
    }
    .list-checked li{
        display:flex; gap:.6rem; align-items:flex-start;
        padding:.45rem .2rem;
    }
    .list-checked svg{flex:0 0 20px}
    .muted{ color:var(--muted); }

    .contacts{
        display:grid; gap:10px;
    }
    .contact-item{
        display: flex;
        gap: .8rem;
        align-items: flex-start;     /* texto alineado arriba con el icono */
        padding: 1rem;               /* más espacio interno */
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;         /* se mantiene el celeste */
        transition: transform .06s ease, box-shadow .12s ease, border-color .12s ease;
    }
    .contact-item:hover{
        transform: translateY(-1px);
        border-color:#a3c3b3;
        box-shadow:0 8px 18px -14px var(--ring);
    }
    .contact-item a{
        color:var(--brand-2);
        text-decoration:none;
        font-weight:600;
        word-break: break-word;
    }
    .small{ font-size:.92rem }

    /* Accesibilidad/print */
    @media print{
        body{ background:#fff }
        .banner{ box-shadow:none }
        .contact-item:hover{ transform:none; box-shadow:none }
    }

    .contact-item svg {
        flex-shrink: 0;              /* evita que el icono se deforme */
        margin-top: 2px;             /* lo centra mejor con el texto */
        width: 26px;
        height: 26px;
    }
    .contact-item:first-child svg { width: 30px; height: 30px; }   /* WhatsApp */
    .contact-item:nth-child(2) svg { width: 26px; height: 26px; }  /* Correo */
    .contact-item:last-child svg { width: 28px; height: 28px; }    /* Teléfono */

</style>


<body>
<div class="colorlib-loader"></div>
<div id="page">
    <!--Barra de navegacion -->
    @include("frontend.menu.navbar")
    <!--End Barra de navegacion-->

    <!--Imagen de cabecera-->
    <aside id="colorlib-hero">
        <div class="flexslider">
            <ul class="slides">
                <li style="background-image: url({{ asset('images/Slider/portadaslider.jpg')}});">
                    <div class="overlay"></div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-md-offset-3 slider-text">
                                <div class="slider-text-inner text-center">
                                    <h1><strong>AVISO DE PRIVACIDAD</strong></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </aside>
    <!--End Imagen de cabecera-->

    <h5>.</h5>
    <!--Contenido-->
    <div id="colorlib-services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">


                    <main class="wrap">
                        <section class="banner" aria-label="Aviso de Privacidad">

        <span class="badge">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M12 3l7 3v6c0 4-3 7-7 9-4-2-7-5-7-9V6l7-3z"
                      stroke="currentColor" stroke-width="1.6"/>
            </svg>
            Aviso de Privacidad
        </span>

                            <h1>Alcaldía Municipal de Santa Ana Norte</h1>
                            <p class="lead">
                                En cumplimiento de la Ley para la Protección de Datos Personales
                            </p>

                            <!-- Introducción -->
                            <div class="card" style="margin-top:20px">
                                <p>
                                    La alcaldía municipal de Santa Ana Norte en cumplimiento de lo establecido
                                    en la Ley para la Protección de Datos Personales, según el Artículo 24,
                                    pone a disposición de los ciudadanos el Aviso de Privacidad.
                                    Es responsabilidad de los Titulares de los datos personales, leer el presente aviso,
                                    para el ejercicio de los derechos ARCO-POL.
                                </p>
                            </div>

                            <!-- Contenido principal -->
                            <div class="card" style="margin-top:20px">

                                <h3>a) Domicilio del responsable:</h3>
                                <p class="muted">
                                    La alcaldía municipal de Santa Ana Norte, como responsable del tratamiento
                                    y recolección de datos personales, tiene su sede en:
                                    Avenida Benjamín Estrada Valiente y 1a. Calle Poniente,
                                    Barrio San Pedro, Metapán, Santa Ana Norte.
                                </p>

                                <h3>b) Datos personales que serán sometidos a tratamiento:</h3>
                                <p class="muted">
                                    La alcaldía municipal de Santa Ana Norte, recopila y procesa datos personales
                                    que serán sometidos a tratamiento tales como: nombre completo, domicilio,
                                    nacionalidad, estado familiar, canales de contacto (correo electrónico
                                    o número telefónico), documentos de identidad tales como: DUI, NIT,
                                    licencia de conducir, carnet de minoridad, pasaporte o carnet de residencia
                                    (aplica para extranjeros), firma y datos financieros.
                                </p>

                                <h3>c) Fundamento Legal para el tratamiento de datos:</h3>
                                <p class="muted">
                                    La alcaldía municipal de Santa Ana Norte es responsable del tratamiento adecuado
                                    de los datos personales que nos proporcionen los titulares de los mismos.
                                    Los datos personales serán tratados conforme a lo dispuesto en la Ley para
                                    la Protección de Datos Personales, y demás normatividad que resulte aplicable,
                                    tratando los datos anteriormente señalados, con fundamento en los artículos
                                    46, 47, 48, 49, de la Ley para la Protección de Datos Personales, asegurando
                                    en todo momento la confidencialidad de los mismos.
                                </p>

                                <h3>d) Las finalidades del tratamiento para las cuales se obtienen los datos personales:</h3>
                                <p class="muted">Sus datos personales, serán utilizados para:</p>
                                <ul class="list">
                                    <li>Proporcionar la información que nos solicite;</li>
                                    <li>Brindar los servicios solicitados, de conformidad con las facultades conferidas por ley a la municipalidad;</li>
                                    <li>Procedimientos administrativos iniciados de oficio o a solicitud de los interesados;</li>
                                    <li>Procesos de compras y/o contrataciones;</li>
                                    <li>Gestionar las denuncias, quejas, reclamos y sugerencias de los usuarios.</li>
                                </ul>

                                <p class="muted" style="margin-top:15px">
                                    La alcaldía municipal de Santa Ana Norte se compromete a recopilar únicamente
                                    los datos personales necesarios para los fines autorizados, sin transferirlos,
                                    difundirlos o comercializarlos con terceros, salvo a las autoridades competentes
                                    conforme a la ley. Asimismo, dichos datos serán tratados con estrictas medidas
                                    de seguridad y confidencialidad, en cumplimiento de la Ley de Protección de Datos Personales.
                                </p>

                                <h3>e) Mecanismos, medios y procedimientos disponibles para ejercer los derechos ARCO-POL</h3>
                                <p class="muted">
                                    Cualquier persona puede solicitar por medio de escrito formal o formulario,
                                    de manera presencial o correo electrónico los siguientes derechos:
                                    acceso, rectificación, cancelación, oposición, limitación y portabilidad.
                                    Solicitudes que serán gestionadas por la Delegada de Protección de Datos Personales,
                                    quien estará a cargo de darle seguimiento a su petición.
                                </p>

                                <h3>f) Delegado de protección de datos personales y medios para presentar solicitudes ARCO-POL</h3>
                                <p class="muted">
                                    La delegada de protección de datos personales es la
                                    <strong>Licda. Nathaly Cristina Castro Galdámez</strong>,
                                    quien se encargará de gestionar y tramitar las solicitudes para el ejercicio
                                    de los derechos ARCO-POL.
                                </p>

                                <p class="muted">
                                    Las solicitudes pueden presentarse:
                                </p>
                                <ul class="list">
                                    <li>
                                        En la Unidad de Acceso a la Información Pública, ubicada en las instalaciones
                                        de la alcaldía municipal de Santa Ana Norte.
                                    </li>
                                    <li>
                                        A través de correo electrónico:
                                        <a href="mailto:uaipmetapan@gmail.com" style="color:#0e7490; font-weight:600">
                                            uaipmetapan@gmail.com
                                        </a>
                                    </li>
                                </ul>

                                <p class="muted">
                                    Horario de atención: lunes a viernes de 8:00 a.m. a 4:00 p.m.
                                </p>

                                <h3>g) Actualizaciones del aviso de privacidad</h3>
                                <p class="muted">
                                    En caso de que exista un cambio de este aviso de privacidad,
                                    lo haremos de su conocimiento por medios digitales publicados en la página
                                    <a href="https://www.santaananorte.gob.sv"
                                       target="_blank"
                                       rel="noopener"
                                       style="font-weight:600; color:#0e7490; text-decoration:none;">
                                        www.santaananorte.gob.sv
                                    </a>
                                </p>

                                <h3>h) Uso de cookies</h3>
                                <p class="muted">
                                    Las cookies son archivos de texto que se almacenan en el navegador del usuario
                                    y permiten optimizar la experiencia de navegación en el sitio web.
                                    Este sitio puede utilizarlas sin recopilar datos personales,
                                    salvo autorización expresa del usuario.
                                </p>

                                <p class="muted">
                                    La municipalidad, a través de sus servidores públicos,
                                    se abstendrá de compartir los datos personales de los usuarios
                                    sin el consentimiento correspondiente, salvo en los casos previstos por la ley.
                                </p>

                            </div>
                        </section>
                    </main>




                </div>


            </div>
        </div>


        <!--End Contenido-->
        @include("frontend.menu.footer")
        <script src="{{ asset('js/frontend.js') }}" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                $(".ancla").click(function(evento) {
                    evento.preventDefault();
                    var codigo = "#" + $(this).data("ancla");
                    $("html,body").animate({
                        scrollTop: $(codigo).offset().top
                    }, 300);
                });
            });
        </script>


    </div>
</div>
</body>


</html>
