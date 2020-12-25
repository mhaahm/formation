<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">

            <form @submit.prevent="submit">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div v-if="$page.flash.success" class="bg-green-200 text-green-500 p-3 mb-5" >
                        {{ $page.flash.success }}
                    </div>
                    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
                        <div class="mb-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="title">
                                Titre de la formation
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="title" type="text" v-model="form.title">
                            <div class="bg-red-100 text-red-800 p-4 mt-2" v-if="$page.errors.title">
                                {{ $page.errors.title[0] }}
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="description">
                                Description de la formation
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="description" type="text" v-model="form.description"></textarea>
                            <div class="bg-red-100 text-red-800 p-4 mt-2" v-if="$page.errors.description">
                                {{ $page.errors.description[0] }}
                            </div>
                        </div>
                        <div class="md-4">
                            <div class="justify-between flex">
                                <h2 class="text-2xl">Episodes de la formation</h2>
                                <button class="bg-green-300 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" @click.prevent="addEpisode()" v-if="form.episodes.length < 15">
                                    Add Episode
                                </button>
                            </div>

                            <div v-for="(episode,index) in form.episodes" v-bind:key="index">
                                <label class="block text-grey-darker text-sm font-bold mb-2 mt-3" :for="'title'+index">
                                    Titre de l'episode n {{ index + 1}}
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" :id="'title'+index" type="text" v-model="form.episodes[index].title">
                                <div class="bg-red-100 text-red-800 p-4 mt-2"
                                     v-if="$page.errors['episodes.'+index+'.title']">
                                    {{ $page.errors['episodes.'+index+'.title'][0] }}
                                </div>
                                <label class="block text-grey-darker text-sm font-bold mb-2 mt-3" :for="'video_url'+index">
                                    Url de la video {{ index + 1}}
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" :id="'video_url'+index" type="text" v-model="form.episodes[index].video_url">
                                <div class="bg-red-100 text-red-800 p-4 mt-2"
                                     v-if="$page.errors['episodes.'+index+'.video_url']">
                                    {{ $page.errors['episodes.'+index+'.video_url'][0] }}
                                </div>
                                <label class="block text-grey-darker text-sm font-bold mb-2 mt-3" :for="'description'+index">
                                    Description de l'episode n {{ index + 1}}
                                </label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" :id="'description'+index" type="text" v-model="form.episodes[index].description"></textarea>
                                <div class="bg-red-100 text-red-800 p-4 mt-2"
                                     v-if="$page.errors['episodes.'+index+'.description']">
                                    {{ $page.errors['episodes.'+index+'.description'][0] }}
                                </div>

                                <div class="mt-3 mb-3 flex justify-end" v-if="form.episodes.length>1">
                                    <button class="bg-red-300 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" @click.prevent="deleteEpisode(index)">Delete Episode</button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-400 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="submit">
                                Save Formation
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout
        },
        data() {
            return {
                form:{
                    title: null,
                    description: null,
                    episodes: [
                        {title: null,description: null, video_url:null}
                    ]

                }
            }
        },
        methods: {
            submit() {
                this.$inertia.post("/formations",this.form);
            },
            addEpisode() {
                if(this.form.episodes.length > 15) {
                    return;
                }
                this.form.episodes.push({title: null,description: null, video_url:null});
            },
            deleteEpisode(index) {
                console.log(index)
                delete this.form.episodes.splice(index)
            }
        }
    }
</script>
