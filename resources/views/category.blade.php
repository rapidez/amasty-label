<template v-for="(labels, position) in Object.groupBy((item.category_amasty_labels || []).sort((a, b) => a.priority - b.priority).filter((label, index) => !(label.is_single && index)), (element) => element.position)">
    <div class="absolute z-10 flex flex-col w-full gap-1" :class="{
        'top-1 left-1': position === 'top-left',
        'top-1 right-1 items-end': position === 'top-right',
        'bottom-1 left-1': position === 'bottom-left',
        'bottom-1 right-1 items-end': position === 'bottom-right',
    }">
        <div
            v-for="label in labels"
            class="relative"
            :style="[{maxWidth: (label.image_size || 100) + '%', maxHeight: (label.image_size || 100) + '%'}, label.style.split(';').reduce((stylesObject, style) => {
                const [key, value] = style.split(':').map(s => s.trim());
                if (key && value) stylesObject[key] = value;
                return stylesObject;
            }, {})]"
        >
            <picture v-if="label.image">
                <img
                    loading="lazy"
                    v-bind:src="resizedPath(window.config.magento_url + (label.image.startsWith('/') ? label.image : '/media/amasty/amlabel/' + label.image) + '.webp', '200')"
                    v-bind:alt="window.amLabelReplaceVariables(label.alt_tag || label.label_text, item)"
                />
            </picture>
            <span v-bind:class="{'absolute top-1/2 left-1/2 text-center -translate-x-1/2 -translate-y-1/2': label.image}">
                @{{ window.amLabelReplaceVariables(label.label_text, item) }}
            </span>
        </div>
    </div>
</template>
