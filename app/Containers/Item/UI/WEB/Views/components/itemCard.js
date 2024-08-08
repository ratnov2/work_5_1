export default (item) => ({
    item: item,

    get topName() {
        let arrayOfStrings = this.item.market_hash_name.split(' | ');
        return arrayOfStrings[0]
    },

    get bottomName() {
        let arrayOfStrings = this.item.market_hash_name.split(' | ');
        return arrayOfStrings[1]
    },
})
