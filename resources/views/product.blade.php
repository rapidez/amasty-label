@foreach($product->amasty_label as $label)
    <div class="absolute z-10" style="{{ str_replace(["\n", "\r"], '', $label->prod_style) }}">{{ $label->prod_txt }}</div>
@endforeach
