<template>
    <div class="flex items-center">
       <div class="flex w-full items-center">
           
           <div class="w-full">

                <!-- Shipping details section -->
               <div 
               :class="[ task.completed ? 'font-bold' : '']"
               class="lg:flex items-center mb-2">

                    <span class="text-default mr-2 text-lg capitalize w-1/4" v-text="task.bill_num"></span>
                    <span class="text-default mr-2 text-lg capitalize w-1/4" v-text="task.to"></span>
                    <span class="text-default mr-2 text-lg capitalize w-1/4" v-text="task.driver"></span>
                    <span class="text-default mr-2 text-lg capitalize w-1/4" v-text="task.date"></span>
                    <div class="flex items-center">
                    
                    <div class="flex items-center">
                        <input 
                        type="checkbox"
                        name="completed"
                        class="form-checkbox h-5 w-5 mt-1 mr-2 float-right border border-gray-500" 
                        :disabled="task.completed"
                        :checked="task.completed"
                        onchange="this.form.submit()"
                        >

                        <i class="material-icons cursor-pointer h-4 mr-2" @click="isOpen = !isOpen" style="font-size:22px">remove_red_eye</i>

                        <a v-bind:href="path"  class="h-3">
                            <i class="material-icons h-3 -m-1 mr-1" >mode_edit</i>
                        </a>
                        
                        <form v-bind:action="path" method="POST"  class="h-3">
                            <input type="hidden" name="_token" :value="csrf">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="material-icons h-3 -m-1" >delete_outline</button>
                        </form>
                    </div>

                </div>
            </div>
                <!-- bill information section -->
                
                <div class="items-center " v-show="isOpen">
                    <div class="text-default w-full flex" v-show="isOpen">
                        <span class="w-1/4 font-bold text-lg">Vin </span>
                        <span class="w-1/4 font-bold text-lg">Engine</span>
                        <span class="w-1/4 font-bold text-lg">Model</span>
                        <span class="w-1/4 font-bold text-lg">Notes</span>
                    </div>
                    <hr class="mb-1">

                    <div class="w-full flex" v-for="bill in bills" :key="bill.id">
                        <span class="w-1/4" v-text="bill.vin"></span>
                        <span class="w-1/4" v-text="bill.engine"></span>
                        <span class="w-1/4" v-text="bill.model"></span>
                        <span class="w-1/4" v-text="bill.notes"></span>
                    </div>
                </div>
           </div>
                
        </div>
    </div>
</template>

<script>
export default {
    props : ['task','bills','path'],
    data() {
        return {
            isOpen : false,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
}
</script>