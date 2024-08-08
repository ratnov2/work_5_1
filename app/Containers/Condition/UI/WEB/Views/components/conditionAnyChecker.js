export default (condition) => ({
    any: [],
    checkedAny: [],

    init() {
        if(!condition || !condition.action || !condition.action.any) return this.remove();
        if(localStorage.getItem('condition-any-remember', condition.id)) return this.remove();

        this.any = Object.values(condition.action.any);

        this.$el.addEventListener("click", event => {
            event.stopPropagation();
            this.showUncheckedConditionItems();
        }, true);

        emmiter.on(`conditionAnyCheck${condition.id}`, (item) => {
            if(!this.checkedAny.includes(item)) {
                this.checkedAny.push(item)
                if(this.any.length == this.checkedAny.length) {
                    this.remember()
                    this.remove()
                }
            }
        })
    },

    showUncheckedConditionItems() {
        const arr = this.any.filter(item => !this.checkedAny.includes(item))
        toast('error', `Вы не выполнили условие: ${arr[0].desc}`)
    },

    remember() {
        localStorage.setItem('condition-any-remember', condition.id);
    },

    remove() {
        Alpine.morph(this.$el, this.$el.innerHTML)
    }
});
