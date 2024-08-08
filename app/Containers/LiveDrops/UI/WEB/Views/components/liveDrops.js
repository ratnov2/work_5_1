export default () => ({
    live_drops: [],
    ws_channel: null,
    LIMIT_COUNT_DROPS: 30,

    async init() {
        this.ws_channel = centrifuge.subscribe("public:live-drops");

        this.loadHistory().then(resp => {
            this.$refs.skeleton_live_drops.remove();

            this.live_drops = resp.publications.map(publication => publication.data.live_drop);

            this.ws_channel.on("publish", (data) => {
                this.live_drops.push(data.data.live_drop);
                // if(this.live_drops.length > this.LIMIT_COUNT_DROPS) this.live_drops.shift();
            })
        }).catch(() => {
            this.loadHistory()
        })
    },

    async loadHistory() {
        return await this.ws_channel.history({
            limit: this.LIMIT_COUNT_DROPS, 
            since: { offset: 0} 
        }).then(resp => resp);
    }
});
