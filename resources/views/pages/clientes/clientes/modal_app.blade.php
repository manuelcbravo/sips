<x-modal.modal id="ModalApp" size="modal-xs" nombretitulo="tituloApp">
    <x-slot name="titulo"> ASIGNAR:  </x-slot>
    <x-slot name="body">
        <h4 class="warn text-black"></h4>
        <form class="js-validate needs-validation" novalidate="" data-name="asignarUsuarios" id="asignarUsuarios" method="POST" action="{{ url('cliente_asignarP') }}" data-js="success_asignar">
            <input type="hidden" id="{{ $inputs['clientes']->id }}" name="{{ $inputs['clientes']->id }}" value="">

            <div class="content_modal_app"></div>

            <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
</x-modal.modal>
