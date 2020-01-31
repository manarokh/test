<template>
<div>
    <form method="POST" @submit="submit" :v-model="bills"
        class="lg:w-3/4 lg:mx-auto card py-12 px-16 rounded shadow">
        <!-- @csrf -->
        <input type="hidden" name="_token" :value="csrf">
        <div class="flex justify-between">
            <h1 class="text-3xl text-center mb-1 ml-10">Create New Bill</h1>

            <div>
                <div class="lg:flex items-center">
                    <label class="label text-sm mb-1 mr-2" for="bill_num">Bill Number :</label>

                    <input type="text" 
                    class="form-input w-full mb-2 mr-2 flex-1" 
                    name="bill_num" 
                    placeholder="1234"
                    required>
                </div>        
            </div>
        </div>

        <div class="lg:flex items-center justify-between">
            <div class="lg:flex items-center">
                <label class="label text-sm mb-1 mr-2" for="from">From :</label>

                <input type="text" 
                class="form-input w-full mb-2 mr-2 flex-1" 
                name="from" 
                placeholder="Akkad"
                required>
            </div>

            <div class="lg:flex items-center">
                <label class="label text-sm mb-1 mr-1" for="to">Destination :</label>

                <input type="text" 
                class="form-input w-full mb-2 mr-2 flex-1" 
                name="to" 
                placeholder="Destination"
                required>
            </div>

            <div class="lg:flex items-center">
                <label class="label text-sm mb-1 mr-2" for="city">City :</label>

                <input type="text" 
                class="form-input w-full mb-2 mr-2 flex-1" 
                name="city" 
                placeholder="Hama"
                required>
            </div>

        </div>


        <div class="lg:flex items-center mb-4 justify-between">
            <div class="lg:flex items-center">
                <label class="label text-sm mb-1 mr-2" for="driver">Driver :</label>

                <input type="text" 
                class="form-input w-full mb-2 mr-2 flex-1" 
                name="driver" 
                placeholder="Ahmad"
                required>
            </div>

            <div class="lg:flex items-center">
                <label class="label text-sm mb-1 mr-2" for="telephone">Telephone :</label>

                <input type="text" 
                class="form-input w-full mb-2 mr-2 flex-1" 
                name="telephone" 
                placeholder="0912345678"
                >
            </div>

            <div class="lg:flex items-center">
                <label class="label text-sm mb-1 mr-2" for="title">Date :</label>

                <input type="date" 
                class="form-input w-full mb-2 mr-2 flex-1" 
                name="date" 
                placeholder="Date"
                required>
            </div>
        </div>

        <div class="text-default w-full flex mb-1">
            <span class="w-1/4 font-bold text-lg">Engine</span>
            <span class="w-1/4 font-bold text-lg">Vin </span>
            <span class="w-1/4 font-bold text-lg">Model</span>
            <span class="w-1/4 font-bold text-lg">Notes</span>
        </div>

        <div class="text-default w-full flex mb-2 items-center" v-for="bill in bills">
            <input type="text" v-model="bill.engine" name="engine[]" placeholder="190104552" class="form-input w-1/5 mr-10">
            <input type="text" v-model="bill.vin" name="vin[]" placeholder="200010100" class="form-input w-1/5 mr-10">
            <input type="text" v-model="bill.model" name="model[]" placeholder="CG150" class="form-input w-1/5 mr-10">
            <input type="text" v-model="bill.notes" name="notes[]" placeholder="Color" class="form-input w-1/5">
            <button 
            type="button"
            @click="addInfo"
            class="inline-flex items-center text-xs ml-4 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                    <g fill="none" fill-rule="evenodd" opacity=".307">
                        <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                        <path fill="#000" d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                    </g>
                </svg>
            </button>
        </div>
        
        <a :href="path" class="button-white float-right ml-4">Cancel</a>
        <button type="submit" class="button-primary float-right">Add Task</button>

    </form>
    </div>
</template>

<script>
export default {
    props : ['path','taskpath'],
    data() {
        return {
            bills : [
                {vin : '',engine : '',model : '',notes : ''}
            ],
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },    
    methods: {
        addInfo(){
            this.bills.push({
                    vin : '',
                    engine : '',
                    model : '',
                    notes : '',
                });
        },
        submit(){
            axios.post(this.taskpath , this.bills);
        }
    },
}
</script>