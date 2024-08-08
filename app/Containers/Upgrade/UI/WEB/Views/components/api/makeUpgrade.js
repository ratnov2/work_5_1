import makeRequest from '../../../../../../../../resources/js/api/makeRequest'

export default async function(params) {
    return await makeRequest('post', '/api/upgrade/player/make', params).catch((error) => {
        toast('error', 'Ошибка отправки запроса')
    })
}
