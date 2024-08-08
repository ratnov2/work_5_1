import { hooksComponentRegister } from "../../../../../../../resources/js/components/hooks";

export default (jackpot) => ({
    JACKPOT_TIMOUT_CHOOSE_THE_WINNER_ANIMATION_MS: 20000,
    EMPTY_CHART_HTML: '<svg width="100%" height="100%" viewbox="0 0 33 33"><circle class="donut-segment" cx="50%" cy="50%" r="15.91549430918954" fill="transparent" stroke-linecap="round" stroke-width="1" stroke="#9333ea" stroke-dasharray="98.6 1.4" stroke-dashoffset="24.3"></circle></svg>',
    RADIUS: 125,

    jackpot,
    display: 'Ожидание игроков',
    chart_html: '',
    players_info: [],
    win_player: null,
    win_player_info: null,
    win_arrow_animation_ms: 0,
    win_arrow_rotation_deg: 0,
    is_show_wait_bets_animation: true,
    is_show_win_player: false,
    is_show_display: true,
    ws_channel: null,

    init() {
        hooksComponentRegister(this)

        this.$watch('jackpot.bets', () => this._updatePlayersInfo())
        this.$watch('players_info', () => this._renderChartHTML())

        this.ws_channel = centrifuge.subscribe("public:jackpot")
        this.ws_channel.on("publish", ({ data }) => {
            switch (data.action) {
                case 'update_bets':
                    this.jackpot.bets = data.bets
                    break;

                case 'сountdown':
                    this.display = data.seconds
                    break;

                case 'active':
                    this.display = 'Выбор победителя'
                    this.win_player = data.win_player
                    this.jackpot.win_ticket = data.win_ticket

                    if(this.players_info.length == 0) return
                    this.win_player_info = this.players_info.find(player_info => player_info.player.id == this.win_player.id)
                    if(this.win_player_info == undefined) return

                    if(this.win_arrow_animation_ms == 0) this.win_arrow_animation_ms = this.JACKPOT_TIMOUT_CHOOSE_THE_WINNER_ANIMATION_MS - data.seconds * 1000
                    this.win_arrow_rotation_deg = this._createWinArrowRotationDeg(this.win_player_info, data.random_offset_precent)
                    this.is_show_wait_bets_animation = false
                    break;

                case 'end':
                    if(this.win_player == null) return
                    this.is_show_win_player = true
                    this.is_show_display = false
                    break;

                case 'reset':
                    this.is_show_wait_bets_animation = true
                    this.is_show_win_player = false
                    this.is_show_display = true
                    this.jackpot.bets = []
                    this.jackpot.win_ticket = null
                    this.jackpot.id = data.next_jackpot_id
                    this.display = 'Ожидание игроков'
                    this.chart_html = ''
                    this.players_info = []
                    this.win_player = null
                    this.win_player_info = null
                    this.win_arrow_animation_ms = 0
                    this.win_arrow_rotation_deg = 0
                    break;

            }
        });

        this._updatePlayersInfo()
    },

    beforeDestroy() {
        this.ws_channel.unsubscribe()
    },

    _updatePlayersInfo() {
        let players_info = []
        this.jackpot.bets.forEach(bet => {
            let prev_player_info = players_info.find(player_info => player_info.player.id == bet.player.id);
            if(prev_player_info !== undefined) {
                prev_player_info.sum += bet.sum
                if(prev_player_info.timestamp > bet.timestamp) prev_player_info.timestamp = bet.timestamp
            } else {
                players_info.push({
                    sum: bet.sum,
                    player: bet.player,
                    timestamp: bet.timestamp,
                })
            }
        })

        let prev_sum_precent = 0;
        players_info = players_info.sort((a,b) => (a.timestamp > b.timestamp) ? 1 : ((b.timestamp > a.timestamp) ? -1 : 0))
        players_info.forEach((player_info, index) => {
            player_info.precent = player_info.sum * 100 / this.bank
            // add avatar style
            let deg = (prev_sum_precent + player_info.precent / 2) * 3.6
            let {x, y} = this._getCoordinateOnCircleByDeg(deg - 90)
            player_info.avatar_deg = deg
            player_info.color = this.backgroundColor[index]
            player_info.transform_style = { transform: `translate(${x}px, ${y}px)` }
            prev_sum_precent += player_info.precent
        })
        this.players_info = players_info
    },

    _renderChartHTML() {
        if(this.players_info.length == 0) {
            this.chart_html = this.EMPTY_CHART_HTML;
            return;
        }

        let html = '<svg width="100%" height="100%" viewbox="0 0 33 33">'
        let prev_sum_precent = 0;
        this.players_info.forEach((player_info, index) => {
            let stroke = this.backgroundColor[index];
            let stroke_dasharray = (player_info.precent - 1.4) + " " + (parseFloat(100 - player_info.precent) + 1.4)
            let stroke_dashoffset = index == 0 ? 24.3 : parseFloat(100 - prev_sum_precent + 24.3)
            html += `<circle class="donut-segment" cx="50%" cy="50%" r="15.91549430918954" fill="transparent" stroke-linecap="round" stroke-width="1" stroke="${stroke}" stroke-dasharray="${stroke_dasharray}" stroke-dashoffset="${stroke_dashoffset}"></circle>`
            prev_sum_precent += player_info.precent
        })
        html += '</svg>';
        this.chart_html = html
    },

    _createWinArrowRotationDeg(player_info, random_offset_precent) {
        let player_arc_deg = player_info.precent * 3.6
        let player_arc_start_deg = player_info.avatar_deg - player_arc_deg / 2
        return player_arc_start_deg + (random_offset_precent * player_arc_deg / 100) + 3600
    },

    _getCoordinateOnCircleByDeg(deg) {
        let angle = Math.PI * deg / 180;
        let x = this.RADIUS * Math.cos(angle);
        let y = this.RADIUS * Math.sin(angle);
        return {x, y};
    },

    get isShowWinPlayer() {
        return this.is_show_win_player && this.win_player != null
    },

    get roundPlayersInfo() {
        let players_info_copy = [...this.players_info]
        return players_info_copy.sort((a,b) => (a.precent > b.precent) ? -1 : ((b.precent > a.precent) ? 1 : 0))
    },

    get bank() {
        return this.jackpot.bets.reduce((prev, bet) => prev + parseFloat(bet.sum), 0)
    },

    get countItems() {
        return this.jackpot.bets.reduce((prev, bet) => prev + bet.items.length, 0)
    },

    get countPlayers() {
        return this.players_info.length
    },

    backgroundColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(64, 255, 246, 1)',
        'rgba(243, 64, 255, 1)',
        'rgba(64, 255, 88, 1)',
        'rgba(199, 30, 66, 1)',
        'rgba(30, 51, 199, 1)',
        'rgba(196, 30, 199, 1)',
        'rgba(118, 30, 199, 1)',
        "rgba(250, 197, 153, 1)",
        'rgba(30, 199, 82, 1)',
        "rgba(18, 170, 138, 1)",
        "rgba(218, 170, 96, 1)",
        "rgba(12, 184, 222, 1)",
        "rgba(209, 24, 207, 1)",
        "rgba(186, 160, 116, 1)",
        "rgba(171, 250, 59, 1)",
        "rgba(201, 34, 143, 1)",
        "rgba(164, 177, 45, 1)",
        "rgba(14, 34, 103, 1)",
        "rgba(140, 94, 72, 1)",
        "rgba(29, 174, 39, 1)",
        "rgba(254, 79, 30, 1)",
        "rgba(25, 100, 146, 1)",
        "rgba(154, 215, 142, 1)",
        "rgba(248, 26, 8, 1)",
        "rgba(90, 228, 200, 1)",
        "rgba(153, 44, 106, 1)",
        "rgba(71, 191, 251, 1)",
        "rgba(255, 32, 137, 1)",
        "rgba(175, 1, 190, 1)",
        "rgba(195, 130, 24, 1)",
        "rgba(90, 96, 218, 1)",
        "rgba(112, 29, 241, 1)",
        "rgba(88, 3, 211, 1)",
        "rgba(81, 43, 21, 1)",
        "rgba(8, 197, 138, 1)",
        "rgba(196, 35, 232, 1)",
        "rgba(126, 36, 245, 1)",
        "rgba(155, 219, 228, 1)",
        "rgba(62, 44, 181, 1)",
        "rgba(216, 167, 230, 1)",
        "rgba(152, 186, 32, 1)",
        "rgba(7, 42, 77, 1)",
        "rgba(193, 8, 238, 1)",
        "rgba(56, 11, 64, 1)",
        "rgba(195, 48, 74, 1)",
        "rgba(75, 58, 17, 1)",
        "rgba(20, 144, 163, 1)",
        "rgba(60, 212, 15, 1)",
        "rgba(195, 213, 163, 1)",
        "rgba(200, 88, 201, 1)",
        "rgba(236, 10, 18, 1)",
        "rgba(174, 216, 92, 1)",
        "rgba(81, 146, 18, 1)",
        "rgba(209, 231, 250, 1)",
        "rgba(176, 106, 188, 1)",
        "rgba(81, 158, 138, 1)",
        "rgba(170, 45, 132, 1)",
        "rgba(195, 78, 124, 1)",
        "rgba(244, 29, 150, 1)",
        "rgba(192, 90, 161, 1)",
        "rgba(146, 255, 67, 1)",
        "rgba(118, 28, 168, 1)",
        "rgba(214, 74, 218, 1)",
        "rgba(3, 135, 213, 1)",
        "rgba(203, 164, 25, 1)",
        "rgba(136, 199, 118, 1)",
        "rgba(125, 66, 74, 1)",
        "rgba(8, 222, 158, 1)",
        "rgba(29, 250, 113, 1)",
        "rgba(9, 49, 0, 1)",
        "rgba(188, 174, 131, 1)",
        "rgba(108, 43, 245, 1)",
        "rgba(96, 40, 91, 1)",
        "rgba(82, 109, 184, 1)",
        "rgba(102, 72, 98, 1)",
        "rgba(253, 187, 131, 1)",
        "rgba(136, 83, 248, 1)",
        "rgba(164, 159, 113, 1)",
        "rgba(134, 99, 231, 1)",
        "rgba(161, 116, 24, 1)",
        "rgba(107, 99, 244, 1)",
        "rgba(251, 102, 17, 1)",
        "rgba(215, 16, 30, 1)",
        "rgba(167, 164, 74, 1)",
        "rgba(160, 39, 63, 1)",
        "rgba(107, 108, 68, 1)",
        "rgba(246, 90, 198, 1)",
        "rgba(196, 14, 126, 1)",
        "rgba(85, 190, 176, 1)",
        "rgba(1, 235, 159, 1)",
        "rgba(177, 164, 207, 1)",
        "rgba(228, 146, 250, 1)",
        "rgba(50, 76, 137, 1)",
        "rgba(225, 182, 44, 1)",
        "rgba(48, 12, 244, 1)",
        "rgba(185, 5, 124, 1)",
        "rgba(153, 4, 126, 1)",
        "rgba(70, 220, 87, 1)",
        "rgba(254, 171, 183, 1)",
        "rgba(184, 119, 91, 1)",
        "rgba(184, 96, 189, 1)",
        "rgba(27, 210, 20, 1)",
        "rgba(205, 120, 240, 1)",
        "rgba(14, 74, 16, 1)",
        "rgba(232, 227, 169, 1)",
        "rgba(95, 229, 181, 1)",
        "rgba(41, 109, 9, 1)",
    ]
});
