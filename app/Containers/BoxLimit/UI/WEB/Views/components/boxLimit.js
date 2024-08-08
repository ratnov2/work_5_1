import openBoxLimit from "./api/openBoxLimit"
import boxMixin from "../../../../../Box/UI/WEB/Views/components/_box"

export default (box) => ({
    box: box,

    async open() {
        this._boxOpen(openBoxLimit, { box_id: this.box.id }).catch(() => {})
    },

    ...boxMixin,
});
