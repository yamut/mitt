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
                slug: $('#slug').val(),
                http_status: $('#http_status').val(),
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
                        <th>${i.url}</th>
                        <th>${!i.content.length ? '<i>empty</i>' : i.content}</th>
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
                        <th>${i.url}</th>
                        <th>${i.http_status}</th>
                        <th>${i.body}</th>
                    </tr>`)
                }

            })
    }, 5000);
    $('#clear-data').on('click', function () {
        $.get($(this).data('source'))
            .then(() => {
                $('tbody', $resultsTable).empty()
                    .append(`<tr class="active empty-state">
                        <td colspan="3" class="text-center">Nothing to see here</td>
                    </tr>`);
                $('tbody', $endpointsTable).empty()
                    .append(`<tr class="active empty-state">
                        <td colspan="3" class="text-center">Nothing to see here</td>
                    </tr>`);
            });
    });
});
