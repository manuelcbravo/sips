
<div class="mb-3" {{ $validationclass ?? '' }}>
    <label class="form-label" for="{{ $id }}">{{ $titulo }}</label>
    <input type="{{ $tipo }}" class="form-control form-control-lg {{ $class }}" name="{{ $id }}" id="{{ $id }}" placeholder="{{$holder}}" {{ ($required)? 'required': '' }} {{ $options ?? '' }} {{ ($tipo == 'password')? 'minlength="8"': ''}} {{ $properties }}>
    <span class="invalid-feedback">{{ ($error)? $error : 'Campo obligatorio.' }} </span>
</div>
