import tradeLink from './api/tradeLink'
import dettachTelegram from './api/dettachTelegram'
import dettachVk from './api/dettachVk'

export default () => ({
    is_setting_trade_link: false,
    is_setting_ref_code: false,
    is_dettaching_telegram: false,
    is_dettaching_vk: false,
    trade_link: '',

    init() {
        this.trade_link = this.$store.player.player.trade_link
    },

    async tradeLink() {
        this.is_setting_trade_link = true
        await tradeLink({trade_link: this.trade_link}).then(data => {
            if(!data) return;
            toast('success', data.msg)
        }).finally(() => {
            this.is_setting_trade_link = false
        })
    },

    async dettachTelegram() {
        this.is_dettaching_telegram = true
        await dettachTelegram().then(data => {
            if(!data) return;
            toast('success', data.msg)
            this.$store.player.player.telegramAccount = null;
        }).finally(() => {
            this.is_dettaching_telegram = false
        })
    },

    async dettachVk() {
        this.is_dettaching_vk = true
        await dettachVk().then(data => {
            if(!data) return;
            toast('success', data.msg)
            this.$store.player.player.vkAccount = null;
        }).finally(() => {
            this.is_dettaching_vk = false
        })
    }
});
