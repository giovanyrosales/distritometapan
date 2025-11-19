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
                                    <h1><strong>POLÍTICA ANTISOBORNO</strong></h1>
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
                        <section class="banner" aria-label="Presentación institucional">
                      <span class="badge" aria-label="Política Antisoborno">
                        <!-- Escudo/escudo simple -->
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                          <path d="M12 3l7 3v6c0 4-3 7-7 9-4-2-7-5-7-9V6l7-3z" stroke="currentColor" stroke-width="1.6"/>
                          <path d="M8 12l2 2 6-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Sistema de Gestión Antisoborno
                      </span>

                            <h1>Alcaldía Municipal de Santa Ana Norte</h1>
                            <p class="lead">
                                Órgano de gobierno local con autonomía administrativa y económica, orientado al desarrollo socioeconómico de su población.
                            </p>

                            <div class="grid">
                                <article class="card">
                                    <ul class="list-checked">
                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M20 7l-9 9-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <div>
                                                <strong>Servicios públicos de calidad.</strong>
                                                <div style="font-size: 13px">Compromiso con la atención incluyente y la mejora continua.</div>
                                            </div>
                                        </li>
                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M20 7l-9 9-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <div>
                                                <strong>Cero tolerancia al soborno.</strong>
                                                <div style="font-size: 13px">Cumplimiento de leyes, normas y requisitos internacionales.</div>
                                            </div>
                                        </li>
                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M20 7l-9 9-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <div>
                                                <strong>Participación ciudadana.</strong>
                                                <div style="font-size: 13px">Mecanismos de denuncia y supervisión del sistema antisoborno.</div>
                                            </div>
                                        </li>
                                    </ul>

                                    <hr style="border:none;border-top:1px solid #e5e7eb;margin:14px 0">
                                    <p class="card">

                                        En la Alcaldía de Santa Ana Norte mantenemos una política de cero tolerancia al soborno,
                                        por lo que <strong>no aceptamos regalos</strong> de ningun tipo.

                                    </p>
                                </article>

                                <aside class="card" aria-label="Canales de denuncia">
                                    <strong>Canales de denuncia.</strong>
                                    <div class="contacts" style="margin-top: 5px">
                                        <div class="contact-item">
                                            <!-- WhatsApp -->
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M20.5 11.5a8.5 8.5 0 1 1-3.16-6.63L21 3l-1.66 4.03A8.47 8.47 0 0 1 20.5 11.5z" stroke="currentColor" stroke-width="1.4"/>
                                                <path d="M15.5 14.5c-2 1-5-1-6-3-.5-1 .5-1.5 1-2" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                                            </svg>
                                            <div>
                                                WhatsApp<br>
                                                <a href="https://wa.me/50369886392" target="_blank" rel="noopener">+503 6988-6392</a>
                                            </div>
                                        </div>

                                        <div class="contact-item">
                                            <!-- Correo -->
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M4 6h16v12H4z" stroke="currentColor" stroke-width="1.4" />
                                                <path d="M4 7l8 6 8-6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" />
                                            </svg>
                                            <div>
                                                Correo electrónico<br>
                                                <a href="mailto:denuncias@santaananorte.gob.sv">denuncias@santaananorte.gob.sv</a>
                                            </div>
                                        </div>


                                    </div>
                                </aside>
                            </div>


                            <!-- Sección de Documentos Anti Soborno -->
                            <section class="wrap" style="margin-top: 0px">
                                <div class="card" style="padding: 25px">
                                    <h2 style="margin-top: 0; color:#475569; font-weight: 700;">
                                        Documentos
                                    </h2>
                                    <p class="muted" style="margin-bottom: 15px">
                                        Descargue los documentos oficiales relacionados con la Política Antisoborno.
                                    </p>

                                    <ul class="list-checked">
                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M20 7l-9 9-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <a href="{{ asset('pdf/politicasgav2.pdf') }}" target="_blank" style="font-weight:600; color:#0e7490;">
                                                Documento 1 – Política Antisoborno
                                            </a>
                                        </li>

                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M20 7l-9 9-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <a href="{{ asset('pdf/codigoeticav2.pdf') }}" target="_blank" style="font-weight:600; color:#0e7490;">
                                                Documento 2 – Código de ética para socios de negocios
                                            </a>
                                        </li>

                                        <li>
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M20 7l-9 9-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <a href="{{ asset('pdf/politicav2.pdf') }}" target="_blank" style="font-weight:600; color:#0e7490;">
                                                Documento 3 – Pólitica de regalos y hospitalidades
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </section>
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
