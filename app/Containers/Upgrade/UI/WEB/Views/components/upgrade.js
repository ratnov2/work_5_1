import { hooksComponentRegister } from "../../../../../../../resources/js/components/hooks";
import makeUpgrade from "./api/makeUpgrade";

export default () => ({
    ANIMATION_MS: 10000,
    MAX_CHANCE: 95,
    MIN_CHANCE: 5,
    animation_ms: 0,
    animation_rotation_deg: 0,
    wanted_item: null,
    chart_html: '',
    is_make_upgrade: false,
    is_upgrading: false,
    is_animating_result: true,
    is_showing_result: false,
    is_success: null,

    init() {
        hooksComponentRegister(this);

        this.$watch('chance', (chance) => {
            this.chart_html = chance != null && chance >= this.MIN_CHANCE && chance <= this.MAX_CHANCE ? this._createChartHTML() : '';
        });
    },

    beforeDestroy() {
        this.$store.invent.is_disable_for_selecting = false;
    },

    async makeUpgrade() {
        this.is_make_upgrade = true;
        this.is_upgrading = true;
        this.$store.invent.is_disable_for_selecting = true;
        const data = await makeUpgrade({
            wanted_market_hash_name: this.wanted_item.market_hash_name,
            sync_chance: this.chance,
            uniqid: this.selected_player_item.uniqid
        }).catch(error => {
            toast("error", 'Ошибка отправки запроса')
            this.$store.invent.is_disable_for_selecting = false;
            this.is_upgrading = false;
        }).finally(() => {
            this.is_make_upgrade = false;
        })

        if(!data) return;
        this.is_success = data.data.is_success;
        this.$store.invent.removePlayerItemsByUniqids(this.selected_player_item.uniqid);
        this.animation_ms = this.ANIMATION_MS;
        this.animation_rotation_deg = 3600 + Number(data.data.arrow_deg);
        setTimeout(() => {
            this.is_animating_result = false;
            this.is_showing_result = true;
            this.animation_rotation_deg = 0;
            this.animation_ms = 0;

            setTimeout(() => {
                this.is_animating_result = true;
                this.is_showing_result = false;
                this.is_upgrading = false;
                if(this.is_success) this.$store.invent.addPlayerItems(data.data.player_item);
                this.is_success = null;
                this.$store.invent.removeSelectedPlayerItems();
                this.$store.invent.is_disable_for_selecting = false;
            }, 2000)
        }, this.ANIMATION_MS + 1000)
    },

    _validateMoveItem() {
        if(this.is_upgrading) {
            toast('info', `Дождитесь окончания текущего апгрейда`)
            return false
        }
        return true
    },

    removeSelectedPlayerItem() {
        if(!this._validateMoveItem()) return
        this.$store.invent.selected_player_items = []
    },

    removeWantedItem() {
        if(!this._validateMoveItem()) return
        this.wanted_item = null
    },

    selectWantedItem(wanted_item) {
        if(!this._validateMoveItem()) return
        this.wanted_item = this.wanted_item == wanted_item ? null : wanted_item
    },

    get chance() {
        if(this.selected_player_item == null || this.wanted_item == null) return null
        return roundLikePHP(this.selected_player_item.price * 100 / this.wanted_item.price, 2)
    },

    get xKof() {
        if(this.selected_player_item == null || this.wanted_item == null) return null
        return roundLikePHP(this.wanted_item.price / this.selected_player_item.price, 2)
    },

    get maxWantedItemPrice() {
        if(this.selected_player_item == null) return null
        return roundLikePHP(this.selected_player_item.price / (this.MIN_CHANCE / 100), 2)
    },

    get isCorrectChance() {
        return this.chance >= this.MIN_CHANCE && this.chance <= this.MAX_CHANCE && !this.is_upgrading && this.selected_player_item != null && this.wanted_item != null
    },

    get selected_player_item() { return this.$store.invent.selected_player_items[0] },

    _createChartHTML() {
        let html = '<svg width="100%" height="100%" viewbox="0 0 33 33">'
        let stroke = '#86efac';
        let stroke_dasharray = this.chance + " " + parseFloat(100 - this.chance)
        let stroke_dashoffset = 25
        html += `<circle class="donut-segment" cx="50%" cy="50%" r="15.91549430918954" fill="transparent" stroke-width="1" stroke="${stroke}" stroke-dasharray="${stroke_dasharray}" stroke-dashoffset="${stroke_dashoffset}"></circle>`
        html += '</svg>';
        return html
    },
})
