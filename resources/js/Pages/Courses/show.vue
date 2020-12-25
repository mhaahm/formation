<template>
    <app-layout>
        <template slot="header">
           {{ courseToShow.title }}
        </template>
        <div class="py-3 m-5">
            <div class="text-2xl">{{ episodeToshow.title }}</div>
            <!--iframe class="w-full h-screen" :src="episodeToshow.video_url" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe-->
            <div class="text-sm text-gray-400">{{ episodeToshow.description }}</div>
            <progress-barre :watched-episode="watcheds" :episodes="course.episodes"></progress-barre>
            <div class="mt-8">
                <ul v-for="(episode,index) in courseToShow.episodes" v-bind:key="episode.id">
                    <li class="mt-3 flex justify-between items-center">
                       Episode n {{ index + 1 }} - {{ episode.title }}
                        <div>
                            <button class="bg-green-400 text-white focus:text-indigo-500 focus:putline-none p-1 rounded hover:bg-blue-500"
                                    @click="switchEpisode(index)">Voir Episode</button>
                            <progress-button :episode_id="episode.id" :watched-episodes="watcheds"/>
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </app-layout>
</template>
<script>
    import AppLayout from "./../../Layouts/AppLayout";
    import progressButton from "./progressButton";
    import progressBarre from "./progressBarre";
    export default {
        components: {
            AppLayout,
            progressButton,
            progressBarre
        },
        props: ['course','watched'],
        data() {
            return {
                courseToShow: this.course,
                episodeToshow: this.course.episodes[0],
                watcheds: this.watched,

            }
        },
        methods: {
            switchEpisode(index) {
                this.episodeToshow = this.course.episodes[index];
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    }
</script>
