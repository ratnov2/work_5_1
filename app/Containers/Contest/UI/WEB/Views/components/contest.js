import { hooksComponentRegister } from "../../../../../../../resources/js/components/hooks";

export default (contest) => ({
    contest: contest,

    contest_expiry: null,
    contest_reserved_date: null,
    contest_end_date: null,

    ws_channel: null,

    is_entering: false,
    progress: 0,

    init() {
        hooksComponentRegister(this);

        this.contest_expiry = new Date(this.contest.end_at);
        this.contest_reserved_date = new Date(this.contest.reserved_at).createDateAsUTC().getTime()
        this.contest_end_date = new Date(this.contest.end_at).createDateAsUTC().getTime()

        this.ws_channel = centrifuge.subscribe("public:contest" + this.contest.id);
        this.ws_channel.on("publish", (data) => {
            this.contest.count_players = data.data.count_players
        });

        this.setProgress()

        setInterval(() => {
            this.setProgress()
        }, 2000);
    },

    setProgress() {
        const remaining = this.contest_end_date - new Date().createDateAsUTC().getTime()
        const progress = parseFloat(remaining * 100 / (this.contest_end_date - this.contest_reserved_date))
        this.progress = progress <= 0 ? 0 : progress;
    },

    beforeDestroy() {
        this.ws_channel.unsubscribe()
    },

    get isContester() {
        return this.$store.player.player.contests_ids.includes(this.contest.id)
    },

    async enter(contest_id) {
        if(!this.validateEnter()) return;

        this.is_entering = true
        await axios.post('/api/contests/enter', {
            contest_id: contest_id
        }).then((response) => {
            const data = response.data

            if(data.status == 'error') {
                toast('error', data.msg);
                return;
            }

            if(data.status == 'success') {
                toast('success', data.msg)
                this.$store.player.player.contests_ids.push(this.contest.id)
            }
        }).finally(() => {
            this.is_entering = false
        })
    },

    validateEnter() {
        if(this.is_entering) return false;
        return true;
    }
});
