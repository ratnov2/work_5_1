import { generateRandom } from '../../../../../../../resources/js/helpers';

export default {
    boxMode: 'normal',
    is_opening_box: false,

    DROP_LINE_TRANSLATE_X_PX: 9363,
    DROP_LINE_TRANSITION_MS: 5000,

    dropLineTranslateX: 9363,
    dropLineIsShow: false,
    dropLineItems: [],

    winItem: null,

    _reset() {
        this.winItem = null;
        this.dropLineItems = [];
        this.dropLineTranslateX = this.DROP_LINE_TRANSLATE_X_PX
    },

    async _boxOpen(apiCallback, params = {}) {
        if(this.is_opening_box) return false;

        this._reset();

        this.is_opening_box = true
        const mode = this.boxMode
        const data = await apiCallback({...params, mode}).finally(() => this.is_opening_box = false);
        if(!data) return false;

        this._boxShowOpenResult(data.data, mode);
        return data;
    },

    _boxShowOpenResult(data, mode) {
        switch (mode) {
            case 'normal':
                this._boxShowOpenResultNormal(data);
                break;
            case 'fast':
                this._boxShowOpenResultFast(data);
                break;
            default:
                throw new Error('Error box open')
        }
    },

    _boxShowOpenResultNormal(data) {
        this.dropLineItems = data.drop_line_items;
        this.dropLineIsShow = true;
        this.$nextTick(() => {
            this.dropLineTranslateX = 0 + generateRandom(-80, 80)
            setTimeout(() => {
                this.winItem = data.win_item;
                this.$store.invent.addPlayerItems(data.player_item)
                this.dropLineIsShow = false;
            }, this.DROP_LINE_TRANSITION_MS + 1000)
        })
    },

    _boxShowOpenResultFast(data) {
        this.winItem = data.win_item
        this.$store.invent.addPlayerItems(data.player_item)
    },

    boxSwitchMode() {
        this.boxMode = this.boxMode == 'normal' ? 'fast' : 'normal';
    }
};
