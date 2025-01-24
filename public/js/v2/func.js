function convertUnixTimestampToTime(timestamp) {
    var date = new Date(timestamp * 1000);
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();

    var formattedTime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

    return formattedTime;
}

function formatBytes(size) {
    var unit = [
        'Byte',
        'KiB',
        'MiB',
        'GiB',
        'TiB',
        'PiB',
        'EiB',
        'ZiB',
        'YiB'
    ];
    for (i = 0; size >= 1024 && i <= unit.length; i++) {
        size = size / 1024;
    }
    return parseFloat(size).toFixed(2) + ' ' + unit[i];
}

function selected() {
    let id = $('input[name="id[]"]:checked').length;

    if (id <= 0) {
        Swal.fire({
            title: 'Failed!',
            text: "No Selected Data!",
            icon: 'error',
        })
        return false
    }
    return true
}

function show_alert(message, type){
    Swal.fire({
        title: type == 'success' ? 'Success!' : 'Failed!',
        text: message,
        icon: type,
    })
}

function handleResponseCode(xhr) {
    let code = xhr.status || 500
    if (code === 404) {
        Swal.fire({
            title: 'Failed!',
            text: "Not Found!",
            icon: 'error',
        })
    } else if (code === 500) {
        Swal.fire({
            title: 'Failed!',
            text: "Server Error!",
            icon: 'error',
        })
    } else if (code === 403) {
        Swal.fire({
            title: 'Failed!',
            text: "Unauthorize!",
            icon: 'error',
        })
    } else if (code === 401) {
        Swal.fire({
            title: 'Failed!',
            text: "Unauthenticate, Please Login!",
            icon: 'error',
        })
    } else {
        Swal.fire({
            title: 'Failed!',
            text: "Error! Code : " + code,
            icon: 'error',
        })
    }
}

function handleResponse(jqXHR) {
    let message = jqXHR.responseJSON.message || 'Server Error!'
    Swal.fire({
        title: 'Failed!',
        text: message,
        icon: 'error',
    })
}

function handleResponseForm(jqXHR, formID) {
    let message = jqXHR.responseJSON.message
    if (jqXHR.status != 422) {
        Swal.fire({
            title: 'Failed!',
            text: message,
            icon: 'error',
        })
        if(jqXHR.status == 419){
            window.location.reload()
        }
    } else {
        let errors = jqXHR.responseJSON.errors || {};
        let errorKeys = Object.keys(errors);
        
        for (let i = 0; i < errorKeys.length; i++) {
            let fieldName = errorKeys[i];
            let errorMessage = errors[fieldName][0];
            $('#' + formID + ' [name="' + fieldName + '"]').addClass('is-invalid');
            $('#' + formID + ' [name="' + fieldName + '"]').removeClass('is-valid');
            $('#' + formID + ' .err_' + fieldName).text(errorMessage).show();
        }
    }
}

function input_focus(input_name){
    $(`input[name="${input_name}"]`).focus();
}

function delete_batch(url = null) {
    if(url == null){
        url = url_index_api
    }
    if (selected()) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Data Will be Lost!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
            confirmButtonAriaLabel: 'Thumbs up, Yes!',
            cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
            cancelButtonAriaLabel: 'Thumbs down',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            padding: '2em',
            customClass: 'animated tada',
            showClass: {
                popup: `animated tada`
            },
        }).then((result) => {
            if (result.isConfirmed) {
                let form = $("#formSelected");
                ajax_setup()
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: $(form).serialize(),
                    beforeSend: function () {
                        block();
                    },
                    success: function (res) {
                        refresh = true
                        unblock();
                        table.ajax.reload();
                        Swal.fire(
                            'Success!',
                            res.message,
                            'success'
                        )
                    },
                    error: function (xhr, status, error) {
                        unblock();
                        handleResponse(xhr)
                    }
                });
            }
        })
    }
}

function delete_data(){
    Swal.fire({
        title: 'Are you sure?',
        text: "Data Will be Lost!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
        confirmButtonAriaLabel: 'Thumbs up, Yes!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
        cancelButtonAriaLabel: 'Thumbs down',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        padding: '2em',
        customClass: 'animated tada',
        showClass: {
            popup: `animated tada`
        },
    }).then((result) => {
        if (result.isConfirmed) {
            ajax_setup();
            $.ajax({
                type: 'DELETE',
                url: url_index_api + "/" + id,
                beforeSend: function () {
                    block();
                },
                success: function (res) {
                    refresh = true
                    unblock();
                    $('#modalEdit').modal('hide')
                    show_index()
                    table.ajax.reload();
                    Swal.fire(
                        'Success!',
                        res.message,
                        'success'
                    )
                },
                error: function (xhr, status, error) {
                    unblock();
                    handleResponse(xhr)
                }
            });
        }
    })
}

function action_reset() {
    clear_validate('form')
    $('#form select').val('').trigger('change');
}

