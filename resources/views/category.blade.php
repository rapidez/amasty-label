<div class="absolute z-10" :style="label.cat_style" v-for="label in Object.values(item.amasty_label ? item.amasty_label : {}).sort((a, b) => a.priority - b.priority).filter((label, index) => !(label.is_single && index))">
    <div class="absolute top-[10px] right-[10px] flex flex-wrap gap-x-[10px]" :class="{
        'top-[10px] left-[10px]': label.cat_position === 'top-left',
        'top-[10px] right-[10px]': label.cat_position === 'top-right',
        'bottom-[10px] left-[10px]': label.cat_position === 'bottom-left',
        'bottom-[10px] right-[10px]': label.cat_position === 'bottom-right',
    }">
        @{{ label.cat_txt }}
    </div>
</div>
