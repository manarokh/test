<template>
    <div class="dropdown relative">
        <!-- trigger -->
        <div 
        aria-haspopup="true"
        :aria-expanded="isOpen"
        @click.prevent="isOpen = !isOpen"> 
            <slot name="trigger"></slot>
        </div>

        <!-- links -->
        <div 
        class="dropdown-menu absolute bg-card py-2 rounded shadow mt-2"
        :class="align === 'left' ? 'left-0' : 'right-0' " 
        :style="{width}"
        v-show="isOpen">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props :{
            width :{default:'auto'},
            align : { default: 'left'}
        },

    data() {
        return {
            isOpen : false,
        }
    },

    watch: {
        isOpen(isOpen){
            if(isOpen){
                document.addEventListener('click',this.closeMenu);
            }
        }
    },

    methods: {
        closeMenu(event){
            if(!event.target.closest('.dropdown')){
                this.isOpen = false;
                document.removeEventListener('click',this.closeMenu);
            }
        }
    },
}
</script>