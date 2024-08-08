export default (condition) => ({
    condition,
    any: {},

    init() {
        this.any = _.groupBy(this.condition.action.any, 'name')
    },

    handle(item) {
        emmiter.emit(`conditionAnyCheck${this.condition.id}`, item);
    },
});
