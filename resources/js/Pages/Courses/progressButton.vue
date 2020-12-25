<template>
    <button class="bg-blue-400 text-white focus:text-indigo-500 focus:putline-none p-1 rounded hover:bg-green-500"
    @click="toogleProgress()">
        {{ isWatched ? 'Terminé' : 'Terminé ?'}}
    </button>
</template>
<script>

    export default {
        props: ['episode_id','watchedEpisodes'],
        data() {
            return {
                isWatched: null
            }
        },
        methods: {
            toogleProgress() {
               axios.post('/toogleProgress',{
                   episodeId: this.episode_id
               }).then(response => {
                   if(response.status == 200) {
                       this.isWatched = !this.isWatched
                       eventBus.$emit('toggleprogress', response.data);
                   }
               }).catch(error => {
                   console.log(error)
               })
            },
            isWatchedEpisode() {
                let episodid = this.episode_id;
                return this.watchedEpisodes.find(function(episode) {
                   return episode.id == episodid;
                }) ? true:false;
            }
        },
        mounted() {

            this.isWatched = this.isWatchedEpisode()
            console.log(this.isWatched)
        }

    }
</script>
