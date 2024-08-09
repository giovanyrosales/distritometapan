<!--Parte superior de las paginas -  hasta head  -->
@include('frontend.menu.indexsuperior')

<body>


<style>

    .pagination {
        justify-content: center;
        list-style: none;
        padding: 0;
        display: block !important;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 8px 12px;
        color: #333;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        text-decoration: none;
    }

    .pagination li.active span {
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination li.disabled span {
        color: #6c757d;
        cursor: not-allowed;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

</style>


<div class="colorlib-loader"></div>
<div id="page">
    <!--Barra de navegacion -->
    @include("frontend.menu.navbar")
    <!--End Barra de navegacion -->





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
                                    <h1><strong>Noticias y Anuncios</strong></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </aside>
    <!--End Imagen de cabecera-->
    <!--Contenido-->
    <div id="colorlib-blog">
        <div class="container">
            @foreach($paginator as $item)
                <div class="row ">
                    <div class="col-md-10">
                        <div class="wrap-division">
                            <a href="{{ url('noticia/'.$item->slug) }}" >
                                <article class="animated zoomIn">
                                    <div class="blog-img" style="background-image: url( {{ asset('storage/archivos/'.$item->nombrefotografia) }});"></div>
                                    <div class="desc">
                                        <div class="meta">
                                            <h6>
                                                <span>{{ $item->fecha }}</span>
                                            </h6>
                                        </div>
                                        <h2>{{ $item->nombrenoticia }}</h2>
                                        <h5>{!! $item->descorta !!}</h5>
                                    </div>
                                </article></a>
                        </div>
                    </div>
                </div>
            @endforeach

                <div class="pagination" id="pagination">
                    {{ $paginator->links('frontend.paginas.paginacion.vistapaginacion') }}
                </div>


        </div>
    </div>


</div>
<!--End Contenido-->

@include("frontend.menu.footer")
<script src="{{ asset('plugins/scrollinfinite/jquery.jscroll.min.js') }}" type="text/javascript"></script>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var pagination = document.getElementById('pagination');
        pagination.style.display = 'block';
    });
</script>


<script type="text/javascript">
    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<img class="center-block" src="/images/loadinggif.gif" alt="Loading..." />',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });
</script>
</body>
</html>
