{{-- resources/views/frontend/verificar.blade.php --}}

@include('frontend.menu.indexsuperior')

<style>
    :root{
        --primary:#1e3a8a;
        --success:#16a34a;
        --danger:#dc2626;
        --text:#0f172a;
        --muted:#64748b;
        --bg:#f1f5f9;
        --card:#ffffff;
    }

    body{
        background: linear-gradient(135deg,#eef2ff,#f8fafc);
        font-family: system-ui,-apple-system,"Segoe UI",Roboto;
    }

    .cert-container{
        min-height:85vh;
        display:flex;
        justify-content:center;
        align-items:center;
        padding:30px;
    }

    .cert-card{
        width:100%;
        max-width:700px; /* 🔥 MÁS GRANDE */
        background:var(--card);
        border-radius:20px;
        box-shadow:0 30px 70px -15px rgba(0,0,0,.25);
        padding:40px; /* 🔥 MÁS ESPACIO */
        animation:fadeUp .4s ease;
        border:1px solid #e5e7eb;
    }

    .status{
        text-align:center;
        margin-bottom:30px;
    }

    .status .icon{
        width:80px;
        height:80px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:38px;
        margin:0 auto 12px;
    }

    .success .icon{
        background:#dcfce7;
        color:var(--success);
    }

    .error .icon{
        background:#fee2e2;
        color:var(--danger);
    }

    .status h2{
        font-weight:800;
        font-size:24px;
        margin-bottom:6px;
    }

    .status p{
        color:var(--muted);
        font-size:1rem;
    }

    .info{
        margin-top:20px;
    }

    .row-cert{
        display:flex;
        justify-content:space-between;
        padding:14px 0;
        border-bottom:1px solid #f1f5f9;
    }

    .row-cert:last-child{
        border:none;
    }

    .row-cert span{
        color:var(--muted);
        font-size:.95rem;
    }

    .row-cert strong{
        color:var(--text);
        font-size:1rem;
        text-align:right;
        max-width:65%;
    }

    .qr{
        text-align:center;
        margin-top:30px;
    }

    .qr img{
        width:160px;
    }

    .btn-download{
        margin-top:20px;
        display:inline-block;
        background:var(--primary);
        color:#fff;
        padding:12px 22px;
        border-radius:999px;
        font-size:1rem;
        text-decoration:none;
        transition:.2s;
    }

    .btn-download:hover{
        background:#1d4ed8;
        transform:translateY(-2px);
    }

    @keyframes fadeUp{
        from{opacity:0; transform:translateY(20px);}
        to{opacity:1; transform:translateY(0);}
    }
</style>

<body>
@include('frontend.menu.navbar')

<div class="cert-container">

    @if($certificado)
        <div class="cert-card">

            <div class="status success">
                <div class="icon">✔</div>
                <h2>Certificado válido</h2>
                <p>Verificado correctamente en el sistema</p>
            </div>

            <div class="info">

                <div class="row-cert">
                    <span>Nombre</span>
                    <strong>{{ $certificado->nombre }}</strong>
                </div>

                <div class="row-cert">
                    <span>Curso</span>
                    <strong>{{ $certificado->curso }}</strong>
                </div>

                {{-- 🔥 NUEVO CAMPO --}}
                <div class="row-cert">
                    <span>Periodo</span>
                    <strong>{{ $certificado->periodo ?? '—' }}</strong>
                </div>

                <div class="row-cert">
                    <span>Certificado</span>
                    <strong>{{ $certificado->certificado }}</strong>
                </div>

            </div>

            {{-- QR OPCIONAL --}}
            @if($certificado->codigo_verificacion)
                <div class="qr">
                    <img src="{{ url('/qr/'.$certificado->codigo_verificacion) }}">
                </div>
            @endif

        </div>
    @else
        <div class="cert-card">

            <div class="status error">
                <div class="icon">✖</div>
                <h2>Certificado no válido</h2>
                <p>El código no existe o ha sido modificado</p>
            </div>

        </div>
    @endif

</div>

@include('frontend.menu.footer')
</body>
</html>
