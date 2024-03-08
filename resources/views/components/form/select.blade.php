<div class="mb-3">
    <label class="form-label" for="{{ $id }}">{{ $titulo }}</label>
    <div class="tom-select-custom custom-empty">
        <select class="js-select form-select {{ $class ?? ''}}" autocomplete="off"
                data-hs-tom-select-options='{
            "placeholder": "Seleccione..."
          }' id="{{$id}}" name="{{$id}}{{ ($multiple)? '[]': '' }}" {{ (($required)? 'required' : '' )}} {{ (($multiple)? 'multiple' : '')}}>
            <option value="">Seleccione...</option>
        </select>
        <span class="invalid-feedback">Campo obligatorio.</span>
    </div>
</div>
