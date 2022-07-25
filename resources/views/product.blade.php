@foreach(collect($product->amasty_label)->sortBy('priority') as $label)
    <div @class([
        'absolute top-[10px] right-[10px] flex flex-wrap gap-x-[10px]',
        'top-[10px] left-[10px]' => $label->prod_position === 'top-left',
        'top-[10px] right-[10px]' => $label->prod_position === 'top-right',
        'bottom-[10px] left-[10px]' => $label->prod_position === 'bottom-left',
        'bottom-[10px] right-[10px]' => $label->prod_position === 'bottom-right',
    ])>
        @continue($label->is_single && $loop->index)
        <div class="absolute z-10" style="{{ str_replace(["\n", "\r"], '', $label->prod_style) }}">{{ $label->prod_txt }}</div>
    </div>
@endforeach