function clear_validate(formID) {
    let form = $('#' + formID);
    form.find('.error.invalid-feedback').each(function() {
        $(this).hide().text('');
    });
    form.find('input.is-invalid, textarea.is-invalid, select.is-invalid').each(function() {
        $(this).removeClass('is-invalid');
        $(this).removeClass('is-valid');
    });
}

function reset() {
    $('#reset').click();
    $('#gen_reset').click();
}

function ajax_setup() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });
}


function send_ajax(formID, method) {
    ajax_setup()
    let data = new FormData($('#' + formID)[0])
    data.append('_method', method)
    $.ajax({
        url: $('#' + formID).attr('action'),
        method: 'POST',
        processData: false,
        contentType: false,
        data: data,
        beforeSend: function () {
            block();
            clear_validate(formID)
        },
        success: function (res) {
            refresh = true
            unblock();
            show_index()
            if(typeof(table) != 'undefined'){
                table.ajax.reload();
            }
            reset();
            show_alert(res.message, 'success')
        },
        error: function (xhr, status, error) {
            unblock();
            handleResponseForm(xhr, formID)
        }
    })
}

function send_ajax_only(formID, method) {
    ajax_setup()
    let data = new FormData($('#' + formID)[0])
    data.append('_method', method)
    $.ajax({
        url: $('#' + formID).attr('action'),
        method: 'POST',
        processData: false,
        contentType: false,
        data: data,
        beforeSend: function () {
            block();
            clear_validate(formID)
        },
        success: function (res) {
            unblock()
            show_alert(res.message, 'success')
        },
        error: function (xhr, status, error) {
            unblock();
            handleResponseForm(xhr, formID)
        }
    })
}

function send_ajax_url(url, method, data=[], alert = true) {
    ajax_setup()
    $.ajax({
        url: url,
        method: method,
        processData: false,
        contentType: false,
        data: data,
        beforeSend: function () {
            block();
        },
        success: function (res) {
            unblock()
            if(alert){
                show_alert(res.message, 'success')
            }
            if(typeof(table) != 'undefined'){
                table.ajax.reload();
            }
        },
        error: function (xhr, status, error) {
            unblock();
            handleResponse(xhr)
        }
    })
}

// function send_delete(url) {
//     ajax_setup()
//     $.ajax({
//         url: url,
//         type: 'DELETE',
//         success: function(result) {
//             show_toast('success', result.message || 'Success!')
//             table.ajax.reload()
//         },
//         error: function(xhr, status, error) {
//             show_toast('error', xhr.responseJSON.message || 'Server Error!')
//         }
//     })
// }

function readURL(formID, inputName) {
    let obj = $(`#${formID} input[name="${inputName}"]`);
    if(obj.length < 0){
        return
    }
    if (obj[0].files && obj[0].files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#'+ formID +' .image_preview').show()
            $('#'+ formID +' .image_preview').attr('src', e.target.result)
        };
        reader.readAsDataURL(obj[0].files[0]);
    }
}

function formatBytes(size) {
    var unit = [
        'Byte',
        'KiB',
        'MiB',
        'GiB',
        'TiB',
        'PiB',
        'EiB',
        'ZiB',
        'YiB'
    ];
    for (i = 0; size >= 1024 && i <= unit.length; i++) {
        size = size / 1024;
    }
    return parseFloat(size).toFixed(2) + ' ' + unit[i];
}

function cekBytes(size) {
    var unit = [
        'B',
        'K',
        'M',
        'G',
        'T',
        'P',
        'E',
        'Z',
        'Y'
    ];
    for (i = 0; size >= 1000 && i <= unit.length; i++) {
        size = size / 1000;
    }
    return {
        unit: unit[i],
        value: size
    }
}

