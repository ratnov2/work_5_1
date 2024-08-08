import makeRequest from '../../../../../../../../resources/js/api/makeRequest'

export default async function() {
    return await makeRequest('get', '/api/server-timestamp').catch((error) => {
        toast('error', 'Ошибка отправки запроса')
    })
}
