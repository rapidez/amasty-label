@foreach(collect($product->product_amasty_labels)->sortBy('priority')->groupBy('position') as $position => $labels)
    <div @class([
        'absolute z-10 flex flex-col w-full gap-1',
        'top-2.5 left-2.5' => $position === 'top-left',
        'top-2.5 right-2.5 items-end' => $position === 'top-right',
        'bottom-2.5 left-2.5' => $position === 'bottom-left',
        'bottom-2.5 right-2.5 items-end' => $position === 'bottom-right',
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
                ])>{{ $label->label_text }}</span>
            </div>
        @endforeach
    </div>
@endforeach
