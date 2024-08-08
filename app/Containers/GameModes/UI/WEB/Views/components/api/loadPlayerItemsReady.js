import makeRequest from '../../../../../../../../resources/js/api/makeRequest'

export default async function(url) {
    return await makeRequest('get', url).catch((error) => {
        toast('error', 'Ошибка отправки запроса')
    })
}