function dtm(str) {
    if (str != null) {
        const weekIndex = str.indexOf("w")
        const dayIndex = str.indexOf("d")
        const hourIndex = str.indexOf("h")
        const minuteIndex = str.indexOf("m")
        const secondIndex = str.indexOf("s")
        let weeks = 0
        let days = 0
        let hours = 0
        let minutes = 0
        let seconds = 0
        let final = ''

        if (weekIndex !== -1) {
            weeks = Number(str.substring(0, weekIndex))
        }

        if (dayIndex !== -1) {
            if (weekIndex !== -1) {
                days = Number(str.substring(weekIndex + 1, dayIndex))
            } else {
                days = Number(str.substring(0, dayIndex))
            }
        }

        if (hourIndex !== -1) {
            if (dayIndex !== -1) {
                hours = Number(str.substring(dayIndex + 1, hourIndex))
            } else if (weekIndex !== -1) {
                hours = Number(str.substring(weekIndex + 1, hourIndex))
            } else {
                hours = Number(str.substring(0, hourIndex))
            }
        }

        if (minuteIndex !== -1) {
            if (hourIndex !== -1) {
                minutes = Number(str.substring(hourIndex + 1, minuteIndex))
            } else {
                minutes = Number(str.substring(0, minuteIndex))
            }
        }
        if (secondIndex !== -1) {
            if (minuteIndex !== -1) {
                seconds = Number(str.substring(minuteIndex + 1, secondIndex))
            } else if (hourIndex !== -1) {
                seconds = Number(str.substring(hourIndex + 1, secondIndex))
            } else {
                seconds = Number(str.substring(0, secondIndex))
            }
        }

        let h = hours
        let m = minutes
        let s = seconds
        if (hours < 10) {
            h = '0' + hours
        }
        if (minutes < 10) {
            m = '0' + minutes
        }
        if (seconds < 10) {
            s = '0' + seconds
        }
        // if (weeks == 0 && days == 0) {
        //     final = `${h}:${m}:${s}`
        // } else if (weeks == 0 && days > 0) {
        //     final = `${days}d ${h}:${m}:${s}`
        // } else {
        //     final = `${weeks}w ${days}d ${h}:${m}:${s}`
        // }
        // console.log(str)
        // console.log(Number(str.substring(weekIndex + 1, hourIndex)))
        // console.log(`days : ${days}, hour = ${hourIndex}`)
        if (days == 0 && weeks < 1) {
            final = `${h}:${m}:${s}`
        } else {
            final = `${(weeks * 7 + days)}d ${h}:${m}:${s}`
        }
        // console.log('data : ' + str)
        // console.log('week : ' + weeks)
        // console.log('day : ' + days)
        // console.log('hour : ' + hours)
        // console.log('min : ' + minutes)
        // console.log('sec : ' + seconds)
        // console.log('fin : ' + final)
        // console.log((weeks * 7) + (days * 86400) + (hours * 3600 + minutes * 60 + seconds));
        return final
    } else {
        return '00:00:00'
    }
}

function parsedtm(str) {
    if (str != null) {
        const weekIndex = str.indexOf("w")
        const dayIndex = str.indexOf("d")
        const hourIndex = str.indexOf("h")
        const minuteIndex = str.indexOf("m")
        const secondIndex = str.indexOf("s")
        let weeks = 0
        let days = 0
        let hours = 0
        let minutes = 0
        let seconds = 0
        let final = {}

        if (weekIndex !== -1) {
            weeks = Number(str.substring(0, weekIndex))
        }

        if (dayIndex !== -1) {
            if (weekIndex !== -1) {
                days = Number(str.substring(weekIndex + 1, dayIndex))
            } else {
                days = Number(str.substring(0, dayIndex))
            }
        }

        if (hourIndex !== -1) {
            if (dayIndex !== -1) {
                hours = Number(str.substring(dayIndex + 1, hourIndex))
            } else {
                hours = Number(str.substring(0, hourIndex))
            }
        }

        if (minuteIndex !== -1) {
            if (hourIndex !== -1) {
                minutes = Number(str.substring(hourIndex + 1, minuteIndex))
            } else {
                minutes = Number(str.substring(0, minuteIndex))
            }
        }
        if (secondIndex !== -1) {
            if (minuteIndex !== -1) {
                seconds = Number(str.substring(minuteIndex + 1, secondIndex))
            } else if (hourIndex !== -1) {
                seconds = Number(str.substring(hourIndex + 1, secondIndex))
            } else {
                seconds = Number(str.substring(0, secondIndex))
            }
        }

        let h = hours
        let m = minutes
        let s = seconds
        if (hours < 10) {
            h = '0' + hours
        }
        if (minutes < 10) {
            m = '0' + minutes
        }
        if (seconds < 10) {
            s = '0' + seconds
        }
        if (days == 0) {
            final = {
                day: 0,
                time: `${h}:${m}:${s}`
            }
        } else {
            final = {
                day: weeks * 7 + days,
                time: `${h}:${m}:${s}`
            }
        }
        return final
    } else {
        return {
            day: 0,
            time: '00:00:00'
        }
    }
}

function add_detail(data, id_table){
    $(`#${id_table}`).empty()
    Object.keys(data).forEach(function(key) {
        const value = data[key];

        if (Array.isArray(value)) {
            value.forEach(function(item, index) {
                $(`#${id_table}`).append(`
                <tr>
                    <td style="width:30%">${key} [${index + 1}]</td>
                    <td style="width:2%">:</td>
                    <td style="width:68%">${item}</td>
                </tr>`);
            });
        } else if (typeof value === 'object' && value !== null) {
            Object.keys(value).forEach(function(subKey) {
                $(`#${id_table}`).append(`
                <tr>
                    <td style="width:30%">${key}.${subKey}</td>
                    <td style="width:2%">:</td>
                    <td style="width:68%">${value[subKey]}</td>
                </tr>`);
            });
        } else {
            $(`#${id_table}`).append(`
            <tr>
                <td style="width:30%">${key}</td>
                <td style="width:2%">:</td>
                <td style="width:68%">${value}</td>
            </tr>`);
        }
    });
}