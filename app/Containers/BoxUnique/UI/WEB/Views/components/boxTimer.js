import openBoxTimerable from "./api/openBoxTimerable"
import boxMixin from "../../../../../Box/UI/WEB/Views/components/_box"

export default (box) => ({
    box: box,
    timerDropExpiry: null,

    init() {
        if(this.box.time != null) this.timerDropExpiry = (new Date(this.box.time)).addDays(1)
    },

    async open() {
        const data = await this._boxOpen(openBoxTimerable)
        if(!data) return;
        this._updateTimer(data.data.time)
    },

    _updateTimer(time) {
        this.timerDropExpiry = (new Date(time)).addDays(1)
        this.$dispatch('start-box-timer', { timerDropExpiry: this.timerDropExpiry })
    },

    ...boxMixin,
})
