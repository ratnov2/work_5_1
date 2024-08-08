import { hooksComponentRegister } from "../../../../../../../resources/js/components/hooks";

export default () => ({
    is_open_rules: false,
    is_sending_message: false,
    is_open: true,
    input_message: '',
    messages: [],
    ws_channel: null,

    async init() {
        hooksComponentRegister(this)

        this.ws_channel = await centrifuge.subscribe("public:chat");

        this.ws_channel.history({
            limit: 30,
        }).then(resp => {
            const messages = resp.publications.map(p => p.data);
            const deleted_messages_uids = messages.filter(m => m.type === 'message_delete').map(m => m.uid);
            this.messages = messages.filter(m => !deleted_messages_uids.includes(m.uid));

            this.ws_channel.on("publish", event => {
                switch (event.data.type) {
                    case 'new_message':
                        this.messages.push(event.data)
                        this.$nextTick(() => this.scrollToNewMessages())
                        break;
    
                    case 'message_delete':
                        this.messages = this.messages.filter(message => message.uid !== event.data.uid)
                        break;
                }
            });
    
            this.$nextTick(() => this.scrollToNewMessages())
        });
    },

    scrollToNewMessages() {
        let messages_area = document.getElementById("messages-area");
        messages_area.scrollTop = messages_area.scrollHeight
    },

    sendMsg() {
        if(this.input_message.trim() === '') {
            toast('info', 'Напишите сообщение');
            return false;
        }

        this.is_sending_message = true
        axios.post('/api/chat/send', {
            msg: this.input_message
        }).then((response) => {
            const data = response.data
            if(data.status == 'error') {
                toast('error', data.msg)
                return false;
            }
            this.input_message = ''
        }).catch(() => {
            toast('error', 'Ошибка отправки сообщения');
        }).finally(() => {
            this.is_sending_message = false
        })
    },

    convertTimestamp(timestamp) {
        var d = new Date(timestamp * 1000),
            hh = d.getHours(),
            h = hh,
            min = ('0' + d.getMinutes()).slice(-2),
            time;

        if (hh > 12) {
            h = hh - 12;
        } else if (hh === 12) {
            h = 12;
        } else if (hh == 0) {
            h = 12;
        }

        time = h + ':' + min;

        return time;
    },

    beforeDestroy() {
        this.ws_channel.unsubscribe()
    }
})