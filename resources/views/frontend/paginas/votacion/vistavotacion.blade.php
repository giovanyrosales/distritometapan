<!--Parte superior de las paginas -  hasta head  -->
@include('frontend.menu.indexsuperior')
<body>
<div class="colorlib-loader"></div>
<div id="page">

    <!--Barra de navegacion -->
    @include("frontend.menu.navbar")
    <!--End Barra de navegacion-->
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <style>
        .vote-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            background: #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: transform .2s;
            text-align: center;
        }
        .vote-card:hover {
            transform: translateY(-4px);
        }
        .vote-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .vote-title {
            margin-top: 18px;
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        .vote-desc {
            text-align: center;
            margin-bottom: 15px;
        }
        .vote-btn {
            background: #2a58ff;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            display: inline-block;
            margin: auto;
        }
        .vote-btn:hover {
            background: #244cd1;
        }



        /* 🔥 Fuerza tamaño normal del SweetAlert2 */
        .swal2-popup {
            zoom: 1.25 !important;        /* Aumenta tamaño completo */
            font-size: 1.1rem !important; /* Ajuste legible */
            padding: 25px !important;
        }

        .swal2-title {
            font-size: 1.8rem !important;
            font-weight: 700 !important;
        }

        .swal2-html-container {
            font-size: 1.2rem !important;
            margin-top: 10px !important;
        }

        .swal2-confirm {
            font-size: 1.1rem !important;
            padding: 10px 24px !important;
        }

        .swal2-cancel {
            font-size: 1.1rem !important;
            padding: 10px 24px !important;
        }

        .vote-card {
            display: flex;
            flex-direction: column;
        }

        .vote-desc {
            flex-grow: 1;
        }

        /* GRID para los cards de votación */
        .grid-votacion{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;               /* separación entre cards */
        }

        /* Cards flex para que el botón quede abajo */
        .vote-card{
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .vote-desc{
            flex-grow: 1;            /* empuja el botón hacia abajo */
        }

    </style>

    <div class="container py-4" style="margin-top: 20px">

        @if ($yaVoto)
            <div class="text-center" style="margin-top: 50px; font-weight: bold">

                <img src="{{ asset('images/voto.png') }}"
                     alt="Voto registrado"
                     style="
                width: 140px;
                height: 140px;
                object-fit: cover;
                border-radius: 50%;
                margin-bottom: 20px;
             ">
                    Su voto ya ha sido registrado.
                </div>

            </div>
        @else

            <div style="width: 100%; margin-top: 50px; background: transparent;">
                <h1 class="titulo-votacion" style="
                    text-align: center !important;
                    margin: 0 auto !important;
                    padding: 0 !important;
                    font-size: 32px !important;
                    font-weight: 900 !important;
                    color: #000000 !important;
                    display: block !important;
                    visibility: visible !important;
                    opacity: 1 !important;
                    line-height: 1.4 !important;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                ">

                </h1>
            </div>
            <!-- SUBTÍTULO -->
            <p class="text-center mb-4" style="font-size: 25px; color: #1c1c1c;">
                Votación para Seleccionar el Local que Operará en la Plaza
            </p>

            <!-- CARDS -->
        <div class="grid-votacion">

                @foreach ($opciones as $item)
                    <div class="vote-card">
                        <img
                            src="{{ $item->imagen ? url('storage/archivos/'.$item->imagen) : asset('images/starbu.jpg') }}"
                            class="vote-img"
                            alt="Imagen">

                        <h4 class="vote-title">{{ $item->nombre }}</h4>

                        <p class="vote-desc">
                            {{ $item->descripcion }}
                        </p>

                        <button class="vote-btn" onclick="votar({{ $item->id }})">
                            Votar
                        </button>
                    </div>
                @endforeach


            </div>

        @endif

    </div>

    @include("frontend.menu.footer")
    <script src="{{ asset('js/frontend.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>



    <script>
        // Configurar Axios con CSRF
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

        function votar(id) {
            Swal.fire({
                title: 'Confirmar votación',
                text: '¿Desea votar por este local?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, votar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    axios.post('{{ url('/votacion/registrar') }}', {
                        id_votacion: id
                    })
                        .then(function (response) {
                            if (response.data.success === 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Gracias!',
                                    text: response.data.msg,
                                }).then(() => {
                                    // Recargar para que ahora muestre "Su voto ya ha sido registrado"
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Aviso',
                                    text: response.data.msg,
                                });
                            }
                        })
                        .catch(function (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un problema al registrar su voto. Intente de nuevo.',
                            });
                        });

                }
            });
        }
    </script>


</div>
</body>
</html>
