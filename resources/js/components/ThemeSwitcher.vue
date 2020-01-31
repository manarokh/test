<template>
    <div class="flex mr-6 items-center">
        <button
        v-for="(color, theme) in themes" 
        @click="SelectedTheme = theme"
        :style="{ backgroundColor : color}" 
        class="rounded-full w-4 h-4 bg-default border  mr-2 focus:outline-none"
        :class="{'border-accent' : SelectedTheme == theme}">
        </button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                themes : {
                    'theme-light' : '#fff',
                    'theme-dark' : '#222'
                },
                SelectedTheme : 'theme-light',
            }
        },
        watch: {
            SelectedTheme(){
                document.body.className =  document.body.className.replace(/theme-\w+/, this.SelectedTheme); 
                //replace all the classes started with theme- with the clicked class
                localStorage.setItem('theme',this.SelectedTheme);
            }
        },
        created(){
            this.SelectedTheme = localStorage.getItem('theme') || 'theme-light';
        }
    }
</script>
