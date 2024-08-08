import unmutePlayer from './api/unmutePlayer'
import mutePlayer from './api/mutePlayer'
import messageDelete from './api/messageDelete'

export default () => ({
    is_show_context_menu: false,
    is_proccessing: false,

    async unmutePlayer(player_id) {
        if(this.is_proccessing) return false

        this.is_proccessing = true
        await unmutePlayer({player_id: player_id}).then(data => {
            if(!data) return;
            toast('success', data.msg);
        }).finally(() => {
            this.is_proccessing = false
        })
    },

    async mutePlayer(player_id, seconds) {
        if(this.is_proccessing) return false

        this.is_proccessing = true
        await mutePlayer({ player_id, seconds })
        .then(data => {
            if(!data) return;
            toast('success', data.msg);
        }).finally(() => {
            this.is_proccessing = false
        })
    },

    async messageDelete(uid) {
        if(this.is_proccessing) return false

        this.is_proccessing = true
        await messageDelete({ uid: uid }).then(data => {
            if(!data) return;
            toast('success', data.msg);
        }).finally(() => {
            this.is_proccessing = false
        })
    }
});
