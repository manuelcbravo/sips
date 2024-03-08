<x-modal.modal id="ModalBarCode" size="modal-sm" nombretitulo="">
    <x-slot name="titulo"> Código de barras </x-slot>
    <x-slot name="body">
        <div class="barcode">
            <img src="" alt="barcode" id="codigo"/>
        </div>
    </x-slot>
    @push('js_modulo')

    $("table").on("click","[data-bs-target='#ModalBarCode']",function(){
        let url = $(this).data('url');
        let id = $(this).data('id');
        $('#codigo').attr('src',"data:image/png;base64,{{DNS1D::getBarcodePNG('11', 'C39')}}");
    })




    @endpush
</x-modal.modal>