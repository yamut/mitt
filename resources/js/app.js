import './bootstrap';
import 'bootstrap';
import '@popperjs/core';
import jQuery from 'jquery';
window.$ = jQuery;
import parsley from "parsleyjs/dist/parsley.js";
window.parsley = parsley;

import.meta.glob([
    '../images/**',
]);

$(function () {
    const $responseForm = $('#response-form');
    $responseForm.on('submit', function (e) {
        e.preventDefault();
        $responseForm.parsley().validate();
        if (!$responseForm.parsley().isValid()) {
            return;
        }
        $('#messages').empty();
        $.ajax({
            method: 'POST',
            url: $('#save').data('save'),
            data: {
                slug: $('#slug').val(),
                http_status: $('#http_status').val(),
                body: $('#body').val(),
                _token: $('input[name=_token]').val(),
            },
            success: function () {
                $responseForm.trigger('reset');
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
                        <th><pre>${JSON.stringify(i.headers, null, 4)}</pre></th>
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
                        <th>${i.url}<button class="copy-url btn btn-outline-warning px-2 ms-2" data-copy="${i.url}" type="button"><i class="bi-clipboard"></i></button></th>
                        <th>${i.http_status}</th>
                        <th><pre>${i.body}</pre></th>
                    </tr>`)
                }

            })
    }, 5000);
    $(document).on('click', '.copy-url', function (e) {
        e.preventDefault();
        navigator.clipboard.writeText($(this).data('copy'));
    })
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
