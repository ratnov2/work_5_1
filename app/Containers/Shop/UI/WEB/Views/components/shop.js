import { hooksComponentRegister } from "../../../../../../../resources/js/components/hooks";
import accept from "./api/accept";

export default () => ({
    is_accepting: false,
    selected_shop_items: [],

    init() {
        hooksComponentRegister(this);
    },

    beforeDestroy() {
        this.$store.invent.is_disable_for_selecting = false;
    },

    async accept() {
        let market_hash_names_with_quantity = this.selectedShopItemsWithQuantity.map(item => ({
            market_hash_name: item.market_hash_name,
            quantity: item.quantity
        }))

        this.is_accepting = true;
        this.$store.invent.is_disable_for_selecting = true;
        const extra_uniqids = this.$store.invent.selected_player_items.map(player_item => player_item.uniqid);
        const data = await accept({
            market_hash_names_with_quantity,
            extra_uniqids: extra_uniqids
        }).catch(error => {
            toast("error", 'Ошибка покупки предметов')
        }).finally(() => {
            this.is_accepting = false;
            this.$store.invent.is_disable_for_selecting = false;
        });

        if(!data) return false;
        this.$store.player.updateBalance(data.player_balance)
        this.$store.invent.addPlayerItems(...data.player_items);
        this.$store.invent.removeSelectedPlayerItems();
        this.selected_shop_items = [];
    },

    addShopItem(item) {
        if (this.$store.player.player == null) {
            toast("error", "Требуется авторизация");
            return;
        }
        this.selected_shop_items.push(item);
    },

    removeShopItem(item) {
        const index = this.selected_shop_items.indexOf(this.selected_shop_items.find(selected_item => selected_item.market_hash_name == item.market_hash_name));
        if (index > -1) this.selected_shop_items.splice(index, 1);
    },

    removeShopItems() {
        this.selected_shop_items = []
    },

    get isShowAcceptButton() {
        return this.sumWillStay >= 0 && this.selected_shop_items.length > 0
    },

    get selectedShopItemsWithQuantity() {
        let arr = []
        this.selected_shop_items.forEach(selected_shop_item => {
            let item = arr.find(item => item.market_hash_name == selected_shop_item.market_hash_name)
            item ? item.quantity++ : arr.push(Object.assign({}, selected_shop_item, { quantity: 1 }))
        })
        return arr
    },

    get sumWillGive() {
        return roundLikePHP( this.$store.invent.selected_player_items.reduce((sum, player_item) => sum + player_item.price, 0) + this.$store.player.player.balance, 2)
    },

    get sumSelected() {
        return roundLikePHP(this.selected_shop_items.reduce((sum, selected_shop_item) => sum + selected_shop_item.price, 0), 2)
    },

    get sumWillStay() {
        return  roundLikePHP(this.sumWillGive - this.sumSelected, 2)
    }
});
