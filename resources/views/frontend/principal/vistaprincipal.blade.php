<!--Parte superior de las paginas -  hasta head  -->
@include('frontend.menu.indexsuperior')

<body class="scrollbar-indigo bordered-indigo">
<div class="colorlib-loader"></div>
<div id="page">
    <!--Barra de navegacion -->
    @include("frontend.menu.navbar")
    <!--End Barra de navegacion-->
    <!--Imagenes de cabecera-->
    <aside id="colorlib-hero">
        <div class="flexslider">
            <ul class="slides">
                @foreach($slider as $dato)
                    <li style="background-image: url('storage/archivos/{{ $dato->fotografia }}');">
                        <a href="{{ $dato->link }}">
                            <div class="overlay"></div>
                        </a>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 col-md-offset-12 col-sm-12 col-xs-12 slider-text">
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>
    <!--End Imagenes de cabecera-->

    <!--Barra de slogan -->
    <div id="colorlib-reservation">
        <!-- <div class="container"> -->
        <div class="row">
            <div class="search-wrap">
                <div class="tab-content" style="padding:25px;"  >
                    <center>
                        <a style="margin-right:15px;" id = "soc"  href="#">
                            <span id="socno">Distrito de Metapán</span>
                        </a>&nbsp;
                        <a style="margin-right:15px;" id = "soc"  href="#">
                            <span id="socno">Distrito de Santa Rosa</span>
                        </a>&nbsp;
                        <a style="margin-right:15px;" id = "soc"   href="#">
                            <span id="socno">Distrito de Masahuat</span>
                        </a>&nbsp;
                        <a style="margin-right:15px;" id = "soc"   href="#">
                            <span id="socno">Distrito de Texistepeque</span>
                        </a>&nbsp;
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!--End Barra de slogan -->
</div>

<!--Programas Municipales-->
<div class="colorlib-services colorlib-light-grey">
    <div class="container">
        <div class="row  no-gutters">
            <div class="col-md-12 tex-center ">
                <br><br>
                <center>
                    <h2>Programas Municipales</h2>
                </center>
            </div>
        </div>
        <div class="row no-gutters">
            @foreach($programas as $dato2)
                @if ($loop->first)
                    <div class="col-md-3 animate-box text-center ">
                        @else
                            <div class="col-md-3 animate-box text-center ">
                                @endif
                                <div class="services">
                                    <a href="{{ url('programa/'.$dato2->slug) }}">
								<span class="icon">
									<img src="{{ asset('storage/archivos/'.$dato2->logo) }}" alt="Programa Municipal" style="width:120px; height:120px;" />
								</span>
                                        <h3>{{ $dato2->nombreprograma }}</h3>
                                    </a>
                                    {!! $dato2->descorta !!}
                                </div>
                            </div>
                            @endforeach
                    </div>
        </div>
    </div>
</div>
<!--End Programas Municipales-->

