import makeRequest from '../../../../../../../../resources/js/api/makeRequest'

export default async function(params) {
    return await makeRequest('post', '/api/chat/player/unmute', params).catch((error) => {
        toast('error', 'Ошибка отправки запроса')
    })
}
