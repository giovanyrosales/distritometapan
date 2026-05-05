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
        min-height:80vh;
        display:flex;
        justify-content:center;
        align-items:center;
        padding:20px;
    }

    .cert-card{
        width:100%;
        max-width:520px;
        background:var(--card);
        border-radius:18px;
        box-shadow:0 30px 60px -20px rgba(0,0,0,.25);
        padding:30px;
        animation:fadeUp .4s ease;
        border:1px solid #e5e7eb;
        margin-top: 15px;
    }

    .status{
        text-align:center;
        margin-bottom:25px;
    }

    .status .icon{
        width:70px;
        height:70px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:32px;
        margin:0 auto 10px;
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
        margin-bottom:5px;
    }

    .status p{
        color:var(--muted);
        font-size:.95rem;
    }

    .info{
        margin-top:10px;
    }

    .row-cert{
        display:flex;
        justify-content:space-between;
        padding:12px 0;
        border-bottom:1px solid #f1f5f9;
    }

    .row-cert:last-child{
        border:none;
    }

    .row-cert span{
        color:var(--muted);
        font-size:.9rem;
    }

    .row-cert strong{
        color:var(--text);
        font-size:.95rem;
        text-align:right;
        max-width:60%;
    }

    .qr{
        text-align:center;
        margin-top:25px;
    }

    .qr img{
        width:140px;
    }

    .btn-download{
        margin-top:15px;
        display:inline-block;
        background:var(--primary);
        color:#fff;
        padding:10px 18px;
        border-radius:999px;
        font-size:.9rem;
        text-decoration:none;
        transition:.2s;
    }

    .btn-download:hover{
        background:#1d4ed8;
        transform:translateY(-1px);
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

                <div class="row-cert">
                    <span>Certificado</span>
                    <strong>{{ $certificado->certificado }}</strong>
                </div>

            </div>

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
