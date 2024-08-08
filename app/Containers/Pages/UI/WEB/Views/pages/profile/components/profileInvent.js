import { hooksComponentRegister } from "../../../../../../../../../resources/js/components/hooks";
import itemWithdraw from './api/itemWithdraw'
import itemSell from './api/itemSell'
import loadPlayerItems from './api/loadPlayerItems'

export default () => ({
    is_player_items_loading: false,
    player_items: [],
    next_items_url: '/api/player/items/load',
    has_more_items: true,

    ITEM_READY: 'ready',
    ITEM_SELLED: 'selled',
    ITEM_TRADED: 'traded',
    ITEM_TRADE_PROCCESSING: 'trade_proccessed',
    ITEM_JACKPOT: 'jackpoted',
    ITEM_UPGRADE: 'upgraded',
    ITEM_MINES: 'minesed',

    is_selling: false,
    is_withdrawing: false,

    ws_channel: null,

    async init() {
        hooksComponentRegister(this);

        this.loadPlayerItems();

        this.ws_channel = await centrifuge.subscribe("private:player#" + this.$store.player.player.id)
        this.ws_channel.on("publish", (data) => {
            if(data.data.add_player_items) data.data.add_player_items.forEach(player_item => this.player_items.unshift(player_item));
        });
    },

    beforeDestroy() {
        this.is_player_items_loading = false;
        this.player_items = [];
        this.next_items_url = '/api/player/items/load';
        this.has_more_items = true;
        this.ws_channel.unsubscribe();
    },

    async itemSell(uniqid) {
        if(!this._validateAction()) return;

        this.is_selling = true
        await itemSell({ uniqid }).then(data => {
            if(!data) return;
            toast('success', data.msg)
            this.$store.player.updateBalance(data.player_balance);
            this._updateItemsStatusByUniqids(this.ITEM_SELLED, uniqid);
        }).finally(() => {
            this.is_selling = false
        })
    },

    async itemWithdraw(uniqid) {
        if(!this._validateAction()) return;

        this.is_withdrawing = true
        await itemWithdraw({ uniqid }).then(data => {
            if(!data) return;
            toast('success', data.msg)
            this._updateItemsStatusByUniqids(this.ITEM_TRADE_PROCCESSING, uniqid)
        }).finally(() => {
            this.is_withdrawing = false
        })
    },

    async loadPlayerItems() {
        if(!this.has_more_items) return;
        if(!this.next_items_url) return;

        this.is_player_items_loading = true;
        await loadPlayerItems(this.next_items_url).then(data => {
            this.player_items = this.player_items.concat(data.items);
            this.next_items_url = data.next_items_url;
            this.has_more_items = data.has_more_items;
        }).finally(() => {
            this.is_player_items_loading = false;
        })
    },

    _updateItemsStatusByUniqids(status, ...uniqids) {
        uniqids.forEach(uniqid => {
            this.player_items.find(item => item.uniqid == uniqid).status = status
        })
    },

    get readyItems() {
        return this.player_items.filter(item => item.status == this.ITEM_READY)
    },

    get sumReadyItems() {
        let sum = this.readyItems.reduce( (accumulator, currentValue) => accumulator + parseFloat(currentValue.price), 0)
        return roundLikePHP(sum, 2)
    },

    _validateAction() {
        return !this.is_selling && !this.is_withdrawing;
    },
});
