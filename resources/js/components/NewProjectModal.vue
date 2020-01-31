<template>
    <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
        <form @submit.prevent="submit">
            <div>
                <h1 class="capitalize font-normal mb-16 text-center text-default text-2xl">Create a New Project</h1>

                <div class="flex">
                    <!-- left side -->
                    <div class="flex-1 mr-4 ml-2">
                        <div class="mb-4">
                            <label for="title" class="font-normal text-default block mb-2">Title</label>
                            <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            class="py-1 px-2 bg-default w-full rounded " 
                            placeholder="Project Title"
                            :class="form.errors.title ? 'form-input-custom' : 'form-input' "
                            v-model="form.title">

                            <span class="text-sm italic text-error" v-if="form.errors.title" v-text="form.errors.title[0]"></span>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="font-normal text-default block mb-2">Description</label>
                            <textarea
                            name="description" 
                            id="description"
                            class="py-1 px-2 form-input bg-default w-full rounded"
                            rows="5" 
                            v-model="form.description"
                            :class="form.errors.description ? 'form-input-custom' : 'form-input' "
                            placeholder="Project description"></textarea>

                            <span class="text-sm italic text-error" v-if="form.errors.description" v-text="form.errors.description[0]"></span>
                        </div>
                    </div>

                    <!-- {{-- right side --}} -->
                    <!-- <div class="flex-1 ml-4">
                        <div class="mb-4">
                            <label for="task" class="font-normal text-default block mb-2">Tasks</label>
                            <input 
                            type="text" 
                            name="task" 
                            class="py-1 px-2 form-input bg-default w-full rounded mb-2" 
                            v-for="task in form.tasks"
                            v-model="task.body"
                            placeholder="Project task">
                        </div>

                        <button type="button" class="inline-flex items-center text-xs" @click="addTask">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                                <g fill="none" fill-rule="evenodd" opacity=".307">
                                    <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                                    <path fill="#000" d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                                </g>
                            </svg>

                            <span>Add New Task Field</span>
                        </button>
                    </div> -->


                </div>
                    <footer class="flex justify-end">
                        <button 
                        type="button" 
                        class="button-primary capitalize font-bold mr-2 is-outlined"
                        @click="$modal.hide('new-project')">
                        cancel</button>
                        <button type="submit" class="button-primary capitalize">Create Project</button>
                    </footer>
            </div>
        </form>
    </modal>
</template>

<script>
import KtcForm from './KtcForm';

    export default {
        data() {
            return {
                form : new KtcForm({
                    title : '' ,
                    description: '' ,
                    tasks : [
                        { body : '' },
                    ]
                }),
            }
        },
        methods: {
            addTask(){
                this.form.tasks.push({ body : '' });
            },
            async submit(){
                if(! this.form.tasks[0].body){
                    delete this.form.originalData.tasks;
                }

                this.form.submit('/projects')
                    .then(response => location = response.data.message)
                    .catch(error => console.log('form submit error'));
                // try {
                // let response = await axios.post('/projects', this.form );
                //     location = response.data.message;                    
                // } catch (error) {
                //     this.errors = error.response.data.errors;
                // }


                // .then(response =>{
                // }).catch(error =>{
                //     this.errors = error.response.data.errors;
                // });
            }
        },
    }
</script>