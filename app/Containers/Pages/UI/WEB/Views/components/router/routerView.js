import { hooksListenerRegister } from "../../../../../../../../resources/js/components/hooks";
import makeRequest from "../../../../../../../../resources/js/api/makeRequest";
import routes from "./routes";

export default (routePrefixName) => ({
    hooks_listener: null,

    init() {
        this.hooks_listener = hooksListenerRegister(this.$el)
        this._initHandleRoute();
    },

    async _initHandleRoute() {
        // Инициализация роут вью. Нужна для обработки, когда пользователь сразу заходит на сайт с вложенными роутами.

        // Ищем в принципе существует ли роут по данному хэшу
        let route = this._matchRoute();

        if(route === undefined) {
            toast('info', 'Страница не найдена');
            window.location.hash = '';
            return false;
        }

        // Если мы нашли в текущей вложенности роут - обычная обработка
        if(route.name.startsWith(routePrefixName)) {
            await this.onHashChange();
            return;
        }

        // Если мы не в текущей вложенности
        if(!route.parent) return false;

        await this._loadRoute(routes.find(r => r.name == route.parent)).catch(() => {
            window.location.hash = '';
            return;
        });
    },

    async onHashChange() {
        let route = this._matchRoute();

        if(!await this._validateRoute(route)) {
            return;
        };

        await this._loadRoute(route).catch(() => {
            window.location.hash = '';
            toast('error', 'Данная страница временно недоступна...');
            return;
        });

        if(route.forward) {
            window.location.hash = routes.find(r => r.name == route.forward).hash;
        }
    },

    _matchRoute() {
        const hashSegments = window.location.hash.split('/');

        let matchRoute = undefined;

        if(window.location.hash === '') return routes.find(r => r.hash === '#');

        routes.forEach(route => {
            const routeHashSegments = route.hash.split('/');

            if(routeHashSegments.length != hashSegments.length) return;

            let cloneRoute = _.clone(route)
            cloneRoute.params = {};

            for (let i = 0; i < routeHashSegments.length; i++) {
                if(routeHashSegments[i].startsWith(':')) {
                    cloneRoute.params[routeHashSegments[i].replace(':', '')] = hashSegments[i]
                } else if(hashSegments[i] != routeHashSegments[i]) {
                    return;
                }
            }

            cloneRoute.hash = hashSegments.join('/');

            matchRoute = cloneRoute;
        })

        return matchRoute;
    },

    async _validateRoute(route) {
        return await new Promise(async resolve => {
            // Если другой роут загружается - возвращаем хэш
            if(this.$store.router.loading_route !== null) {
                window.location.hash = this.$store.router.loading_route.hash;
                resolve(false);
                return;
            }

            // Если роут нашелся
            if(route !== undefined) {
                // И он не в нашей вложенности - выходим
                if(!route.name.startsWith(routePrefixName)) {
                    resolve(false);
                    return;
                }

                // И он же загружается сейчас - выходим
                if(this.$store.router.loading_route == route) {
                    resolve(false);
                    return;
                }
            }

            // Если роут не найден
            if(route === undefined) {
                toast('info', 'Страница не найдена');
                window.location.hash = '';
                resolve(false);
                return;
            }

            // Провреяем миддлвары
            if(route.middlewares !== undefined) {
                for (let i = 0; i < route.middlewares.length; i++) {
                    const result = await route.middlewares[i].run();

                    if(!result) {
                        toast('info', route.middlewares[i].msg);
                        window.location.hash = '';
                        resolve(false);
                        return;
                    }
                }
            }

            resolve(true);
        })
    },

    async _loadRoute(route) {
        this._unmount();

        this.$store.router.loading_route = route;
        const html = await this._getHTML(route).finally(() => this.$store.router.loading_route = null);

        this.$store.router.prev_route = this.$store.router.current_route;
        this.$store.router.current_route = route;

        this._mount(html);
    },

    async _getHTML(route) {
        const data = await makeRequest('get', route.urlLoad, route.params);
        if(!data) return false;

        return data.page;
    },

    _unmount() {
        const el = this.$el.firstElementChild
        this.hooks_listener.runBeforeDestroyHooks()
        el.innerHTML = ''
        el.classList.add('hidden')
    },

    _mount(html) {
        const el = this.$el.firstElementChild
        el.innerHTML = html
        el.classList.remove('hidden')
    },

    get loading_route() {
        return this.$store.router.loading_route;
    },

    get current_route() {
        return this.$store.router.current_route;
    },
});
