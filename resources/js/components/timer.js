export default (expiry = null) => ({
    expiry: expiry,
    remaining: null,
    interval_id: null,

    init() {
        if(this.expiry != null) {
            this.start(this.expiry)
        }
    },

    start(expiry) {
        this.expiry = expiry

        this.setRemaining();

        this.interval_id = setInterval(() => {
            this.setRemaining();
            this.$dispatch('timer-updated', { remaining: this.remaining })
        }, 1000);
    },

    stop() {
        clearInterval(this.interval_id)
        this.interval_id = null
    },

    setRemaining() {
        const diff = this.expiry - new Date().getTime();

        this.remaining = parseInt(diff / 1000);

        if(this.remaining <= 0) {
            clearInterval(this.interval_id)
            this.remaining = 0
        }
    },

    days() {
        return {
            value: this.remaining / 86400,
            remaining: this.remaining % 86400,
        };
    },

    hours() {
        return {
            value: this.days().remaining / 3600,
            remaining: this.days().remaining % 3600,
        };
    },

    minutes() {
        return {
            value: this.hours().remaining / 60,
            remaining: this.hours().remaining % 60,
        };
    },

    seconds() {
        return {
            value: this.minutes().remaining,
        };
    },

    format(value) {
        return ("0" + parseInt(value)).slice(-2);
    },

    get time() {
        return {
            days: this.format(this.days().value),
            hours: this.format(this.hours().value),
            minutes: this.format(this.minutes().value),
            seconds: this.format(this.seconds().value),
        };
    },
});
