import 'bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

import '../sass/app.scss';

document.addEventListener('livewire:load', function () {
    var myModalEl = document.getElementById('addBookModal')
    var modal = new bootstrap.Modal(myModalEl)

    Livewire.on('openModal', () => {
        myModal.show();
    });

    Livewire.on('closeModal', () => {
        myModal.hide();
    });
})
