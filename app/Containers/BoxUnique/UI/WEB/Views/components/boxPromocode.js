import openBoxPromocode from "./api/openBoxPromocode"
import boxMixin from "../../../../../Box/UI/WEB/Views/components/_box"

export default (box) => ({
    box: box,
    promocodeValue: '',

    async open() {
        if(!this.validateOpen()) return false
        this._boxOpen(openBoxPromocode, {promocode_value: this.promocodeValue}).catch(() => {})
    },

    validateOpen() {
        if(this.promocodeValue == '') {
            toast('error', 'Введите промокод')
            return false
        }
        return true;
    },

    ...boxMixin,
})
