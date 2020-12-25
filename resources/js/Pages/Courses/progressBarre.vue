<template>
    <div class="shadow w-full bg-grey-light mt-2">
        <div class="bg-green-500 text-xs leading-none py-1 text-center text-white transition-width duration-300" :style="'width:'+percent+'%;'">
            {{ percent }}%
        </div>
    </div>
</template>
<script>
    export default {
        props: ['watchedEpisode','episodes'],
        data() {
            return {
                watchedEpisodes: this.watchedEpisode
            }
        },
        computed: {
            percent() {
                let filtred = this.episodes.filter(watchep => {
                    return this.watchedEpisodes.find(ep => {
                        return ep.id == watchep.id
                    })
                });
                let pct = filtred.length*100 / this.episodes.length;
                return Math.floor(pct);
            }
        },
        mounted() {
            eventBus.$on('toggleprogress', watchedes => this.watchedEpisodes = watchedes)
        }
    }
</script>
