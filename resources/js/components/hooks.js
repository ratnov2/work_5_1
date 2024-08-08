export function hooksComponentRegister(ctx) {
    ctx.$dispatch("hooks:register", {
        beforeDestroy: ctx.beforeDestroy?.bind(ctx),
    });
}

function addHooks(e) {
    e.stopPropagation();
    if (e.detail.beforeDestroy)
        this.beforeDestroyHooks.push(e.detail.beforeDestroy);
}

export function hooksListenerRegister(el) {
    const listener = {
        beforeDestroyHooks: [],

        unregister() {
            el.removeEventListener("hooks:register", addHooks.bind(this));
        },

        runBeforeDestroyHooks() {
            this.beforeDestroyHooks.forEach((fn) => fn());
            this.beforeDestroyHooks = [];
        }
    };
    el.addEventListener("hooks:register", addHooks.bind(listener));
    return listener
}
