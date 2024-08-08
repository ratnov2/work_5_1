const { GameMode, delay } = require('./helpers');
require('dotenv').config();

const GAME_MODE = 'jackpot';
const TIMEOUT_START_SECONDS = process.env.JACKPOT_TIMEOUT_START_SECONDS
const TIMEOUT_CHOOSE_THE_WINNER_ANIMATION_SECONDS = process.env.JACKPOT_TIMEOUT_CHOOSE_THE_WINNER_ANIMATION_SECONDS
let IS_ACTIVE = false;

const { createCentrifuge } = require('./centrifugo')
createCentrifuge(GAME_MODE).subscribe(`#${GAME_MODE}`).on("publish", (data) => {
    if(!IS_ACTIVE) {
        IS_ACTIVE = true;
        startGameRound(new GameMode(GAME_MODE));
    }
});

async function startGameRound(jackpot, step = 1) {
    try {
        if(step <= 1) {
            await startCountdown(jackpot);
        }

        if(step <= 2) {
            await toActive(jackpot);
        }

        if(step <= 3) {
            await toEnd(jackpot);
        }
    } catch (error) {
        console.log(error.message);
        ping();
    }
}

async function startCountdown(jackpot) {
    let seconds = TIMEOUT_START_SECONDS;

    await new Promise((resolve) => {
        const interval_id = setInterval(async() => {
            await jackpot.publishEvent({'action': 'сountdown', 'seconds': seconds})

            if(seconds == 0) {
                clearInterval(interval_id);
                resolve();
            }

            seconds--;
        }, 1000)
    });
}

async function toActive(jackpot) {
    const data = await jackpot.callServiceController('active');
    if(data.status != 'success') throw new Error("callServiceController('active'): " + data.msg)

    let seconds = TIMEOUT_CHOOSE_THE_WINNER_ANIMATION_SECONDS;
    let random_offset_precent = Math.random() * 100

    await new Promise((resolve) => {
        const interval_id = setInterval(async() => {
            await jackpot.publishEvent({
                'action': 'active',
                'random_offset_precent': random_offset_precent,
                'seconds': TIMEOUT_CHOOSE_THE_WINNER_ANIMATION_SECONDS - seconds,
                'win_ticket': data.win_ticket,
                'win_player': data.win_player
            })

            if(seconds == 0) {
                clearInterval(interval_id);
                resolve();
            }

            seconds--;
        }, 1000)
    });
}

async function toEnd(jackpot) {
    const data = await jackpot.callServiceController('end');
    if(data.status != 'success') throw new Error("callServiceController('end'): " + data.msg)

    await jackpot.publishEvent({'action': 'end'})
    await delay(5)
    await jackpot.publishEvent({'action': 'reset'}) 

    IS_ACTIVE = false;
}

function ping() {
    try {
        [new GameMode(GAME_MODE)].forEach(async (jackpot) => {    
            const data = await jackpot.callServiceController('ping');
            if(data.status != 'success') throw new Error("callServiceController('ping'): " + data.msg)
            
            switch (data.status_jackpot) {
                case 'wait_timeout':
                    startGameRound(jackpot, 1)
                    break;
                case 'active':
                    startGameRound(jackpot, 3)
                    break;
            } 
        });
    } catch (error) {
        console.log(error.message); 
        setTimeout(() => {
            ping();
        }, 5000);
    } 
}

ping();