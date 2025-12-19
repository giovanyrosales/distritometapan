{{-- resources/views/frontend/rifa.blade.php --}}

@include('frontend.menu.indexsuperior')
<link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
<style>


    :root{
        --brand:#1e349c;
        --ink:#0f172a;
        --muted:#64748b;
        --bg:#f8fafc;
        --card:#ffffff;
        --radius:18px;
    }

    /* =====================
       BASE
    ===================== */
    body{
        min-height:100vh;
        background:url('{{ asset("images/imgrifa.png") }}') center / cover no-repeat fixed;
        font-family:system-ui,-apple-system,"Segoe UI",Roboto,Ubuntu,Arial,sans-serif;
    }

    /* =====================
       LAYOUT PRINCIPAL
    ===================== */
    .rifa-layout{
        max-width:1400px;
        margin:120px auto 60px;
        padding:0 20px;
        display:flex;
        justify-content:center;   /* 🔥 CENTRADO */
    }

    /* Contenedor izquierdo */
    .rifa-left{
        width:100%;
        display:flex;
        justify-content:center;   /* 🔥 CENTRADO */
    }

    /* =====================
       CARD FORMULARIO
    ===================== */
    .rifa-card{
        width:100%;
        max-width:520px;
        background:var(--card);
        border-radius:var(--radius);
        padding:32px;
        box-shadow:0 20px 45px -25px rgba(0,0,0,.2);
        border:1px solid #e5e7eb;
    }

    .rifa-title{
        font-weight:800;
        font-size:2.1rem;
        margin-bottom:8px;
        text-align:center;
    }

    .rifa-subtitle{
        text-align:center;
        color:var(--muted);
        font-size:1.15rem;
        margin-bottom:28px;
        line-height:1.5;
    }

    /* =====================
       FORMULARIO
    ===================== */
    label{
        font-size:1.05rem;
        font-weight:700;
        margin-bottom:6px;
    }

    .form-group{
        margin-bottom:16px;
    }

    .form-control{
        border-radius:12px;
        height:50px;
        font-size:1.05rem;
        background:#f9fafb;
        border:1px solid #d1d5db;
        transition:.15s;
    }

    .form-control:focus{
        border-color:var(--brand);
        box-shadow:0 0 0 1px rgba(30,52,156,.25);
        background:#ffffff;
    }

    textarea.form-control{
        min-height:120px;
        resize:none;
    }

    /* =====================
       BOTÓN
    ===================== */
    .btn-rifa{
        width:100%;
        margin-top:20px;
        padding:14px;
        border-radius:999px;
        background:var(--brand);
        color:#ffffff;
        font-weight:800;
        font-size:1.15rem;
        border:none;
        cursor:pointer;
        transition:.15s;
    }

    .btn-rifa:hover{
        background:#0339ec;
        transform:translateY(-1px);
    }

    /* =====================
       TEXTO INFERIOR
    ===================== */
    .nota{
        text-align:center;
        font-size:.95rem;
        color:var(--muted);
        margin-top:14px;
    }

    /* =====================
       TOASTR FIX
    ===================== */
    #toast-container > div{
        font-size:1.05rem !important;
        padding:18px 22px 18px 55px !important;
        width:360px !important;
        opacity:1 !important;
        box-shadow:0 15px 35px rgba(0,0,0,.25) !important;
        background-position:15px center !important;
    }

    #toast-container .toast-title{
        font-size:1.15rem !important;
        font-weight:700 !important;
        margin-bottom:6px !important;
    }

    #toast-container .toast-message{
        font-size:1.05rem !important;
        line-height:1.45 !important;
        padding-left:0 !important;
    }

    /* =====================
       SWEETALERT2
    ===================== */
    .swal2-popup{
        zoom:1.25 !important;
        font-size:1.1rem !important;
        padding:25px !important;
    }

    .swal2-title{
        font-size:1.8rem !important;
        font-weight:700 !important;
    }

    .swal2-html-container{
        font-size:1.2rem !important;
    }

    .swal2-confirm,
    .swal2-cancel{
        font-size:1.1rem !important;
        padding:10px 24px !important;
    }

    /* =====================
       RESPONSIVE
    ===================== */
    @media (max-width:576px){
        .rifa-layout{
            margin:90px auto 40px;
            padding:0 14px;
        }

        .rifa-card{
            padding:24px 20px;
            border-radius:16px;
        }

        #toast-container > div{
            width:90% !important;
        }
    }



</style>

<body>
@include('frontend.menu.navbar')

<div class="rifa-layout">
    <!-- IZQUIERDA: FORMULARIO -->
    <div class="rifa-left">
        <div class="rifa-card">
            <h2 class="rifa-title">🎟 Participa en la Rifa</h2>
            <p class="rifa-subtitle">
                Completa tus datos para participar.
                Todos los campos son obligatorios.
            </p>

            <form id="formRifa">
                @csrf

                <div class="form-group">
                    <label>Nombre completo <span style="color: red">*</span></label>
                    <input type="text" id="nombre" maxlength="50" autocomplete="off" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>DUI (Solo números)<span style="color: red">*</span></label>
                    <input
                        type="text"
                        id="dui"
                        maxlength="9"
                        autocomplete="off"
                        class="form-control"
                        required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        placeholder=""
                    >
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" id="telefono" autocomplete="off" maxlength="20" class="form-control">
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <textarea id="direccion" autocomplete="off" maxlength="200" class="form-control"></textarea>
                </div>

                <button type="button" class="btn-rifa" onclick="enviarRifa()">
                    🎉 Participar
                </button>

                <div class="nota">
                    Tus datos serán usados únicamente para la rifa.
                </div>
            </form>
        </div>
    </div>

</div>



@include('frontend.menu.footer')
<!-- Bootstrap 4 JS (incluye Popper) -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/alertaPersonalizada.js') }}"></script>


<script>


    function enviarRifa(){
        let nombre = document.getElementById('nombre').value.trim();
        let dui = document.getElementById('dui').value.trim();
        let telefono = document.getElementById('telefono').value.trim();
        let direccion = document.getElementById('direccion').value.trim();

        if(!nombre || !dui){
            toastr.error('Campos con asterisco son obligatorios');
            return;
        }

        let formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('dui', dui);
        formData.append('telefono', telefono);
        formData.append('direccion', direccion);

        axios.post('/rifa/registro', formData)
            .then(res => {
                if(res.data.success === 1){
                    Swal.fire({
                        title: 'Error',
                        text: "El DUI ya se encuentra registrado.",
                        icon: 'info',
                        showCancelButton: false,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                        }
                    })
                }
                else if(res.data.success === 2){
                    toastr.success('Registrado correctamente');
                    document.getElementById('formRifa').reset();
                }
                else{
                    toastr.error('No se pudo registrar');
                }
            })
            .catch(() => {
                toastr.error('Error al enviar datos');
            });
    }



</script>
</body>
</html>
