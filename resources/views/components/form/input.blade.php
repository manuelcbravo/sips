
<div class="mb-3">
    <label class="form-label" for="{{ $id }}">{{ $titulo }}</label>
    <input type="{{ $tipo }}" class="form-control form-control-lg" name="{{ $id }}" id="{{ $id }}" placeholder="{{$holder}}" {{ ($required)? 'required': '' }} {{ $options ?? '' }} {{ ($tipo == 'password')? 'minlength="8"': ''}} >
    <span class="invalid-feedback">{{ ($error)? $error : 'Campo obligatorio.' }} </span>
</div>
