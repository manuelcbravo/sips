
<div class="card">
    <div class="card-header">
        <h2 class="card-title h4">{{ $header }}</h2>
    </div>

    <div class="card-body">
        {{ $body }}
    </div>

    @if(isset($footer))
    <div class="card-footer">
        {{ $footer ?? '' }}
    </div>
    @endif
</div>
