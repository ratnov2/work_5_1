import { hooksComponentRegister } from "../../../../../../../resources/js/components/hooks";

export default (jackpots_history = []) => ({
    jackpots_history: jackpots_history,
    ws_channel: null,

    init() {
        hooksComponentRegister(this)
        this.ws_channel = centrifuge.subscribe("public:jackpot_history")
        this.ws_channel.on("publish", (data) => {
            this.jackpots_history.unshift(data.data.jackpot)
        })
    },

    beforeDestroy() {
        this.ws_channel.unsubscribe()
    },
});
