@if (Session::get('alert'))
    <div id="alert-modal" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">{{ $title }}</h2>
            </div>
            <div class="uk-modal-body">
                <p>{{ $subtitle }}
                </p>
            </div>
            <div class="uk-modal-footer uk-text-center">
                <button class="uk-button uk-button-primary uk-modal-close" type="button">Ok</button>
            </div>
        </div>
    </div>

    <script>
        UIkit.modal($('#alert-modal').get(0)).show();
    </script>
@endif
