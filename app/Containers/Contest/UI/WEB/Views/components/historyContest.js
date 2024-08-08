export default (history_contest) => ({
    history_contest: history_contest,
    end_at: null,

    init() {
        // this.end_at = new Date(this.history_contest.end_at).toLocaleDateString("ru-RU", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
        this.end_at = new Date(this.history_contest.end_at).toLocaleString()
    }
});
