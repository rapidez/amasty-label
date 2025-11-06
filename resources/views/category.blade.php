<template v-for="(labels, position) in Object.groupBy(Object.values(item.amasty_label ? item.amasty_label : {}).sort((a, b) => a.priority - b.priority).filter((label, index) => !(label.is_single && index)), (element) => element.cat_position)">
    <div class="absolute z-10 flex flex-col w-full gap-1" :class="{
        'top-1 left-1': position === 'top-left',
        'top-1 right-1 items-end': position === 'top-right',
        'bottom-1 left-1': position === 'bottom-left',
        'bottom-1 right-1 items-end': position === 'bottom-right',
    }">
        <div 
            v-for="label in labels" 
            class="relative"
            :style="[{maxWidth: (label.cat_image_size || 100) + '%', maxHeight: (label.cat_image_size || 100) + '%'}, label.cat_style.split(';').reduce((stylesObject, style) => {
                const [key, value] = style.split(':').map(s => s.trim());
                if (key && value) stylesObject[key] = value;
                return stylesObject;
            }, {})]"
        >
            <picture v-if="label.cat_image">
                <img 
                    loading="lazy" 
                    v-bind:src="resizedPath(window.config.magento_url + (label.cat_image.startsWith('/') ? label.cat_image : '/media/amasty/amlabel/' + label.cat_image) + '.webp', '200')"
                    v-bind:alt="label.cat_alt_tag || label.cat_txt"
                />
            </picture>
            <span v-bind:class="{'absolute top-1/2 left-1/2 text-center -translate-x-1/2 -translate-y-1/2': label.cat_image}">
                @{{ label.cat_txt }}
            </span>
        </div>
    </div>
</template>
