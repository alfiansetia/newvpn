@extends('layouts.backend.template', ['title' => 'Data Voucher Template'])
@push('csslib')
    <!-- DATATABLE -->
    <link href="{{ asset('backend/src/plugins/datatable/datatables.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/plugins/src/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/plugins/css/light/table/datatable/dt-global_style.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <link href="{{ asset('backend/src/assets/css/dark/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('backend/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css">


    <link href="{{ asset('backend/src/plugins/editor/editor.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        .cm-s-material.CodeMirror {
            background-color: #263238;
            color: rgba(233, 237, 237, 1);
        }

        .cm-s-material .CodeMirror-gutters {
            background: #263238;
            color: #537f7e;
            border: none;
        }

        .cm-s-material .CodeMirror-guttermarker,
        .cm-s-material .CodeMirror-guttermarker-subtle,
        .cm-s-material .CodeMirror-linenumber {
            color: #537f7e;
        }

        .cm-s-material .CodeMirror-cursor {
            border-left: 1px solid #f8f8f0;
        }

        .cm-s-material div.CodeMirror-selected {
            background: rgba(255, 255, 255, 0.15);
        }

        .cm-s-material.CodeMirror-focused div.CodeMirror-selected {
            background: rgba(255, 255, 255, 0.1);
        }

        .cm-s-material .CodeMirror-line::selection,
        .cm-s-material .CodeMirror-line>span::selection,
        .cm-s-material .CodeMirror-line>span>span::selection {
            background: rgba(255, 255, 255, 0.1);
        }

        .cm-s-material .CodeMirror-line::-moz-selection,
        .cm-s-material .CodeMirror-line>span::-moz-selection,
        .cm-s-material .CodeMirror-line>span>span::-moz-selection {
            background: rgba(255, 255, 255, 0.1);
        }

        .cm-s-material .CodeMirror-activeline-background {
            background: rgba(0, 0, 0, 0);
        }

        .cm-s-material .cm-keyword {
            color: rgba(199, 146, 234, 1);
        }

        .cm-s-material .cm-operator {
            color: rgba(233, 237, 237, 1);
        }

        .cm-s-material .cm-variable-2 {
            color: #80cbc4;
        }

        .cm-s-material .cm-builtin {
            color: #decb6b;
        }

        .cm-s-material .cm-atom,
        .cm-s-material .cm-number {
            color: #f77669;
        }

        .cm-s-material .cm-def {
            color: rgba(233, 237, 237, 1);
        }

        .cm-s-material .cm-string {
            color: #c3e88d;
        }

        .cm-s-material .cm-string-2 {
            color: #80cbc4;
        }

        .cm-s-material .cm-comment {
            color: #546e7a;
        }

        .cm-s-material .cm-variable {
            color: #82b1ff;
        }

        .cm-s-material .cm-meta,
        .cm-s-material .cm-tag {
            color: #80cbc4;
        }

        .cm-s-material .cm-attribute {
            color: #ffcb6b;
        }

        .cm-s-material .cm-property {
            color: #80cbae;
        }

        .cm-s-material .cm-qualifier,
        .cm-s-material .cm-type,
        .cm-s-material .cm-variable-3 {
            color: #decb6b;
        }

        .cm-s-material .cm-tag {
            color: rgba(255, 83, 112, 1);
        }

        .cm-s-material .cm-error {
            color: rgba(255, 255, 255, 1);
            background-color: #ec5f67;
        }

        .cm-s-material .CodeMirror-matchingbracket {
            text-decoration: underline;
            color: #fff !important;
        }
    </style>
@endpush
@section('content')
    <div class="row" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing" id="card_table">
            <div class="widget-content widget-content-area br-8">
                <form action="" id="formSelected">
                    <table id="tableData" class="table dt-table-hover table-hover" style="width:100%; cursor: pointer;">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

        @include('template.add')
        @include('template.edit')
        @include('template.detail')
    </div>
@endsection
@push('jslib')
    <script src="{{ asset('backend/src/plugins/datatable/datatables.min.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->

    <script src="{{ asset('backend/src/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/src/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/src/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

    <script src="{{ asset('backend/src/plugins/editor/editor.min.js') }}"></script>
@endpush


@push('js')
    <script src="{{ asset('js/v2/var.js') }}"></script>
    <script src="{{ asset('js/v2/navigation.js') }}"></script>
    <script src="{{ asset('js/v2/func.js') }}"></script>
    <script>
        const url_index = "{{ route('template.index') }}"
        const url_index_api = "{{ route('api.template.index') }}"
        var id = 0
        var perpage = 50

        // $(document).ready(function() {
        var element_ids = ['html_vc', 'html_up', 'edit_html_up', 'edit_html_vc', 'header', 'footer', 'edit_header',
            'edit_footer'
        ]

        element_ids.forEach(element => {
            var editor = CodeMirror.fromTextArea(document.getElementById(element), {
                lineNumbers: true,
                matchBrackets: true,
                mode: 'htmlmixed',
                theme: 'material',
                indentUnit: 4,
                indentWithTabs: true,
                lineWrapping: true,
                viewportMargin: Infinity,
                matchTags: {
                    bothTags: true
                },
                extraKeys: {
                    "Ctrl-J": 'toMatchingTag'
                }
            });
            $(`#${element}`).data('CodeMirrorInstance', editor);
        });


        // $('#edit_delete').after(
        //     `<button type="button" class="btn btn-info show-detail ms-2 mb-2"><i
    //    class="fas fa-info me-1 bs-tooltip" title="Detail"></i>Detail</button>`
        // )

        $('#reset').click(function() {

            let element = ['html_up', 'html_vc', 'header', 'footer'];
            element.forEach(item => {
                $(`#${item}`).data('CodeMirrorInstance').setValue('')
                $(`#${item}`).data('CodeMirrorInstance').refresh('')
            });
        })

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url_index_api,
                error: function(jqXHR, textStatus, errorThrown) {
                    handleResponseCode(jqXHR)
                },
            },
            columnDefs: [{
                defaultContent: '',
                targets: "_all"
            }],
            lengthChange: false,
            buttons: [{
                extend: "pageLength",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Page Length'
                },
                className: 'btn btn-sm btn-info'
            }, {
                text: '<i class="fas fa-plus"></i> Add',
                className: 'btn btn-primary',
                action: function(e, dt, node, config) {
                    show_card_add()
                    input_focus('name')
                    $('#reset').click()
                },
            }, {
                text: '<i class="fas fa-caret-down"></i>',
                extend: 'collection',
                className: 'btn btn-warning',
                buttons: [{
                    text: 'Delete Selected Data',
                    action: function(e, dt, node, config) {
                        delete_batch(url_index_api);
                    }
                }]
            }],
            dom: dom,
            stripeClasses: [],
            lengthMenu: length_menu,
            pageLength: 10,
            oLanguage: o_lang,
            sPaginationType: 'simple_numbers',
            columns: [{
                    width: "30px",
                    title: 'Id',
                    data: 'id',
                    className: "",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return `
                    <div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" name="id[]" value="${data}" >
                    </div>`
                    }
                }, {
                    title: "Name",
                    data: 'name',
                    className: 'text-start',
                },
                {
                    title: "Preview",
                    data: 'id',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return `<a href="{{ route('template.index') }}/${data}" onclick="window.open(this.href, 'newwindow', 'width=500,height=500'); return false;" class="btn btn-sm btn-info" target="_blank" >Preview</a>`
                    }
                }
            ],
            headerCallback: function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML = `
                <div class="form-check form-check-primary d-block new-control">
                    <input class="form-check-input chk-parent" type="checkbox" id="customer-all-info">
                </div>`
            },
            drawCallback: function(settings) {
                feather.replace();
                tooltip()
            },
            initComplete: function() {
                feather.replace();
            }
        });

        multiCheck(table);

        $('#tableData tbody').on('click', 'tr td:not(:first-child,:last-child)', function() {
            id = table.row(this).id()
            $('#formEdit').attr('action', url_index_api + "/" + id)
            edit(true)
        });

        function edit(show = false) {
            clear_validate('formEdit')
            $.ajax({
                url: url_index_api + "/" + id,
                method: 'GET',
                success: function(result) {
                    unblock();
                    $('#edit_name').val(result.data.name);
                    $('#detail_html_up').html(result.data.html_up_sample);
                    $('#detail_html_vc').html(result.data.html_vc_sample);

                    var edit_html_up = $('#edit_html_up').data('CodeMirrorInstance');
                    var edit_html_vc = $('#edit_html_vc').data('CodeMirrorInstance');
                    var edit_header = $('#edit_header').data('CodeMirrorInstance');
                    var edit_footer = $('#edit_footer').data('CodeMirrorInstance');
                    if (result.data.html_up) {
                        edit_html_up.setValue(result.data.html_up);
                    } else {
                        edit_html_up.setValue('');
                    }

                    if (result.data.html_vc) {
                        edit_html_vc.setValue(result.data.html_vc);
                    } else {
                        edit_html_vc.setValue('');
                    }

                    if (result.data.header) {
                        edit_header.setValue(result.data.header);
                    } else {
                        edit_header.setValue('');
                    }
                    if (result.data.footer) {
                        edit_footer.setValue(result.data.footer);
                    } else {
                        edit_footer.setValue('');
                    }

                    if (show) {
                        show_card_edit()
                        refresh_code()
                        input_focus('name')
                    }
                },
                beforeSend: function() {
                    block();
                },
                error: function(xhr, status, error) {
                    unblock();
                    handleResponse(xhr)
                }
            });
        }

        $('.show-edit').click(function() {
            refresh_code()
        })

        function refresh_code() {
            setTimeout(() => {
                let element = ['edit_html_up', 'edit_html_vc', 'edit_header', 'edit_footer'];
                element.forEach(item => {
                    $(`#${item}`).data('CodeMirrorInstance').refresh()
                });
            }, 1);
        }

        // });
    </script>
    <script src="{{ asset('js/v2/trigger.js') }}"></script>
@endpush
