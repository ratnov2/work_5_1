export default () => ({
    count_players: 0,
    count_success_trades: 0,
    count_coins: 0,
    online: 0,
    ws_channels: null,

    init() {
        this.loadStatistics()

        let statistics_count_players = centrifuge.subscribe("public:statistics_count_players");
        statistics_count_players.on("publish", (data) => {
            this.count_players = data.data.count_players
        });

        let count_success_trades = centrifuge.subscribe("public:statistics_count_success_trades");
        count_success_trades.on("publish", (data) => {
            this.count_success_trades = data.data.count_success_trades
        });

        let count_coins = centrifuge.subscribe("public:statistics_count_coins");
        count_coins.on("publish", (data) => {
            this.count_coins = data.data.count_coins
        });

        centrifuge.subscribe("public:online");

        this.setOnline()
        setInterval(() => {
            this.setOnline()
        }, 1000)
    },

    setOnline() {
        centrifuge.presenceStats("public:online").then((resp) => {
            this.online = resp.num_clients
        }).catch(() => {});
    },

    loadStatistics() {
        this.getStatistics().then(data => {
            if(data.status == 'success') {
                this.count_players = data.count_players
                this.count_success_trades = data.count_success_trades
                this.count_coins = data.count_coins
            }
        })
    },

    async getStatistics() {
        return await axios.get('/api/statistics').then((response) => {
            return response.data
        }).catch(() => {
            toast('error', 'Ошибка отправки запроса')
        })
    }
})

