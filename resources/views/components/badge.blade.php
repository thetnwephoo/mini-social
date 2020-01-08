@if(!isset($show) || $show)
    <span class="badge badge-{{ $type ?? 'success' }}"> {{-- $ype ?? success ဆိုတာက သူ့ထဲမွာ ဘာမွ ပါမလာရင္ default အေနနဲ့သတ္မွတ္တာကိုေျပာတာ။ --}}
        {{ $slot }}
    </span>
@endif