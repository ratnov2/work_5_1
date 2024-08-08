import player from '../../../../../../Player/UI/WEB/Views/components/store/player'

export default {
    msg: 'Требуется авторизация',
    run() {
        return new Promise(resolve => {
            if(player.player == null) resolve(false);
            resolve(true);
        })
    },
}
