<template>
    <div v-for="(feedback, key) in feedbacks.data" :key="key">
        <div class="flex items-start gap-2.5">
            <img class="w-8 h-8 rounded-full" src="{{asset('favicon.ico')}}" alt="Jese image">
            <div
                class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ feedback.user.name }}</span>
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span>
                </div>
                <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">That's awesome. I think our users
                    will really appreciate the improvements.</p>
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Delivered</span>
            </div>
            <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots"
                data-dropdown-placement="bottom-start"
                class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                type="button">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                    <path
                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                </svg>
            </button>
            <div id="dropdownDots"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Forward</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Copy</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="text-center pt-2 pb-2">
            <TailwindPagination :data="feedbacks" @pagination-change-page="getFeedbacks"></TailwindPagination>
        </div>
    </div>
</template>

<script type="application/javascript">
import { TailwindPagination } from 'laravel-vue-pagination';

export default {
    name: "feedbacks",
    components: {
        TailwindPagination
    },
    data() {
        return {
            feedbacks: {
                type: Object,
                default: null
            }
        }
    },
    mounted() {
        this.getFeedbacks(),
            activateCurrentNavRouter()
    },
    methods: {
        async getFeedbacks(page = 1) {
            await axios.get(`/api/feedbacks?page=${page}`).then(({ data }) => {
                this.feedbacks = data;
            }).catch(({ response }) => {
                $('#flash-message').html('');

                // Generating flash message
                if (response.response.data.errors !== undefined) {
                    var errors = response.response.data.errors;

                    $.each(errors, function (index, value) {
                        $.each(value, function (indes, message) {
                            flashMessage('error', message);
                        });
                    });
                } else {
                    var message = 'Something went wrong while fetching feedbacks';

                    flashMessage('error', message);
                }
            });
        },
        deleteEmployee(id) {
            if (confirm("Are you sure to delete this feedback ?")) {
                axios.delete(`/api/feedbacks/${id}`).then(response => {
                    $('#flash-message').html('');

                    // Generating flash message
                    flashMessage(response.data.status, response.data.message);

                    this.getFeedbacks();
                }).catch(response => {
                    $('#flash-message').html('');

                    // Generating flash message
                    if (response.response.data.errors !== undefined) {
                        var errors = response.response.data.errors;

                        $.each(errors, function (index, value) {
                            $.each(value, function (indes, message) {
                                flashMessage('error', message);
                            });
                        });
                    } else {
                        var message = 'Something went wrong while deleting feedback';

                        flashMessage('error', message);
                    }
                })
            }
        }
    }
}
</script>