
<div class="mb-3">
    <label class="form-label" for="{{ $id }}">{{ $titulo }}</label>
    <input type="{{ $tipo }}" class="form-control form-control-lg @if($validationclass) js-input-mask @endif" name="{{ $id }}" id="{{ $id }}" placeholder="{{$holder}}" {{ ($required)? 'required': '' }} {{ $options ?? '' }} {{ ($tipo == 'password')? 'minlength="8"': ''}} @if($validationclass)  data-hs-mask-options='{
        "mask": "{{ $validationclass }}"
      }'@endif
      @if($pattern) pattern="{{ $pattern }}" @endif>
    <span class="invalid-feedback">{{ ($error)? $error : 'Campo obligatorio.' }} </span>
</div>
