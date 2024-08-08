const Centrifuge = require('centrifuge');
const WebSocket = require('ws');
const XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
const jwt = require('jsonwebtoken');
require('dotenv').config();

function createCentrifuge(game_mode) {
    const centrifuge = new Centrifuge(process.env.CENTRIFUGO_WS, {
        websocket: WebSocket,
        xmlhttprequest: XMLHttpRequest
    });
    
    const token = jwt.sign({ sub: `${game_mode}` }, process.env.CENTRIFUGO_TOKEN_HMAC_SECRET_KEY);
    centrifuge.setToken(token)

    centrifuge.connect();

    return centrifuge;
}

module.exports = { createCentrifuge }