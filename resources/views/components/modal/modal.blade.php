<div id="{{ $id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{ $size ?? '' }}" role="document">
        <div class="modal-content">
            <div class="modal-header text-center pb-2">
                <h5 class="modal-title text-uppercase" id="{{ $nombretitulo ?? 'titulo' }}">{{ $titulo }}</h5>
            </div>
            <div class="modal-body">
               {{ $body }}
            </div>
                {{ $footer ?? '' }}
        </div>
    </div>
</div>
