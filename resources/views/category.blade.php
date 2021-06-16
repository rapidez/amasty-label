<div class="absolute z-10" :style="label.cat_style" v-for="label in Object.values(item.amasty_label).sort((a, b) => a.priority - b.priority).filter((label, index) => !(label.is_single && index))">
    @{{ label.cat_txt }}
</div>
