@foreach(collect($product->amasty_label)->sortBy('priority') as $label)
    @continue($label->is_single && $loop->index)
    <div class="absolute z-10" style="{{ str_replace(["\n", "\r"], '', $label->prod_style) }}">{{ $label->prod_txt }}</div>
@endforeach
