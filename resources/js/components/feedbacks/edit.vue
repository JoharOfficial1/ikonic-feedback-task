<template>
    <form @submit.prevent="edit">
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" id="title" v-model="feedback.title" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="title" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Title</label>
        </div>
        
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" id="description" v-model="feedback.description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "/>
            <label for="description" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description</label>
        </div>

        <div class="relative z-0 w-full mb-6 group"><label for="category" class="sr-only">Underline select</label>
            <select id="category" v-model="feedback.category" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option value="bug report">Bug Report</option>
                <option value="feature request">Feature Request</option>
                <option value="improvement">Improvement</option>
            </select>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>
</template>

<script type="application/javascript">
    export default {
        name:"edit-feedback",
        data(){
            return {
                feedback:{
                    title:"",
                    description:"",
                    category:""
                }
            }
        },
        mounted(){
            this.getFeedback(),
            activateCurrentNavRouter()
        },
        methods:{
            async getFeedback(e){
                await axios.get(`/api/feedbacks/${this.$route.params.id}`).then(response => {
                    this.feedback.title = (response.data.title ? response.data.title : "");
                    this.feedback.description = (response.data.description ? response.data.description : "");
                    this.feedback.category = (response.data.category ? response.data.category : "");
                }).catch(response => {
                    $('#flash-message').html('');

                    // Generating flash message
                    if (response.response.data.errors !== undefined) {
                        var errors = response.response.data.errors;

                        $.each(errors, function(index, value) {
                            $.each(value, function(indes, message) {
                                flashMessage('error', message);
                            });
                        });
                    } else {
                        var message = 'Something went wrong while fetching feedback';

                        flashMessage('error', message);
                    }
                })
            },
            async edit(e){
                this.feedback._method = 'PUT';
                await axios.post(`/api/feedbacks/${this.$route.params.id}`, this.feedback).then(response => {
                    $('#flash-message').html('');

                    // Generating flash message
                    if (response.data.status == true) {
                        flashMessage(response.data.status, response.data.message);
                        
                        this.$router.push({name:"feedbacksView"});
                    } else {
                        flashMessage(response.data.status, response.data.message);
                    }
                }).catch(response => {
                    $('#flash-message').html('');

                    // Generating flash message
                    if (response.response.data.errors !== undefined) {
                        var errors = response.response.data.errors;

                        $.each(errors, function(index, value) {
                            $.each(value, function(indes, message) {
                                flashMessage('error', message);
                            });
                        });
                    } else {
                        var message = 'Something went wrong while updating feedback';

                        flashMessage('error', message);
                    }
                })
            }
        }
    }
</script>