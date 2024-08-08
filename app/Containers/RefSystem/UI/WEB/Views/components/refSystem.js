import setRefCode from './api/setRefCode'
import makeRefBalanceWithdraw from './api/makeRefBalanceWithdraw'

export default () => ({
    is_setting_ref_code : false,
    is_ref_balance_withdrawing : false,
    ref_code: '',
    ref_balance_sum: 0,

    init() {
        this.ref_code = this.$store.player.player.ref_code
        this.ref_balance_sum = this.$store.player.player.ref_balance
    },

    async setRefCode() {
        this.is_setting_ref_code = true
        await setRefCode({ ref_code: this.ref_code }).then(data => {
            if(!data) return;

            toast('success', data.msg)
            this.$store.player.player.trade_link = data.trade_link
        }).finally(() => {
            this.is_setting_ref_code = false
        })
    },

    async makeRefBalanceWithdraw() {
        this.is_ref_balance_withdrawing= true
        await makeRefBalanceWithdraw({ sum: this.ref_balance_sum }).then(data => {
            if(!data) return;

            toast('success', data.msg)
            this.$store.player.player.ref_balance = data.ref_balance;
            this.$store.player.player.balance = data.balance;
        }).finally(() => {
            this.is_ref_balance_withdrawing = false
        })
    },
});
