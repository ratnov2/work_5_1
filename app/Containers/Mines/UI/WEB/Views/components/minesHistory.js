export default () => ({
    history: [],
    ws_channel: null,
    _LIMIT: 7,

    init() {
        this.ws_channel = centrifuge.subscribe("public:mines-history");
        this.ws_channel.on("publish", (data) => {
            this.history.unshift(data.data.history_item);
            if(this.history.length > this._LIMIT) this.history.pop();
        })

        this.ws_channel.history({limit: this._LIMIT, since: null, reverse: true}).then((resp) => {
            resp.publications.forEach(p => this.history.push(p.data.history_item));
        });
    },
});
