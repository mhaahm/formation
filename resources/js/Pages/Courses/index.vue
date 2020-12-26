<template>
    <app-layout>
        <template slot="header">
           <h1>Liste des courses</h1>
            <div v-if="$page.flash.success" class="bg-green-200 text-green-500 p-3 mb-5" >
                {{ $page.flash.success }}
            </div>
        </template>
            <div class="py-3" v-for="course in sortedArray" v-bind:key="course.id">
                <div class="mx-8 bg-white rounded shadow p-4">
                    <div class="text-sm text-gray-400">Formation mise en ligne par {{ course.user.name }} - <span class="text-gray-500 text-sm">
                      {{ course.participants }} Participant<span v-if="parseInt(course.participants) > 1 ">s</span>
                    </span>  </div>
                    <div class="flex justify-between items-center">
                        <div class="text-2xl">
                            {{ course.title }} <br>
                            <span class=" font-semibold text-green-500 ">{{ convert(course.total_duration) }}</span>
                        </div>
                        <div class="text-sm text-gray-300">{{ course.episodes_count }} Episodes</div>
                    </div>
                    <div class="text-sm text-gray-400">{{ course.description }}</div>
                    <div class="flex justify-between items-center">
                        <a :href="'/course/'+course.id" class="bg-indigo-500 text-white px-2 py-1 text-sm mt-3 inline-block rounded hover:bg-indigo-700">Voir La Formation</a>
                        <a :href="'/courses/edit/'+course.id" class="bg-green-500 text-white px-2 py-1 text-sm mt-3 inline-block rounded hover:bg-indigo-700" v-if="course.update">Modifier La Formation</a>
                    </div>
                   </div>
            </div>
        <inertia-link v-for="link in courses.links" v-bind:key="link.label" :href="link.url">
            <span v-html="link.label" class="p-1"></span>
        </inertia-link>
    </app-layout>
</template>
<script>
    import AppLayout from "./../../Layouts/AppLayout";
    export default {
        components: {
            AppLayout
        },
        props: ['courses'],
        mounted() {
            console.log(this.courses)
        },
        data() {
            return {
                courseList: this.courses.data
            }
        },
        computed: {
            sortedArray(){
                return _.orderBy(this.courseList,'id',['desc'])
            }
        },
        methods: {
            convert(timestamp) {
                let hour = timestamp/3600;
                let minute = timestamp/60 - hour/60;
                let second = timestamp%60;
                hour = Math.round(hour);
                minute = Math.round(minute);
                return hour.toString().padStart(2,0)+':'+minute.toString().padStart(2,0)+':'+second.toString().padStart(2,0)
            }
        }
    }
</script>
