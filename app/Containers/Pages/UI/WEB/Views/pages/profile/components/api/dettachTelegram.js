import makeRequest from '../../../../../../../../../../resources/js/api/makeRequest'

export default async function() {
    return await makeRequest('post', '/api/player/telegram/dettach').catch((error) => {
        toast('error', 'Ошибка отправки запроса')
    })
}
