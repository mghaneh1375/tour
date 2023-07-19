@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>عنوان</title>
    <script src="{{asset('js/ckeditor5/ckeditor5.js')}}"></script>
@endsection


@section('body')
    <div class="row">
        <div class="col-md-12">

            <div class="mainBackWhiteBody">
                <div class="head">متن قرارداد</div>
                <div>
                    <div class="toolbar-container"></div>
                    <div id="description" class="textEditor" style="width: 80%; height: 250px; overflow: auto; display: block">{!! html_entity_decode($contract->description) !!}</div>
                    <input style="margin-top: 20px;" type="submit" onclick="submit()" class="btn btn-success" value="تایید">
                </div>
            </div>

        </div>
    </div>

    <script>

        function submit() {
            $.ajax({
                "type": "post",
                "url": "{{route('businessPanel.editContract', ['contract' => $contract->id])}}",
                data: {
                    description: $("#description").html()
                },
                success: function (res) {

                    if (res.status === "ok")
                        document.location.href = '{{route('businessPanel.contracts')}}';
                    else
                        showSuccessNotifiBP("خطایی در انجام عملیات مورد نظر رخ داده است.", 'right', '#ac0020');

                }
            });
        }

        $(document).ready(function () {

            DecoupledEditor.create( document.querySelector('#description'), {
                language: '{{app()->getLocale()}}',
                removePlugins: [ 'FontSize', 'MediaEmbed' ],
            })
                .then( editor => {
                    const toolbarContainer = document.querySelector( '.toolbar-container');
                    toolbarContainer.prepend( editor.ui.view.toolbar.element );
                    window.editor = editor;
                })
                .catch( err => {
                    console.error( err.stack );
                });

        });

    </script>

@endsection
