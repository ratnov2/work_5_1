import openBoxMoney from "./api/openBoxMoney"
import boxMixin from "../../../../../Box/UI/WEB/Views/components/_box"

export default (box) => ({
    box: box,

    async open() {
        const data = await this._boxOpen(openBoxMoney, { box_id: this.box.id }).catch(() => {})
        if(!data) return;
        this.$store.player.updateBalance(data.data.player_balance)
    },

    ...boxMixin,
});
