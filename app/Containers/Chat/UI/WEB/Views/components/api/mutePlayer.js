import makeRequest from '../../../../../../../../resources/js/api/makeRequest'

export default async function(params) {
    return await makeRequest('post', '/api/chat/player/mute', params).catch((error) => {
        toast('error', 'Ошибка отправки запроса')
    })
}
