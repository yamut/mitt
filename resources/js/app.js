import './bootstrap'
import 'bootstrap'
import '@popperjs/core'
import jQuery from 'jquery'
import parsley from 'parsleyjs/dist/parsley.js'

window.$ = jQuery

window.parsley = parsley
// eslint-disable-next-line no-unused-vars
const modules = import.meta.glob([
    '../images/**'
])

$(function () {
    const $responseForm = $('#response-form')
    $responseForm.on('submit', function (e) {
        e.preventDefault()
        $responseForm.parsley().validate()
        if (!$responseForm.parsley().isValid()) {
            return
        }
        $('#messages').empty()
        const headers = {}
        $('.headers-row').each(function () {
            headers[$('.header-name', $(this)).val()] = $('.header-value', $(this)).val()
        })
        $.ajax({
            method: 'POST',
            url: $('#save').data('save'),
            data: {
                slug: $('#slug').val(),
                http_status: $('#http_status').val(),
                body: $('#body').val(),
                _token: $('input[name=_token]').val(),
                headers
            },
            success: function () {
                $responseForm.trigger('reset')
                $('.headers-row').remove()
            },
            error: function (response) {
                $('#messages').append(
                    `<div class="alert alert-dismissable alert-danger my-2">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        ${response.responseJSON.message}
                    </div>`
                )
            }
        })
    })
    const $resultsTable = $('#results-table')
    const $endpointsTable = $('#endpoints-table')
    setInterval(function () {
        $.get($resultsTable.data('source'))
            .then(response => {
                if (!response.length) {
                    return
                }
                $('tbody', $resultsTable).empty()
                for (const i of response) {
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
                    return
                }
                $('tbody', $endpointsTable).empty()
                for (const i of response) {
                    $('tbody', $endpointsTable).append(`<tr>
                        <th>${i.url}<button class="copy-url btn btn-outline-warning px-2 ms-2" data-copy="${i.url}" type="button"><i class="bi-clipboard"></i></button></th>
                        <th>${i.http_status}</th>
                        <th><pre>${i.body}</pre></th>
                        <th><pre>${JSON.stringify(i.headers, null, 4)}</pre></th>
                    </tr>`)
                }
            })
    }, 5000)
    $(document).on('click', '.copy-url', function (e) {
        e.preventDefault()
        navigator.clipboard.writeText($(this).data('copy'))
    })
    $('#clear-data').on('click', function () {
        const me = $(this)
        me.toggleClass('btn-primary').toggleClass('btn-danger')
        $.get(me.data('source'))
            .done(() => {
                $('tbody', $resultsTable).empty()
                    .append(`<tr class="active empty-state">
                        <td colspan="3" class="text-center">Nothing to see here</td>
                    </tr>`)
                $('tbody', $endpointsTable).empty()
                    .append(`<tr class="active empty-state">
                        <td colspan="4" class="text-center">Nothing to see here</td>
                    </tr>`)
                me.toggleClass('btn-primary').toggleClass('btn-danger')
            })
    })
    $('#add-header').on('click', function (e) {
        e.preventDefault()
        const nameId = `header-name-${Date.now()}`
        const valueId = `header-name-${Date.now()}`
        $('#headers').append(`<div class="headers-row d-flex justify-content-between">
            <div class="col-5 justify-content-center">
                <label for="${nameId}">Header name</label>
                <input id="${nameId}" class="header-name form-control" type="text"/>
            </div>
            <div class="col-5 justify-content-center">
                <label for="${valueId}">Header value</label>
                <input id="${valueId}" class="header-value form-control" type="text"/>
            </div>
        </div>`)
    })
})
