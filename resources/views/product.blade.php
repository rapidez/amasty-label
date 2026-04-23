@foreach(collect($product->product_amasty_labels)->sortBy('priority')->groupBy('position') as $position => $labels)
    @php
        [$y, $x] = explode('-', $position);
    @endphp
    <div @class([
        'absolute z-10 flex flex-col gap-1',
        'left-2.5' => $x === 'left',
        'right-2.5 items-end' => $x === 'right',
        'left-1/2 -translate-x-1/2' => $x === 'center',

        'top-2.5' => $y === 'top',
        'bottom-2.5' => $y === 'bottom',
        'top-1/2 -translate-y-1/2' => $y === 'middle',
    ])>
        @foreach($labels as $label)
            @continue($label->is_single && $loop->index)
            <div
                @style([
                    'max-width: ' . $label->image_size . '%',
                    'max-height: ' . $label->image_size . '%',
                    str_replace(["\n", "\r"], '', $label->style),
                ])
                class="relative"
            >
                @if($label->image)
                    <picture>
                        <img
                            src="{{ route('resized-image', [
                                'store' => config('rapidez.store'),
                                'size' => '200',
                                'placeholder' => 'magento',
                                'file' => Str::replaceFirst('/media', '', str_starts_with($label->image, '/') ? $label->image : '/media/amasty/amlabel/' . $label->image),
                                'webp' => '.webp'
                            ]) }}"
                            alt="{{ $label->alt_tag || $label->label_text }}"
                        />
                    </picture>
                @endif
                <span @class([
                    'absolute top-1/2 left-1/2 text-center -translate-x-1/2 -translate-y-1/2' => $label->image
                ]) v-txt="window.amLabelReplaceVariables('{{ $label->label_text }}')">{{ $label->label_text }}</span>
            </div>
        @endforeach
    </div>
@endforeach
