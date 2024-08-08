import getPlayer from "../api/getPlayer";

export default {
    player: null,

    async init() {
        await getPlayer().then(data => {
            if(data.player && data.centrifugo_token) {
                this.player = data.player
                centrifuge.setToken(data.centrifugo_token);
                centrifuge.subscribe("private:player#" + this.player.id).on("publish", (data) => {
                    if(data.data.balance) this.updateBalance(data.data.balance);
                    if(data.data.msg) toast('info', data.data.msg)
                });
            }
            centrifuge.connect();
        });
    },

    updateBalance(balance) {
        this.player.balance = roundLikePHP(balance, 2);
    },
};
