<!--Parte superior de las paginas -  hasta head  -->
@include('frontend.menu.indexsuperior')

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
                <li style="background-image: url({{ asset ('images/Slider/a5.jpg') }});">
                    <div class="overlay"></div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 slider-text">
                                <div class="slider-text-inner text-center">
                                    <h2></h2>
                                    <h1><strong>Gobierno Municipal</strong></h1>
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
    <div id="colorlib-about">
        <div class="container">
            <div class="row">
                <div class="about-flex animated zoomIn">
                    <div class="col-md-1 aside-stretch">
                        <div class="row">
                        </div>
                    </div>
                    <div class="col-three-forth text-center">
                        <h2>Nuestro Gobierno</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{{ asset('images/historia/IMG_3743-01.jpeg') }}" alt="Alcalde y Consejo" class="img-responsive" width="900" ></p>
                            </div>
                        </div>
                        <br>
                        <p style="text-align: center;"><strong style="font-size: 20px;">NOMINA DE CONCEJALES 2021-2024</strong></p>

                        <table class="table table-hover table-bordered">
                            <tbody>
                            <tr>
                                <td>
                                    <strong>Alcalde Municipal </strong>
                                </td>
                                <td><span>Israel Peraza Guerra</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Síndico</strong>
                                </td>
                                <td><span>David Rubén Deras</span></td>
                            </tr>
                            <tr>
                                <td><strong>1° Regidor Propietario</strong></td>
                                <td><span>Denis Edgardo Pacheco</span></td>
                            </tr>
                            <tr>
                                <td><strong>2° Regidor Propietaria</strong></td>
                                <td><span>Clelia Madelin Guevara</span></td>
                            </tr>
                            <tr>
                                <td><strong>3° Regidora Propietario</strong></td>
                                <td><span>Neftalí Rosales Peraza</span></td>
                            </tr>
                            <tr>
                                <td><strong>4° Regidor Propietario</strong></td>
                                <td><span>Adolfo Fajardo Landaverde</span></td>
                            </tr>
                            <tr>
                                <td><strong>5° Regidor Propietaria</strong></td>
                                <td><span>Mario Antonio Arriola</span></td>
                            </tr>
                            <tr>
                                <td><strong>6° Regidor Propietario</strong></td>
                                <td><span>Juan Ramón Ochoa</span></td>
                            </tr>
                            <tr>
                                <td><strong>7° Regidor Propietario</strong></td>
                                <td><span></span>Yanira Marlene Peraza</td>
                            </tr>
                            <tr>
                                <td><strong>8° Regidor Propietaria</strong></td>
                                <td><span>Ramón Alberto Calderón</span></td>
                            </tr>
                            <tr>
                                <td><strong>9° Regidor Propietario</strong></td>
                                <td><span>Daniel Antonio Salazar</span></td>
                            </tr>
                            <tr>
                                <td><strong>10° Regidor Propietario</strong></td>
                                <td><span>Kelvin Elias Ramos</span></td>
                            </tr>
                            <tr>
                                <td><strong>1° Regidor Suplente</strong></td>
                                <td><span>Blas Aldana Hernández</span></td>
                            </tr>
                            <tr>
                                <td><strong>2° Regidor Suplente</strong></td>
                                <td><span>Silvia Lorena Villafuerte</span></td>
                            </tr>
                            <tr>
                                <td><strong>3° Regidor Suplente</strong></td>
                                <td><span>Carlos Armando Sandoval</span></td>
                            </tr>
                            <tr>
                                <td><strong>4° Regidor Suplente</strong></td>
                                <td><span>Bonifacio Antonio Martínez</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End contenido-->

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

</body>

</html>
