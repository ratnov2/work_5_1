import makeRequest from '../../../../../../../../../../resources/js/api/makeRequest'

export default async function(next_items_url) {
    return await makeRequest('get', next_items_url).catch((error) => {
        toast('error', 'Ошибка отправки запроса')
    })
}
