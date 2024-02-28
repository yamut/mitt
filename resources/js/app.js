import './bootstrap';
import 'bootstrap';
import '@popperjs/core';
import jQuery from 'jquery';

window.$ = jQuery;

import.meta.glob([
    '../images/**',
]);

$(function () {
    $('#save').on('click', function () {
        $('#messages').empty();
        $.ajax({
            method: 'POST',
            url: $(this).data('save'),
            data: {
                endpoint: $('#endpoint').val(),
                code: $('#code').val(),
                body: $('#body').val(),
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                console.log('done');
                console.log(response);
            },
            error: function (response) {
                $('#messages').append(
                    `<div class="alert alert-dismissable alert-danger my-2">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        ${response.responseJSON.message}
                    </div>`
                );
            },
        })
    });
    const $resultsTable = $('#results-table');
    const $endpointsTable = $('#endpoints-table')
    setInterval(function () {
        $.get($resultsTable.data('source'))
            .then(response => {
                if (!response.length) {
                    return;
                }
                $('tbody', $resultsTable).empty();
                for (let i of response) {
                    $('tbody', $resultsTable).append(`<tr>
                        <th>${i.path}</th>
                        <th>${!i.body.length ? '<i>empty</i>' : i.body}</th>
                        <th>${JSON.stringify(i.headers)}</th>
                    </tr>`)
                }
            })
        $.get($endpointsTable.data('source'))
            .then(response => {
                if (!response.length) {
                    return;
                }
                $('tbody', $endpointsTable).empty();
                for (let i of response) {
                    $('tbody', $endpointsTable).append(`<tr>
                        <th>${i.endpoint}</th>
                        <th>${i.code}</th>
                        <th>${i.body}</th>
                    </tr>`)
                }

            })
    }, 5000);
})
