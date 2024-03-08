<div class="content container-fluid">
    <div class="page-header pb-3">
        <div class="row align-items-center">
            <div class="col-sm">
                <h1 class="page-header-title">{{ $titulo }}</h1>
            </div>
            <div class="col-sm-auto">
                {{ $boton ?? '' }}
            </div>
        </div>
    </div>
    <div>
        {{ $indicadores ?? '' }}
        {{ $cuerpo }}
        {{ $modals ?? '' }}
    </div>
</div>