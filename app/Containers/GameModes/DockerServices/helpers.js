const axios = require("axios");
require('dotenv').config();

class GameMode {
    game_mode;

    constructor(game_mode) {
        this.game_mode = game_mode;
    }

    async publishEvent(data) {
        const channel = `public:${this.game_mode}`;
        const event = { method: "publish", params: { channel, data } };
    
        await axios.post("http://centrifugo:8000/api", event, {
            headers: {
                'Authorization': "apikey " + process.env.CENTRIFUGO_API_KEY
            }
        });
    }
    
    async callServiceController(method, params = {}) {
        const response = await axios.post(`http://nginx/api/${this.game_mode}/service/` + method, params, {
            headers: {
                'Authorization': process.env.GAME_MODE_SECRET
            }
        });

        return response.data
    }
}

async function delay(s) {
    return await new Promise(resolve => setTimeout(resolve, s * 1000));
}

module.exports = { GameMode, delay }
