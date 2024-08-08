import Toastify from "toastify-js";
export function toast(type, msg) {
    let style = { color: '#fff', boxShadow: '0 0 10px #111', border: '1px solid #444046', borderRadius: '5px', background: "#1c1a22" };
    if(type == 'error') {
        style.color = '#fa5661';
    } else if(type == 'info') {
        style.color = '#98a5e6';
    } else if(type == 'success') {
        style.color = '#86efac';
    }

    Toastify({
        text: msg,
        style: style,
    }).showToast();
}
window.toast = toast;

export function closeModal(id) {
    const modal = document.getElementById('modal-' + id)
    modal.classList.add('hidden')
};
window.closeModal = closeModal;

export function smoothScroll(id){
    document.querySelector('#' + id).scrollIntoView({
        behavior: 'smooth'
    });
}
window.smoothScroll = smoothScroll;

export const showModal = function(id) {
    const modal = document.getElementById('modal-' + id)
    modal.classList.add('animate__fadeIn')
    modal.classList.remove('hidden')
};
window.showModal = showModal

export function roundLikePHP(num, dec) {
    var num_sign = num >= 0 ? 1 : -1;
    return parseFloat(
        (
            Math.round(num * Math.pow(10, dec) + num_sign * 0.0001) /
            Math.pow(10, dec)
        ).toFixed(dec)
    );
}
window.roundLikePHP = roundLikePHP;

export function copyToClipboard(str) {
    const el = document.createElement('textarea');
    el.value = str;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    toast("info", "Скопировано!")
};
window.copyToClipboard = copyToClipboard

export function generateRandom(min = 0, max = 100) {
    let difference = max - min;
    let rand = Math.random();
    rand = Math.floor( rand * difference);
    rand = rand + min;
    return rand;
}
