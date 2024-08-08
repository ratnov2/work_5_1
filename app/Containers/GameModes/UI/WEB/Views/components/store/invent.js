export default {
    player_items: [],
    selected_player_items: [],
    is_disable_for_selecting: false,

    addPlayerItems(...player_items) {
        player_items.forEach(player_item => this.player_items.unshift(player_item));
    },

    removePlayerItemsByUniqids(...uniqids) {
        this.player_items = this.player_items.filter(player_item => !uniqids.includes(player_item.uniqid))
    },

    removePlayerItems() {
        this.player_items = [];
    },

    removeSelectedPlayerItems() {
        this.selected_player_items = [];
    },

    get sum_selected_player_items() {
        return Math.floor(this.selected_player_items.reduce((sum, item) => sum + item.price, 0) * 100) / 100;
    },
};
