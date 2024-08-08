export default () => ({
    search_items: [],
    price: 100,
    name: "",
    limit: 20,
    offset: 0,
    is_loading_items: false,
    rarities: {
        common: true,
        uncommon: true,
        milspec: true,
        restricted: true,
        classified: true,
        covert: true,
        rare: true,
    },

    init() {
        this.loadClearItems();
    },

    async loadItems() {
        this.is_loading_items = true;
        return axios.get("/api/items", {
            params: {
                name: this.name,
                limit: this.limit,
                offset: this.offset,
                price: this.price,
                rarities: this.raritiesParams
            }
        }).then((response) => {
            const data = response.data;
            if(data.status == "error") {
                toast("error", data.msg)
                return false;
            }
            return data.items
        }).catch(error => {
            toast("error", 'Ошибка отправки запроса')
        }).finally(() => {
            this.is_loading_items = false;
        });
    },

    async loadClearItems() {
        this.offset = 0;
        await this.loadItems().then(items => {
            this.search_items = items
        }).catch(error => {
            toast("error", 'Ошибка загрузки предметов')
        });
    },

    async loadMoreItems() {
        this.offset += this.limit;
        await this.loadItems().then(items => {
            this.search_items = this.search_items.concat(items)
        }).catch(error => {
            toast("error", 'Ошибка загрузки предметов')
        });
    },

    get is_show_not_found_items() {
        return this.search_items.length === 0 && !this.is_loading_items
    },

    get is_show_load_more_button() {
        return this.search_items.length > 0 && !this.is_loading_items
    },

    get raritiesParams() {
        let rarities = [];
        if (this.rarities.common) rarities.push("common");
        if (this.rarities.uncommon) rarities.push("uncommon");
        if (this.rarities.milspec) rarities.push("milspec");
        if (this.rarities.restricted) rarities.push("restricted");
        if (this.rarities.classified) rarities.push("classified");
        if (this.rarities.covert) rarities.push("covert");
        if (this.rarities.rare) rarities.push("rare");
        return rarities;
    }
})
