<!--Parte superior de las paginas - hasta head -->
@include('frontend.menu.indexsuperior')
<style>
    :root{
        --brand:#14532d;
        --brand-2:#0e7490;
        --ink:#0f172a;
        --muted:#475569;
        --bg:#f8fafc;
        --card:#ffffff;
        --ring: rgba(20,83,45,.15);
        --radius: 16px;
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
        margin:0;
        font: 16px/1.6 system-ui,-apple-system,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial;
        color:var(--ink);
        background:linear-gradient(180deg,var(--bg),#eef2f7 60%);
    }

    .wrap{
        max-width: 1200px;
        margin: clamp(16px,4vw,48px) auto;
        padding: clamp(12px,2.5vw,24px);
    }

    .banner {
        background: #243b54;
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
        color: #000;
        background: #fff;
        border: 1px solid #d1d5db;
        padding: .35rem .7rem;
        border-radius: 999px;
    }
    .badge svg {
        width: 18px;
        height: 18px;
        stroke: #000;
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
    .card{
        background:var(--card);
        border:1px solid #e5e7eb;
        border-radius: var(--radius);
        padding: clamp(14px,2.2vw,20px);
        box-shadow: 0 10px 24px -16px var(--ring);
    }
    .muted{ color:var(--muted); }

    /* Flipbook */
    #flipbook-wrapper{
        display:flex;
        flex-direction:column;
        align-items:center;
        margin-top: 20px;
    }
    #flipbook{
        margin: 0 auto;
        background: transparent;
        touch-action: pan-y;
    }
    #flipbook .page{
        background:#fff;
        overflow:hidden;
        box-shadow: 0 0 20px rgba(0,0,0,.2);
    }
    #flipbook .page img{
        width:100%;
        height:100%;
        display:block;
        object-fit: contain;
        background:#fff;
    }
    .flipbook-controls{
        display:flex;
        gap:10px;
        margin-top:18px;
        flex-wrap:wrap;
        justify-content:center;
        align-items:center;
    }
    .flipbook-controls button{
        background: var(--brand-2);
        color:#fff;
        border:none;
        padding:.55rem 1rem;
        border-radius:8px;
        cursor:pointer;
        font-weight:600;
        transition: background .15s ease, transform .06s ease;
    }
    .flipbook-controls button:hover{ background:#0b5e74; transform: translateY(-1px); }
    .flipbook-controls button:disabled{ background:#94a3b8; cursor:not-allowed; transform:none }
    .flipbook-controls .page-info{
        color:#fff;
        font-weight:600;
        padding: 0 8px;
    }

    #loading-msg{
        color:#fff;
        margin: 20px 0;
        font-weight:600;
        text-align:center;
    }
    .spinner{
        width:38px; height:38px;
        border:4px solid rgba(255,255,255,.25);
        border-top-color:#fff;
        border-radius:50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 12px;
    }
    @keyframes spin { to { transform: rotate(360deg) } }

    @media print{
        body{ background:#fff }
        .banner{ box-shadow:none }
    }
</style>
<body>
<div class="colorlib-loader"></div>
<div id="page">
    <!--Barra de navegacion -->
    @include("frontend.menu.navbar")
    <!--End Barra de navegacion-->
    <h5>.</h5>
    <!--Contenido-->
    <div id="colorlib-services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <main class="wrap">
                        <section class="banner" aria-label="Revista Digital">
                          <div style="display:flex; justify-content:flex-end;">
                            <span class="badge" aria-label="Revista Digital">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M4 4h7v16H4zM13 4h7v16h-7z" stroke="currentColor" stroke-width="1.6"/>
                                </svg>
                                Revista Digital - Fiestas Patronales
                            </span>
                          </div>
                            <h1>Fiestas Patronales 2026</h1>
                            <p class="lead">
                                Disfrute la lectura de nuestra revista de Fiestas Patronales 2026 en formato digital.
                            </p>

                            <div id="flipbook-wrapper">
                                <div id="loading-msg">
                                    <div class="spinner"></div>
                                    Cargando revista...
                                </div>

                                <div id="pdf-viewer" style="text-align:center;">
                                    <canvas id="pdf-canvas" style="
                                        max-width:100%;
                                        height:auto;
                                        background:#fff;
                                        border-radius:10px;
                                        box-shadow:0 0 20px rgba(0,0,0,.25);
                                    "></canvas>
                                </div>
                                <div class="flipbook-controls" style="display:none">
                                    <button id="btn-prev" type="button">< Anterior</button>
                                    <span class="page-info">
                                        Pág. <span id="page-current">1</span> de <span id="page-total">-</span>
                                    </span>
                                    <button id="btn-next" type="button">Siguiente ></button>
                                    <button id="btn-fullscreen" type="button">Pantalla completa</button>
                                </div>
                            </div>
                        </section>
                    </main>
                </div>
            </div>
        </div>
    </div>
    <!--End Contenido-->
    @include("frontend.menu.footer")
    <script src="{{ asset('js/frontend.js') }}" type="text/javascript"></script>

    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    
    <script>
(function(){

    const PDF_URL = "{{ asset('pdf/revista2.pdf') }}";

    pdfjsLib.GlobalWorkerOptions.workerSrc =
        "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";

    const canvas = document.getElementById('pdf-canvas');
    const ctx = canvas.getContext('2d');

    const loadingMsg = document.getElementById('loading-msg');
    const controls = document.querySelector('.flipbook-controls');

    const btnPrev = document.getElementById('btn-prev');
    const btnNext = document.getElementById('btn-next');
    const btnFull = document.getElementById('btn-fullscreen');

    const pageCur = document.getElementById('page-current');
    const pageTotal = document.getElementById('page-total');

    let pdfDoc = null;
    let currentPage = 1;

    async function renderPage(pageNum) {

        const page = await pdfDoc.getPage(pageNum);

        const containerWidth = Math.min(
            document.querySelector('.banner').clientWidth - 40,
            1000
        );

        const viewport = page.getViewport({ scale: 1 });

        const scale = containerWidth / viewport.width;

        const scaledViewport = page.getViewport({ scale });

        canvas.width = scaledViewport.width;
        canvas.height = scaledViewport.height;

        await page.render({
            canvasContext: ctx,
            viewport: scaledViewport
        }).promise;

        pageCur.textContent = pageNum;

        btnPrev.disabled = pageNum <= 1;
        btnNext.disabled = pageNum >= pdfDoc.numPages;
    }

    async function init() {

        try {

            pdfDoc = await pdfjsLib.getDocument(PDF_URL).promise;

            pageTotal.textContent = pdfDoc.numPages;

            await renderPage(1);

            loadingMsg.style.display = 'none';
            controls.style.display = 'flex';

        } catch(err) {

            console.error(err);

            loadingMsg.innerHTML =
                'Error al cargar la revista.';
        }
    }

    btnPrev.addEventListener('click', async () => {

        if(currentPage <= 1) return;

        currentPage--;

        await renderPage(currentPage);
    });

    btnNext.addEventListener('click', async () => {

        if(currentPage >= pdfDoc.numPages) return;

        currentPage++;

        await renderPage(currentPage);
    });

    document.addEventListener('keydown', async (e) => {

        if(e.key === 'ArrowLeft' && currentPage > 1){

            currentPage--;

            await renderPage(currentPage);
        }

        if(e.key === 'ArrowRight' && currentPage < pdfDoc.numPages){

            currentPage++;

            await renderPage(currentPage);
        }
    });

    btnFull.addEventListener('click', () => {

        const el = document.getElementById('pdf-viewer');

        if(!document.fullscreenElement){

            el.requestFullscreen();

        }else{

            document.exitFullscreen();
        }
    });

    window.addEventListener('resize', () => {

        renderPage(currentPage);
    });

    init();

})();
</script>
</div>
</body>
</html>