<!--Noticias recientes-->
<div id="colorlib-hotel">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center colorlib-heading animate-box">
                <h2>Noticias </h2>
                <p>Noticias publicadas recientemente. </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 animate-box">
                <div class="owl-carousel">
                    @foreach($noticia as $dato5)
                        <div class="item">
                            <div class="hotel-entry">
                                <a href="{{ url('noticia/'.$dato5->slug) }}" class="hotel-img" style="background-image: url('storage/archivos/{{ $dato5->nombrefotografia }}');"></a>

                                <div class="desc">
                                    <h3><a href="{{ url('noticia/'.$dato5->slug) }}">{{ $dato5->nombrenoticia }}</a></h3>
                                    <span class="place">{{ $dato5->fecha }}</span>
                                    <p>{!! $dato5->descorta !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Noticias recientes-->

<!--Servicios municipales-->
<div id="colorlib-blog" style="background: #fafafa;">
    <div class="container colorlib-light-grey">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center colorlib-heading animate-box">
                <h2>Servicios</h2>
                <p>Espacio para descripcion general de los servicios</p>
            </div>
        </div>
        <div class="blog-flex">
            <div class="row">
                @foreach($servicios as $dato3)
                    <div class="col-md-6 animate-box">

                        <a href="{{ url('servicio/'.$dato3->slug) }}" class="blog-post">
                            <span class="img" style="background-image: url('storage/archivos/{{ $dato3->logo }}');"></span>
                            <div class="desc">
                                <h3>{{ $dato3->nombreservicio }}</h3>
                                <span>{!! $dato3->descorta !!}</span>

                            </div>
                        </a>
                    </div>
                    @if ($loop->iteration == 2)
            </div>
            <div class="row">
                @elseif($loop->iteration == 4)
            </div>
            <div class="row">
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<!--End Servicios municipales-->

<!--Fotografías recientes-->
<div class="colorlib-tour">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center colorlib-heading animate-box">
                <h2>Galería</h2>
                <p>Fotografías recientes publicadas.</p>
            </div>
        </div>
    </div>
    <div class="tour-wrap">
        @foreach($fotografia as $dato4)
            <a class="tour-entry animate-box">
                <div class="tour-img" style="background-image: url('{{ asset('storage/archivos/'.$dato4->nombrefotografia ) }}');" data-toggle="modal" data-target="#modal1" onclick="getPath(this)"></div>
                <span class="desc">
					<h2>{{ $dato4->nombre }}</h2>
					<span class="city">{{ $dato4->fecha }}</span>
				</span>
            </a>
        @endforeach
    </div>
</div>
<!--End Fotografías recientes-->

<br><br>
<!--mapa-->
<div id="colorlib-reservation">
    <div class="container">
        <div class="row animate-box">
            <div class="col-md-12">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3865.6524445684045!2d-89.45010788517732!3d14.33160978997424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f6255b2d672ac0d%3A0x48fa2f8ae122a71d!2sAlcald%C3%ADa%20Municipal%20de%20Metap%C3%A1n!5e0!3m2!1ses!2ssv!4v1566837634061!5m2!1ses!2ssv" width="100%" height="400" frameborder="0" style="border:0;"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- End Mapa -->
<br><br>

<!--Cuadro modal fotos-->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <!--Contenido-->
        <div class="modal-content">
            <div class="modal-body mb-0 p-0">
                <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                    <img id="imgModal" src="{{ asset('images/Slider/a1.jpg') }}" class="embed-responsive-item" alt="">
                </div>
            </div>
            <!--Pie de pagina -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!--Fin Contenido-->
    </div>
</div>
<!--Fin cuadro modal-->

<!-- ===== Radio Flotante ===== -->
<style>
    .rf-wrap {
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        font-family: sans-serif;
    }
    .rf-panel {
        width: 300px;
        background: #0d0d0d;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.08);
        overflow: hidden;
        transform: scale(0.85) translateY(20px);
        opacity: 0;
        pointer-events: none;
        transition: transform 0.35s cubic-bezier(.34,1.56,.64,1), opacity 0.25s ease;
        transform-origin: bottom right;
    }
    .rf-panel.open {
        transform: scale(1) translateY(0);
        opacity: 1;
        pointer-events: all;
    }
    .rf-header {
        padding: 16px 18px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }
    .rf-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .rf-logo {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.15);
    }
    .rf-station { display: flex; flex-direction: column; }
    .rf-name {
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 0.5px;
    }
    .rf-live {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: #22c55e;
        font-weight: 500;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .rf-live-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #22c55e;
        animation: rflivepulse 1.2s ease-in-out infinite;
    }
    @keyframes rflivepulse {
        0%,100%{transform:scale(1);opacity:1}
        50%{transform:scale(1.5);opacity:0.6}
    }
    .rf-close {
        background: rgba(255,255,255,0.08);
        border: none;
        color: #888;
        cursor: pointer;
        width: 28px; height: 28px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        transition: background 0.2s, color 0.2s;
    }
    .rf-close:hover { background: rgba(255,255,255,0.15); color: #fff; }
    .rf-visualizer {
        height: 48px;
        padding: 0 18px;
        display: flex;
        align-items: flex-end;
        gap: 3px;
        margin: 14px 0 4px;
    }
    .rf-bar {
        flex: 1;
        border-radius: 3px 3px 0 0;
        background: linear-gradient(to top, #6C2BDD, #a855f7);
        animation: rfbarwave 1.2s ease-in-out infinite;
        min-height: 4px;
    }
    @keyframes rfbarwave {
        0%,100%{height:30%}
        50%{height:100%}
    }
    .rf-bar:nth-child(1){animation-delay:0s}
    .rf-bar:nth-child(2){animation-delay:0.1s}
    .rf-bar:nth-child(3){animation-delay:0.2s}
    .rf-bar:nth-child(4){animation-delay:0.3s}
    .rf-bar:nth-child(5){animation-delay:0.15s}
    .rf-bar:nth-child(6){animation-delay:0.05s}
    .rf-bar:nth-child(7){animation-delay:0.25s}
    .rf-bar:nth-child(8){animation-delay:0.35s}
    .rf-bar:nth-child(9){animation-delay:0.1s}
    .rf-bar:nth-child(10){animation-delay:0.2s}
    .rf-bar:nth-child(11){animation-delay:0s}
    .rf-bar:nth-child(12){animation-delay:0.3s}
    .rf-bar:nth-child(13){animation-delay:0.18s}
    .rf-bar:nth-child(14){animation-delay:0.08s}
    .rf-bar:nth-child(15){animation-delay:0.28s}
    .rf-bar:nth-child(16){animation-delay:0.12s}
    .rf-bar:nth-child(17){animation-delay:0.22s}
    .rf-bar:nth-child(18){animation-delay:0.04s}
    .rf-embed { padding: 0 18px 16px; }
    .rf-footer {
        font-size: 10px;
        color: rgba(255,255,255,0.2);
        text-align: center;
        padding-bottom: 12px;
        letter-spacing: 0.5px;
    }
    .rf-btn {
        width: 62px;
        height: 62px;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        padding: 0;
        overflow: hidden;
        position: relative;
        box-shadow: 0 0 0 0 rgba(108,43,221,0.5);
        animation: rffabpulse 2.5s ease-in-out infinite;
        transition: transform 0.2s;
    }
    .rf-btn:hover { transform: scale(1.08); }
    .rf-btn:active { transform: scale(0.96); }
    @keyframes rffabpulse {
        0%,100%{box-shadow:0 0 0 0 rgba(108,43,221,0.5)}
        50%{box-shadow:0 0 0 12px rgba(108,43,221,0)}
    }
    .rf-btn img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
    .rf-btn-ring {
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        border: 2px solid rgba(108,43,221,0.6);
        animation: rfringrot 4s linear infinite;
        background: transparent;
        pointer-events: none;
    }
    @keyframes rfringrot {
        from{transform:rotate(0deg)}
        to{transform:rotate(360deg)}
    }
</style>

<div class="rf-wrap">
    <div class="rf-panel" id="rfPanel">
        <div class="rf-header">
            <div class="rf-header-left">
                <img class="rf-logo" src="{{ asset('images/logonorte.jpg') }}" alt="Radio Norte">
                <div class="rf-station">
                    <span class="rf-name">Radio Norte</span>
                    <span class="rf-live"><span class="rf-live-dot"></span>En vivo</span>
                </div>
            </div>
            <button class="rf-close" onclick="rfToggle()">&#x2715;</button>
        </div>

        <div class="rf-visualizer">
            <div class="rf-bar"></div><div class="rf-bar"></div><div class="rf-bar"></div>
            <div class="rf-bar"></div><div class="rf-bar"></div><div class="rf-bar"></div>
            <div class="rf-bar"></div><div class="rf-bar"></div><div class="rf-bar"></div>
            <div class="rf-bar"></div><div class="rf-bar"></div><div class="rf-bar"></div>
            <div class="rf-bar"></div><div class="rf-bar"></div><div class="rf-bar"></div>
            <div class="rf-bar"></div><div class="rf-bar"></div><div class="rf-bar"></div>
        </div>

        <div class="rf-embed" id="rfEmbed">
            <div style="height:60px;display:flex;align-items:center;justify-content:center;">
                <span style="color:rgba(255,255,255,0.3);font-size:12px;letter-spacing:1px;">Cargando reproductor...</span>
            </div>
        </div>
        <div class="rf-footer">TRANSMISIÓN EN VIVO</div>
    </div>

    <button class="rf-btn" onclick="rfToggle()" title="Radio en vivo">
        <div class="rf-btn-ring"></div>
        <img src="{{ asset('images/logonorte.jpg') }}" alt="Radio">
    </button>
</div>

<script>
    var rfLoaded = false;
    function rfToggle() {
        var p = document.getElementById('rfPanel');
        var open = p.classList.contains('open');
        if (!open) {
            p.classList.add('open');
            if (!rfLoaded) {
                rfLoaded = true;
                var wrap = document.getElementById('rfEmbed');
                wrap.innerHTML = '<div class="cstrEmbed" data-type="newStreamPlayer" data-publicToken="b7b85839-7507-4864-9c68-d60bcfda4b22" data-theme="dark" data-color="6C2BDD" data-channelId="" data-rendered="false" style="width:100%;"><a href="https://www.caster.fm" style="display:none;">Shoutcast Hosting</a><a href="https://www.caster.fm" style="display:none;">Stream Hosting</a><a href="https://www.caster.fm" style="display:none;">Radio Server Hosting</a></div>';
                var s = document.createElement('script');
                s.src = '//cdn.cloud.caster.fm//widgets/embed.js';
                document.body.appendChild(s);
            }
        } else {
            p.classList.remove('open');
        }
    }
</script>

<div class="radio-fab">
    <div class="radio-panel" id="radioPanel">
        <div class="radio-panel-header">
            <span class="radio-panel-title">
                <span class="radio-dot"></span>
                Radio en vivo
            </span>
            <button class="radio-close" onclick="toggleRadio()" title="Cerrar">&#x2715;</button>
        </div>
        <div id="radioEmbedWrap">
            <p class="radio-loading">Cargando reproductor...</p>
        </div>
        <div class="radio-label">Transmisión en vivo</div>
    </div>

    <button class="radio-fab-btn" onclick="toggleRadio()" title="Escuchar radio en vivo">
        <img src="{{ asset('images/logonorte.jpg') }}" alt="Radio" style="width:56px; height:56px; border-radius:50%; object-fit:cover;" />
    </button>
</div>

<script>
    var radioLoaded = false;
    function toggleRadio() {
        var panel = document.getElementById('radioPanel');
        var isOpen = panel.classList.contains('open');
        if (!isOpen) {
            panel.classList.add('open');
            if (!radioLoaded) {
                radioLoaded = true;
                var wrap = document.getElementById('radioEmbedWrap');
                wrap.innerHTML = '<div class="cstrEmbed" data-type="newStreamPlayer" data-publicToken="b7b85839-7507-4864-9c68-d60bcfda4b22" data-theme="light" data-color="6C2BDD" data-channelId="" data-rendered="false" style="width:100%;"><a href="https://www.caster.fm" style="display:none;">Shoutcast Hosting</a> <a href="https://www.caster.fm" style="display:none;">Stream Hosting</a> <a href="https://www.caster.fm" style="display:none;">Radio Server Hosting</a></div>';                var s = document.createElement('script');
                s.src = '//cdn.cloud.caster.fm//widgets/embed.js';
                document.body.appendChild(s);
            }
        } else {
            panel.classList.remove('open');
        }
    }
</script>
<!-- ===== Fin Radio Flotante ===== -->

@include("frontend.menu.footer")
<script src="{{ asset('js/frontend.js') }}" type="text/javascript"></script>

<!--Metodo cuadro modal-->
<script type="text/javascript">
    function getPath(img) {
        atributo = img.style.backgroundImage;
        document.getElementById("imgModal").setAttribute("src", atributo.substr(5, atributo.length - 7))
    }
</script>
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

<script>
    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        });
    });
</script>

</body>
</html>
