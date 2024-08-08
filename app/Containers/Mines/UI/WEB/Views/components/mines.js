import startGame from "./api/startGame";
import takePrize from "./api/takePrize";
import openCell from "./api/openCell";

export default (mines_game = null) => ({
    mines_game,
    buttons: [2, 3, 5, 15, 24],
    count_mines: 2,
    size: 5,
    is_starting_game: false,
    is_opening_cell: false,
    is_taking_prize: false,
    is_showing_cells_animation: false,

    init() {
        if(this.mines_game != null) {
            this.$store.invent.is_disable_for_selecting = true;
            this.count_mines = this.mines_game.count_mines;
            this.$nextTick(() => this._showCellsAnimation())
        }
    },

    get coefficients() {
        const arr = [];

        let o = 1;
        let a = 0.05;

        for (let i = 0; i < 25 - this.count_mines; i++) {
            const s = (o *= (25 - i) / (25 - this.count_mines - i)) - o * a;
            const c = Math.floor(100 * s) / 100;
            arr.push(c);
        }

        return arr;
    },

    get step() {
        if (this.mines_game === null) return 0;

        let step = 0;

        for (let value of Object.values(this.mines_game.cell_results))
            if(value) step++;

        return step;
    },

    get isOpenCellDisabled() {
        if (this.mines_game === null) return true;

        return !this.mines_game.status === "in_game" || this.is_showing_cells_animation;
    },

    get isBetPanelDisabled() {
        if (this.mines_game === null) return false;

        return this.mines_game.status === "in_game";
    },

    get isShowStartGameButton() {
        return this.mines_game === null;
    },

    get isShowTakePrizeButton() {
        if (this.mines_game === null) return false;

        return this.mines_game.status === 'in_game' && this.step >= 1;
    },

    get isShowWaitFirstStepBanner() {
        if (this.mines_game === null) return false;

        return this.mines_game.status === 'in_game' && this.step == 0;
    },

    get isShowWaitFailBanner() {
        if (this.mines_game === null) return false;

        return this.mines_game.status == 'end' && this.mines_game.win_amount == null;
    },

    get currentPrizeAmount() {
        if (this.mines_game === null) return 0;
        if (this.mines_game.cell_results == null) return 0;

        let current_prize_amount = this.mines_game.bets.reduce((acc, bet) => acc + parseFloat(bet.price), 0);

        if(this.step >= 1) current_prize_amount *= this.coefficients[this.step - 1];

        return roundLikePHP(current_prize_amount, 2);
    },

    async takePrize() {
        this.is_taking_prize = true;
        await takePrize().then((data) => {
            if(!data) return false;
            this.mines_game = data.mines_game;
            this.$store.player.updateBalance(roundLikePHP(data.player_balance, 2));
            toast('success', 'Ваш выигрыш ' + roundLikePHP(this.mines_game.win_amount, 2) + ' RUB');
            this._showCellsAnimation();
            setTimeout(() => this._resetGame(), 1800);
        })
        .catch(() => {
            toast("error", "Ошибка отправки запроса");
        })
        .finally(() => {
            this.is_taking_prize = false;
        });
    },

    async startGame() {
        if(this.$store.invent.selected_player_items.length == 0) {
            toast('error', 'Выберите хотя бы 1 скин');
            return false;
        }
        if(this.is_starting_game) return false;

        this.is_starting_game = true;
        const uniqids = this.$store.invent.selected_player_items.map((spi) => spi.uniqid);
        await startGame({count_mines: this.count_mines,uniqids: uniqids}).then((data) => {
            if (!data) return false;
            this.mines_game = data.mines_game;
            this.$store.invent.is_disable_for_selecting = true;
            this.$store.invent.removePlayerItemsByUniqids(...uniqids);
            this.$store.invent.removeSelectedPlayerItems();
            toast("success", "Игра началась");
        })
        .catch(() => {
            toast("error", "Ошибка отправки запроса");
        })
        .finally(() => {
            this.is_starting_game = false;
        });
    },

    async openCell(cell_index) {
        if(this.isOpenCellDisabled) return false;

        this.is_opening_cell = true;
        await openCell({cell_index}).then(data => {
            if(!data) return false;

            this.mines_game = data.mines_game;

            // Next
            if(this.mines_game.status !== 'end') {
                this._showCellAnimation(cell_index);
            }

            // End
            if(this.mines_game.status === 'end') {
                // Win end
                if(this.mines_game.win_amount != null) {
                    this.$store.player.updateBalance(roundLikePHP(data.player_real_balance, 2));
                    toast('success', 'Ваш выигрыш ' + roundLikePHP(this.mines_game.win_amount, 2) + ' RUB');
                }

                this._showCellsAnimation();
                setTimeout(() => this._resetGame(), 1800);
            }
        }).catch(() => {
            toast('error', 'Ошибка отправки запроса');
        }).finally(() => {
            this.is_opening_cell = false;
        });
    },

    _showCellsAnimation() {
        for (let [key, value] of Object.entries(this.mines_game.cell_results)) {
            this._showCellAnimation(key);
        }
    },

    _showCellAnimation(cell_index) {
        const cell = document.getElementById(`cell${cell_index}`);
        const cellResult = document.getElementById(`cellResult${cell_index}`);

        cell.classList.add("animate__flipOutX");
        setTimeout(() => {
            cellResult.classList.add("animate__flipInX");
            cellResult.classList.remove("hidden");
        }, 500);
    },

    _resetCellAnimation(cellIndex) {
        const cell = document.getElementById(`cell${cellIndex}`);
        const cellResult = document.getElementById(`cellResult${cellIndex}`);
        cell.classList.remove("animate__flipOutX");
        cellResult.classList.remove("animate__flipInX");
        cellResult.classList.add("hidden");
    },

    _resetGame() {
        for (let i = 1; i <= this.size; i++) {
            for (let k = 1; k <= this.size; k++) {
                const cellIndex = k + this.size * (i - 1);
                this._resetCellAnimation(cellIndex);
            }
        }

        this.$store.invent.is_disable_for_selecting = false;
        this.mines_game = null;
    },
});
