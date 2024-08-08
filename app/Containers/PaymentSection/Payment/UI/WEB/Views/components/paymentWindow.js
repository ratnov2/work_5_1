import makePayment from "./api/makePayment";
import getPaymentSystemsInfo from "./api/getPaymentSystemsInfo";
import checkPromocode from "./api/checkPromocode";

export default () => ({
    is_checking_promocode: false,
    is_making_payment: false,

    promocode_value: "",
    promocode: null,

    sum: 100,

    categories: [{name: 'Все', slug: 'all'}],
    selected_category: null,
    directions: [],
    selected_direction: null,

    info_html: "",

    init() {
        this.selectCategory(this.categories.find(c => c.slug == 'all'));

        getPaymentSystemsInfo().then(data => {
            if(!data) return;
            this.categories = this.categories.concat(data.categories)
            this.directions = data.directions
        })
    },

    selectCategory(category) {
        this.selected_category = category
    },

    selectDirection(direction) {
        this.selected_direction = direction;
    },

    get filteredDirections() {
        if(this.selected_category.slug == 'all') return this.directions;
        return this.directions.filter(d => d.category_slugs.includes(this.selected_category.slug))
    },

    get paymentFinalPrecent() {
        let finalPrecent = 0
        if(this.$store.player.player.referrer_bonus_precent) finalPrecent += parseFloat(this.$store.player.player.referrer_bonus_precent);
        if(this.promocode) finalPrecent += parseFloat(this.promocode.precent);
        return finalPrecent;
    },

    async makePayment() {
        if (!this.selected_direction) return;
        if (this.is_making_payment) return;

        let params = {};
        if (this.selected_direction.is_need_sum) params.sum = this.sum;
        if (this.promocode) params.promocode_value = this.promocode.value;
        params.payment_system_direction_id = this.selected_direction.id;

        this.is_making_payment = true
        await makePayment(params).then(data => {
            if(!data) return;
            switch (data.data.type) {
                case "redirect":
                    location.href = data.data.url;
                    break;
                case "no_redirect":
                    this.info_html = data.data.info_html;
                    break;
            }
        }).finally(() => {
            this.is_making_payment = false
        });
    },

    async checkPromocode() {
        this.is_checking_promocode = true;
        await checkPromocode({ promocode_value: this.promocode_value }).then(data => {
            if(!data) return;
            this.promocode = data.promocode;
        }).finally(() => {
            this.is_checking_promocode = false;
        });
    },
});
