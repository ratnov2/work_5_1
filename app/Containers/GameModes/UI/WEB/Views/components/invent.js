import { hooksComponentRegister } from "../../../../../../../resources/js/components/hooks";
import loadPlayerItemsReady from "./api/loadPlayerItemsReady";
import makeJackpotBet from "../../../../../Jackpot/UI/WEB/Views/components/api/makeBet";

export default () => ({
    is_player_items_loading: false,
    next_items_url: '/api/player/items/load/ready',
    has_more_items: true,

    invent_target_name: null,
    prev_invent_target_name: null,
    is_making_bet: false,

    ws_channel: null,

    async init() {
        hooksComponentRegister(this);

        this.loadPlayerItems();

        this.ws_channel = await centrifuge.subscribe("private:player#" + this.$store.player.player.id)
        this.ws_channel.on("publish", (data) => {
            if(data.data.add_player_items) data.data.add_player_items.forEach(player_item => this.player_items.unshift(player_item));
        });

        this.$watch('$store.router.loading_route', () => {
            this.is_making_bet = false;
            this.selectInventTarget(null);
        })

        this.$watch('$store.router.current_route', () => {
            this.selectInventTarget(this.$store.router.current_route.name);
        })
    },

    beforeDestroy() {
        this.is_player_items_loading = false;
        this.next_items_url = '/api/player/items/load/ready';
        this.$store.invent.removePlayerItems();
        this.has_more_items = true;
        this.ws_channel.unsubscribe();
    },

    get sum_player_items() {
        return Math.floor(this.player_items.reduce((sum, player_item) => sum + player_item.price, 0) * 100) / 100;
    },

    get is_show_make_bet() {
        return ['gameModes.jackpot'].includes(this.invent_target_name)
    },

    get player_items() {
        return this.$store.invent.player_items;
    },

    get selected_player_items() {
        return this.$store.invent.selected_player_items;
    },

    _validateSelectPlayerItem() {
        if(this.invent_target_name == null) {
            toast('info', 'Выберите игровой режим или перейдите в магазин скинов')
            return false;
        }
        if(this.is_making_bet) {
            toast('info', 'Дождитесь завершения ставки')
            return false;
        }
        if(this.$store.invent.is_disable_for_selecting) {
            toast('info', 'В данный момент, выбрать предмет нельзя')
            return false;
        }
        return true;
    },

    selectPlayerItem(player_item) {
        if(!this._validateSelectPlayerItem()) return;

        if(['shop', 'gameModes.jackpot', 'gameModes.mines'].includes(this.invent_target_name)) {
            this.$store.invent.selected_player_items.includes(player_item)
                ? this.$store.invent.selected_player_items = this.$store.invent.selected_player_items.filter(item => item != player_item)
                : this.$store.invent.selected_player_items.unshift(player_item)
            return
        }

        if(['gameModes.upgrade'].includes(this.invent_target_name)) {
            this.$store.invent.selected_player_items.includes(player_item)
                ? this.$store.invent.selected_player_items = []
                : this.$store.invent.selected_player_items = [player_item]
            return
        }
    },

    _validateSelectInventTarget() {
        if(this.is_making_bet) {
            toast('info', 'Дождитесь завершения ставки')
            return false;
        }
        if(this.is_disable_for_selecting) {
            toast('info', 'В данный момент, переключиться нельзя')
            return false;
        }
        return true;
    },

    selectInventTarget(invent_target_name) {
        if(!this._validateSelectInventTarget()) return false;
        this.prev_invent_target_name = this.invent_target_name
        this.invent_target_name = invent_target_name
        this.$store.invent.removeSelectedPlayerItems()
    },

    selectPrevInventTarget() {
        if(!this._validateSelectInventTarget()) return false;
        this.invent_target_name = this.prev_invent_target_name
        this.prev_invent_target_name = null
        this.$store.invent.removeSelectedPlayerItems()
    },

    async loadPlayerItems() {
        this.is_player_items_loading = true;
        loadPlayerItemsReady(this.next_items_url)
            .then(data => {
                if(!data) return;
                this.$store.invent.player_items = this.$store.invent.player_items.concat(data.items);
                this.next_items_url = data.next_items_url;
                this.has_more_items = data.has_more_items;
            }).finally(() => {
                this.is_player_items_loading = false;
            })
    },

    async makeBet() {
        if(!['gameModes.jackpot'].includes(this.invent_target_name)) return false;
        this.is_making_bet = true
        if(this.invent_target_name == 'gameModes.jackpot') await this._makeJackpotBet();
        this.is_making_bet = false
    },

    async _makeJackpotBet() {
        const uniqids = this.$store.invent.selected_player_items.map(player_item => player_item.uniqid)
        await makeJackpotBet({ uniqids }).then(data => {
            if(!data) return false;
            toast('success', data.msg)
            this.$store.invent.removePlayerItemsByUniqids(...uniqids);
            this.$store.invent.removeSelectedPlayerItems()
        }).catch((error) => {
            toast("error", 'Ошибка отправки запроса')
        })
    },
})
