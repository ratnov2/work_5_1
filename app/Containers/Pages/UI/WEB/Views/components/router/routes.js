import auth from "../middlewares/auth";

export default [
    {
        name: 'main.bonuses',
        hash: '#',
        urlLoad: '/api/bonuses',
    },
    {
        name: 'main.steamPayment',
        hash: '#/steam-payment',
        urlLoad: '/api/steam-payment',
    },
    {
        name: 'main.site',
        hash: '#/site/:id',
        urlLoad: '/api/site',
    },
    {
        name: 'main.contests',
        hash: '#/contests',
        urlLoad: '/api/contests',
    },
    {
        name: 'main.boxes',
        hash: '#/boxes',
        urlLoad: '/api/boxes',
    },
    {
        name: 'main.gameModes',
        hash: '#/game-modes',
        urlLoad: '/api/game-modes',
        forward: 'gameModes.jackpot',
    },
        {
            name: 'gameModes.topContest',
            hash: '#/game-modes/top-contest',
            urlLoad: '/api/game-modes/top-contest',
            parent: 'main.gameModes',
        },
        {
            name: 'gameModes.jackpot',
            hash: '#/game-modes/jackpot',
            urlLoad: '/api/game-modes/jackpot',
            parent: 'main.gameModes',
        },
        {
            name: 'gameModes.upgrade',
            hash: '#/game-modes/upgrade',
            urlLoad: '/api/game-modes/upgrade',
            parent: 'main.gameModes',
        },
        {
            name: 'gameModes.boxes',
            hash: '#/game-modes/boxes',
            urlLoad: '/api/game-modes/boxes',
            parent: 'main.gameModes',
        },
        {
            name: 'gameModes.mines',
            hash: '#/game-modes/mines',
            urlLoad: '/api/game-modes/mines',
            parent: 'main.gameModes',
        },
        {
            name: 'gameModes.box',
            hash: '#/game-modes/boxes/:id',
            urlLoad: '/api/game-modes/box',
            parent: 'main.gameModes',
        },
    {
        name: 'main.notifications',
        hash: '#/notifications',
        urlLoad: '/api/notifications',
        middlewares: [auth],
    },
    {
        name: 'main.profile',
        hash: '#/profile',
        urlLoad: '/api/profile',
        middlewares: [auth],
    },
    {
        name: 'main.refSystem',
        hash: '#/ref-system',
        urlLoad: '/api/ref-system',
        middlewares: [auth],
    },
];
